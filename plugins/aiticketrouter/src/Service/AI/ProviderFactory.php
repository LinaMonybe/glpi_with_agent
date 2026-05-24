<?php

namespace GlpiPlugin\Aiticketrouter\Service\AI;

use GlpiPlugin\Aiticketrouter\Config\PluginConfig;

class ProviderFactory
{
    /**
     * Instancie le fournisseur d'IA actif en fonction de la configuration.
     *
     * @return AIProviderInterface
     */
    public static function create(): AIProviderInterface
    {
        $activeProvider = PluginConfig::getConfig('active_ai_provider', 'gemini');

        switch ($activeProvider) {
            case 'openai':
                return new OpenAIProvider();
            case 'ollama':
                return new OllamaProvider();
            case 'claude':
                return new ClaudeProvider();
            case 'gemini':
            default:
                return new GeminiProvider();
        }
    }
}
