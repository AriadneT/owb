<?php
/**
 * @param string $motherTongue
 * @param array $entry
 * @param PDO $databaseConnection
 * @return string $value
 */
function assignDescription($motherTongue, $entry, $databaseConnection)
{
    // If language requested is different from the language entered, look up correct description in database
    if ($motherTongue != $entry['spoken_language']) {
        $value = translateDescription($motherTongue, $entry, $databaseConnection);
    } else {
        $value = capitaliseFirstLetter($entry['weather_description']);
    }

    return $value;
}

/**
 * @param string $value
 * @param array $replacements
 * @return array $replacements
 */
function preparePictures($value, $replacements)
{
    // Get small image/icon depicting the weather description
    $replacements['###ICON###'] = 'Resources/Public/Images/' . $value . '.png';

    // Get background image
    $replacements['###BACKGROUND###'] = 'Resources/Public/Images/' . $value . '.jpg';

    // Get photographer's name from exif data of background jpg image
    $exif = exif_read_data($replacements['###BACKGROUND###']);
    // When JavaScript is used, another path is used
    if ($exif == false) {
        $exif = exif_read_data('../../Resources/Public/Images/' . $value . '.jpg');
    }
    $replacements['###PHOTOGRAPHER###'] = $exif['Artist'];

    return $replacements;
}

/**
 * @param string $value
 * @param array $configurations
 * @return string
 */
function selectBackgroundImage($value, $configurations)
{
    return $configurations['body'][$value];
}

/**
 * @param float $windSpeed
 * @param array $configurations
 * @param string $units
 * @param array $replacements
 * @return array $replacements
 */
function depictWindSpeed($windSpeed, $configurations, $units, $replacements)
{
    /*
     * Different wind speeds results in different classes for the arrow/compass.
     * Each class gives the arrow a different colour that indicates the relevant amount of danger.
     */
    if ($windSpeed < $configurations['units'][$units]['breeze']) {
        $replacements['###ARROW_HEAD###'] = 'breezeHead';
        $replacements['###ARROW_SHAFT###'] = 'breezeShaft';
    } elseif ($windSpeed < $configurations['units'][$units]['highWind']) {
        $replacements['###ARROW_HEAD###'] = 'highWindHead';
        $replacements['###ARROW_SHAFT###'] = 'highWindShaft';
    } elseif ($windSpeed < $configurations['units'][$units]['gale']) {
        $replacements['###ARROW_HEAD###'] = 'galeHead';
        $replacements['###ARROW_SHAFT###'] = 'galeShaft';
    } elseif ($windSpeed < $configurations['units'][$units]['storm']) {
        $replacements['###ARROW_HEAD###'] = 'stormHead';
        $replacements['###ARROW_SHAFT###'] = 'stormShaft';
    } else {
        $replacements['###ARROW_HEAD###'] = 'hurricaneHead';
        $replacements['###ARROW_SHAFT###'] = 'hurricaneShaft';
    }

    return $replacements;
}

/**
 * @param array $configurations
 * @param array $replacements
 * @return array $replacements
 */
function selectRadioButtons($configurations, $replacements)
{
    $replacements['###CHECK_OPTION_' . strtoupper($_SESSION['language']) . '###'] = 'checked';
    $replacements['###CHECK_OPTION_' . strtoupper($_SESSION['units']) . '###'] = 'checked';

    // All other radio buttons given no value instead of "n. a." for cleaner HTML
    $checkedOptions = $configurations['defaults']['checkedOptions'];
    foreach ($checkedOptions as $option) {
        if ($replacements[$option] != 'checked') {
            $replacements[$option] = '';
        }
    }

    return $replacements;
}

/**
 * @param array $replacements
 * @param array $formEntries
 * @return array $replacementsForJson
 */
function formatReplacementsForJavaScript($replacements, $formEntries)
{
    // Add data from $formEntries (i.e. form) because $replacements does not specify the relevant language
    $replacements = array_merge($replacements, $formEntries);

    // Format $replacements for JSON
    $replacementsForJson = [];
    foreach ($replacements as $key => $value) {
        // Skip API to avoid revealing the API key by accident
        if ($key == 'api') {
            continue;
        }
        // '###' cannot be used in JavaScript and so must be removed
        $newKey = str_replace('###', '', $key);
        $replacementsForJson[$newKey] = $replacements[$key];
        unset($replacements[$key]);
    }

    return $replacementsForJson;
}

/**
 * @param string $description
 * @return string $text
 */
function capitaliseFirstLetter($description)
{
    $text = ucfirst($description);

    /*
     * Search and alter weather descriptions when they do not start with an English letter,
     * as these are not capitalised. So far, only "überwiegend bewölkt" is known, but if more emerge,
     * appropriate changes will be necessary to the code below.
     */
    if (!preg_match('/[A-Z]/', $text)) {
        $text = 'Ü' . substr($text, 2);
    }

    return $text;
}
