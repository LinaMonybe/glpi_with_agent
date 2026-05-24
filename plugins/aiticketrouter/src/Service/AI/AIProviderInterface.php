<?php

namespace GlpiPlugin\Aiticketrouter\Service\AI;

interface AIProviderInterface
{
    /**
     * Analyse un ticket via l'IA et retourne les indicateurs qualifiés.
     *
     * @param string $title
     * @param string $content
     * @return array|null Tableau associatif contenant ['category', 'urgency', 'impact', 'priority'] ou null en cas d'erreur.
     */
    public function analyzeTicket(string $title, string $content): ?array;

    /**
     * Suggère des pistes de résolution basées sur le contexte.
     *
     * @param string $category
     * @param string $text
     * @return string|null
     */
    public function getSolutions(string $category, string $text): ?string;
}
