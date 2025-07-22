<?php
// app/Helpers/helpers.php

if (!function_exists('highlightSearchTerm')) {
    /**
     * Highlight search term in text
     *
     * @param string $text
     * @param string $searchTerm
     * @return string
     */
    function highlightSearchTerm($text, $searchTerm)
    {
        if (empty($searchTerm)) {
            return e($text);
        }

        $highlightedText = preg_replace(
            '/(' . preg_quote($searchTerm, '/') . ')/i',
            '<mark class="bg-yellow-200 text-yellow-900 px-1 rounded">$1</mark>',
            e($text)
        );

        return $highlightedText;
    }
}

// Add more helper functions here
if (!function_exists('formatCurrency')) {
    function formatCurrency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
