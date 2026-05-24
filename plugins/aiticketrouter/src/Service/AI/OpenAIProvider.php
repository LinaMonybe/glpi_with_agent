<?php
namespace GlpiPlugin\Aiticketrouter\Service\AI;

use GlpiPlugin\Aiticketrouter\Config\PluginConfig;

class OpenAIProvider implements AIProviderInterface {

    public function analyzeTicket(string $title, string $content): ?array {
        $api_key = PluginConfig::getConfig('openai_api_key', '');
        if (empty($api_key)) return null;

        $prompt = "Analyse ce ticket de support technique et retourne UNIQUEMENT un JSON valide.
        
TITRE: {$title}

Retourne UNIQUEMENT ce format JSON (identique):
{\"category\": \"categorie\", \"urgency\": nombre, \"impact\": nombre, \"priority\": nombre}

Règles:
- category: donne un nom de catégorie précis et pertinent en Français (ex: Base de données, Réseau, Logiciel, Matériel, Cloud, etc.)
- urgency: nombre entre 1 et 5 (1=très basse, 5=très haute)
- impact: nombre entre 1 et 5 (1=très faible, 5=majeur)
- priority: nombre entre 1 et 5

Texte du ticket:
Titre: {$title}
Description: {$content}";

        $response = $this->callApi($prompt, (int)PluginConfig::getConfig('openai_max_tokens', 1024));

        if ($response) {
            $cleaned = preg_replace('/```json|```/', '', $response);
            $analysis = json_decode(trim($cleaned), true);

            if ($analysis && isset($analysis['category'])) {
                return [
                    'category' => htmlspecialchars((string)($analysis['category'] ?? 'Général')),
                    'urgency'  => min(5, max(1, (int)($analysis['urgency']  ?? 3))),
                    'impact'   => min(5, max(1, (int)($analysis['impact']   ?? 3))),
                    'priority' => min(5, max(1, (int)($analysis['priority'] ?? 3))),
                ];
            }
        }

        return null;
    }

    public function getSolutions(string $category, string $texte): ?string {
        $api_key = PluginConfig::getConfig('openai_api_key', '');
        if (empty($api_key)) return null;

        $prompt = "Tu es un technicien IT expert. Un ticket de support a été classifié dans la catégorie '{$category}'.

Contenu du ticket : {$texte}

Génère 4 à 5 pistes de résolution concrètes et adaptées à ce ticket. Soit bref. Réponse en HTML (<ul><li>...</li></ul>). Aucune intro ou outro.";
        return $this->callApi($prompt, (int)PluginConfig::getConfig('openai_max_tokens', 1024));
    }

    private function callApi(string $prompt, int $maxTokens): ?string {
        $api_key = trim(PluginConfig::getConfig('openai_api_key', ''));
        $model = trim(PluginConfig::getConfig('openai_model', 'gpt-3.5-turbo'));
        $timeout = (int)PluginConfig::getConfig('openai_timeout', 15);
        $temperature = (float)PluginConfig::getConfig('openai_temperature', 0.4);

        if (empty($api_key)) return null;

        $url = "https://api.openai.com/v1/chat/completions";

        $data = [
            'model' => $model,
            'messages' => [
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => $temperature,
            'max_tokens' => $maxTokens,
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "Authorization: Bearer {$api_key}"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response  = curl_exec($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $result = json_decode($response, true);
            return $result['choices'][0]['message']['content'] ?? null;
        }

        return null;
    }
}
