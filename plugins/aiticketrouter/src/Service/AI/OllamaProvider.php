<?php
namespace GlpiPlugin\Aiticketrouter\Service\AI;

use GlpiPlugin\Aiticketrouter\Config\PluginConfig;

class OllamaProvider implements AIProviderInterface {

    public function analyzeTicket(string $title, string $content): ?array {
        $url = PluginConfig::getConfig('ollama_url', 'http://127.0.0.1:11434/api/generate');
        if (empty($url)) return null;

        $prompt = "Analyse ce ticket de support technique et retourne UNIQUEMENT un JSON valide.
        
TITRE: {$title}
Retourne UNIQUEMENT ce format JSON:
{\"category\": \"categorie\", \"urgency\": nombre, \"impact\": nombre, \"priority\": nombre}

Règles:
- category: donne un nom de catégorie précis et pertinent en Français (ex: Base de données, Réseau, Logiciel, Matériel, Cloud, etc.)
- urgency: nombre entre 1 et 5 (1=très basse, 5=très haute)
- impact: nombre entre 1 et 5 (1=très faible, 5=majeur)
- priority: nombre entre 1 et 5

Texte du ticket:
Titre: {$title}
Description: {$content}";

        $response = $this->callApi($prompt);

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
        $prompt = "Tu es un technicien IT expert. Un ticket de support a été classifié dans la catégorie '{$category}'.

Contenu du ticket : {$texte}

Génère 4 à 5 pistes de résolution concrètes et adaptées à ce ticket. Soit bref. Réponse en HTML (<ul><li>...</li></ul>). Aucune intro ou outro.";

        return $this->callApi($prompt);
    }

    private function callApi(string $prompt): ?string {
        $baseUrl = trim(PluginConfig::getConfig('ollama_url', 'http://127.0.0.1:11434/api/generate'));
        $model = trim(PluginConfig::getConfig('ollama_model', 'llama3'));
        $timeout = (int)PluginConfig::getConfig('ollama_timeout', 30);
        $temperature = (float)PluginConfig::getConfig('ollama_temperature', 0.2);

        if (empty($baseUrl)) return null;

        $data = [
            'model' => $model,
            'prompt' => $prompt,
            'stream' => false,
            'options' => [
                'temperature' => $temperature
            ]
        ];

        $ch = curl_init($baseUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        $response  = curl_exec($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $result = json_decode($response, true);
            return $result['response'] ?? null;
        }

        return null;
    }
}
