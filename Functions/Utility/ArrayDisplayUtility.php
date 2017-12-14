<?php
/**
 * @param array $replacements
 * @param array $settings
 * @param string $motherTongue
 * @return string $allHtmlContent
 */
function showVariables($replacements, $settings, $motherTongue)
{
    list($configurations, $localisations) = $settings;

    $allHTMLContent = assembleHTMLTemplate($replacements, $configurations);

    // Find all words to be replaced. These have '###' before and after the word(s) and use '_' for spacing.
    $splitHTMLContent = preg_split('/["()<> :,;&]/', $allHTMLContent);
    $toReplace = [];
    foreach ($splitHTMLContent as $subset) {
        if (preg_match('/###[A-Z_]+###/', $subset)) {
            $toReplace[] = $subset;
        }
    }

    // Replace words to be replaced with labels and results from $replacements
    foreach ($replacements as $key => $value) {
        foreach ($toReplace as $entry) {
            if (preg_match('/' . $entry . '/', $key)) {
                $allHTMLContent = str_replace($entry, $value, $allHTMLContent);
                break;
            }
        }
    }

    // Any remaining words to be replaced to be given "n. a." in relevant language
    $secondSplit = preg_split('/["()<> :,;&]/', $allHTMLContent);
    foreach ($secondSplit as $word) {
        if (preg_match('/###[A-Z_]+###/', $word)) {
            $allHTMLContent = str_replace($word, $localisations['language'][$motherTongue]['NA'], $allHTMLContent);
        }
    }

    return $allHTMLContent;
}
