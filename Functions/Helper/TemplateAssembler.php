<?php
/**
 * @param array $replacements
 * @param array $configurations
 * @return string $allHTMLContent
 */
function assembleHTMLTemplate($replacements, $configurations)
{
    $allHTMLContent = '';

    if (empty($replacements['###SUNSET_LABEL###'])) {
        // When no weather data is obtained, the HTML section giving weather details is left out
        $HTMLParts = $configurations['defaults']['errorTemplates'];
    } else {
        $HTMLParts = $configurations['defaults']['templates'];
    }

    foreach ($HTMLParts as $part) {
        // Get template files
        $allHTMLContent .= file_get_contents($part);
    }

    return $allHTMLContent;
}
