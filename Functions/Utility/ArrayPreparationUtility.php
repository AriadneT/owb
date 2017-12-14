<?php
/**
 * @param array $array
 * @param array $formEntries
 * @param array $settings
 * @param PDO $databaseConnection
 * @return array $replacements
 */
function assignInformation($array, $formEntries, $settings, $databaseConnection)
{
    list($configurations, $localisations) = $settings;

    // Predetermined labels in array $replacements depend on the language and units entered in form (session settings)
    $replacements = $localisations['language'][$formEntries['language']]['replacements'];
    if (isset($_SESSION['language'])) {
        $replacements = selectRadioButtons($configurations, $replacements);
    }

    foreach ($array as $key => $value) {
        // Ignore keys and associated values if they are unwanted
        if ($configurations['defaults']['fields'][$key]['use']) {
            // Gather info relevant to key and array $replacements
            $keyInfo = $configurations['defaults']['fields'][$key];
            if ($keyInfo['isDateTime']) {
                // Convert seconds to date and time, depending on the language selected
                $replacements['###' . $keyInfo['templateEntry'] . '###'] =
                    ConvertSecondsToDateTime($value, $formEntries, $localisations);
            } elseif ($keyInfo['picture']) {
                $replacements = preparePictures($value, $replacements);
                // <body></body> in template has a different id depending on weather description
                $replacements['###' . $keyInfo['templateEntry'] . '###'] =
                    selectBackgroundImage($value, $configurations);
            } elseif ($keyInfo['notNumber']) {
                if ($keyInfo['capitalise']) {
                    if (isset($array['spoken_language'])) {
                        // If array from database, try to ensure weather description is in the correct language
                        $replacements['###' . $keyInfo['templateEntry'] . '###'] =
                            assignDescription($formEntries['language'], $array, $databaseConnection);
                    } else {
                        // Otherwise, just capitalise first letter of weather description
                        $replacements['###' . $keyInfo['templateEntry'] . '###'] = capitaliseFirstLetter($value);
                    }
                } else {
                    $replacements['###' . $keyInfo['templateEntry'] . '###'] = $value;
                }
            } else {
                if ($keyInfo['hasUnit'] == 'units specific') {
                    /*
                     * Add m/s or mph to wind speed, or °C or °F to temperature, depending on units chosen.
                     * Number conversion possible. Number format may depend on language.
                     */
                    $replacements['###' . $keyInfo['templateEntry'] . '###'] =
                        addMetricOrImperialUnit(number_format($value, $keyInfo['decimals'],
                            $localisations['language'][$formEntries['language']]['decimals'],
                            $localisations['language'][$formEntries['language']]['thousands']), $key,
                            $formEntries['units'], $configurations);
                    if ($keyInfo['wind']) {
                        $replacements = depictWindSpeed($value, $configurations, $formEntries['units'], $replacements);
                    }
                } else {
                    // Ensure null values from database not given units
                    if (!is_null($value)) {
                        // Add m to visibility, mm to precipitation, ° to wind direction, hPa to pressure, % to humidity
                        $replacements['###' . $keyInfo['templateEntry'] . '###'] = addUnit(number_format($value,
                            $keyInfo['decimalPlaces'], $localisations['language'][$formEntries['language']]['decimals'],
                            $localisations['language'][$formEntries['language']]['thousands']), $keyInfo['hasUnit']);
                    }
                    if ($keyInfo['wind']) {
                        // Rotate arrow by x degrees. The arrow must be turned -90° first because it faces right.
                        $replacements['###ROTATION###'] = (-90 + $value) . 'deg';
                    }
                }
            }
        }
    }
    return $replacements;
}
