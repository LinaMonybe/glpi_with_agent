<?php
namespace GlpiPlugin\Aiticketrouter\Config;

class Environment
{
    // ⚠️ Remplacez par votre vraie clé API Gemini
    public const GEMINI_API_KEY = 'AIzaSyCLXWXCDg5P9oWloe9L0G0cAXL1L7xW--A'
        ;

    public static function getGeminiKey(): string
    {
        if (defined('PLUGIN_AITICKETROUTER_GEMINI_API_KEY')) {
            return constant('PLUGIN_AITICKETROUTER_GEMINI_API_KEY');
        }
        return self::GEMINI_API_KEY;
    }
}
