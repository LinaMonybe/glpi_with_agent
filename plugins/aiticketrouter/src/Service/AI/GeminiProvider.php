<?php
namespace GlpiPlugin\Aiticketrouter\Service\AI;

use GlpiPlugin\Aiticketrouter\Config\PluginConfig;

class GeminiProvider implements AIProviderInterface {

    public function analyzeTicket(string $title, string $content): ?array {
        $api_key = PluginConfig::getConfig('gemini_api_key', '');
        if (empty($api_key)) return null;

        $prompt = "Analyse ce ticket de support technique et retourne UNIQUEMENT un JSON valide.
        
TITRE: {$title}
DESCRIPTION: {$content}

Retourne UNIQUEMENT ce format JSON:
{\"category\": \"categorie\", \"urgency\": nombre, \"impact\": nombre, \"priority\": nombre}

Règles:
- category: donne un nom de catégorie précis et pertinent en Français (ex: Base de données, Réseau, Logiciel, Matériel, Cloud, etc.)
- urgency: nombre entre 1 et 5 (1=très basse, 5=très haute)
- impact: nombre entre 1 et 5 (1=très faible, 5=majeur)
- priority: nombre entre 1 et 5

Exemple: {\"category\": \"Reseau\", \"urgency\": 4, \"impact\": 3, \"priority\": 4}";

        $result = $this->callApi($prompt, (int)PluginConfig::getConfig('gemini_max_tokens', 1024));
        if ($result === null) return null;

        $cleaned = preg_replace('/```json|```/', '', $result);
        $analysis = json_decode(trim($cleaned), true);

        if ($analysis && isset($analysis['category'])) {
            return [
                'category' => htmlspecialchars((string)($analysis['category'] ?? 'Général')),
                'urgency'  => min(5, max(1, (int)($analysis['urgency']  ?? 3))),
                'impact'   => min(5, max(1, (int)($analysis['impact']   ?? 3))),
                'priority' => min(5, max(1, (int)($analysis['priority'] ?? 3))),
            ];
        }

        return null;
    }

    public function getSolutions(string $category, string $texte): ?string {
        $api_key = PluginConfig::getConfig('gemini_api_key', '');
        if (empty($api_key)) return null;

        $prompt = "Tu es un technicien IT expert. Un ticket de support a été classifié dans la catégorie '{$category}'.

Contenu du ticket : {$texte}

Génère 4 à 5 pistes de résolution concrètes et adaptées à ce ticket. Soit bref. Réponse en HTML (<ul><li>...</li></ul>). Aucune intro ou outro.";

        return $this->callApi($prompt, (int)PluginConfig::getConfig('gemini_max_tokens', 1024));
    }

    private function callApi(string $prompt, int $maxTokens): ?string {
        $api_key = trim(PluginConfig::getConfig('gemini_api_key', ''));
        $model = trim(PluginConfig::getConfig('gemini_model', 'gemini-2.5-flash-lite'));
        $timeout = (int)PluginConfig::getConfig('gemini_timeout', 15);
        $temperature = (float)PluginConfig::getConfig('gemini_temperature', 0.4);

        if (empty($api_key)) return null;

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$api_key}";

        $data = [
            'contents'       => [['parts' => [['text' => $prompt]]]],
            'generationConfig' => [
                'temperature'     => $temperature,
                'maxOutputTokens' => $maxTokens,
            ],
        ];

        $attempts = 0;
        $maxAttempts = 2;
        $result = null;

        while ($attempts < $maxAttempts) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response  = curl_exec($ch);
            $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error     = curl_error($ch);
            curl_close($ch);

            if ($httpCode === 200) {
                $result = json_decode($response, true);
                break;
            }

            $attempts++;
            if ($attempts < $maxAttempts && ($httpCode === 503 || $httpCode === 429)) {
                sleep(2); // Wait 2s before retry
                continue;
            }

            file_put_contents(dirname(__DIR__, 3) . '/log_ai.txt', date('Y-m-d H:i:s') . " Gemini Error HTTP $httpCode | $error | URL: $url\n", FILE_APPEND);
            return null;
        }

        return $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
    }
}
