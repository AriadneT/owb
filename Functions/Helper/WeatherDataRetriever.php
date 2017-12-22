<?php
/**
 * @param array $formEntries
 * @param array $configurations
 * @return array $data
 */
function getDataFromJson($formEntries, $configurations)
{
    $data = [];

    if (isset($formEntries['city'])) {
        /*
         * Weather instead of forecast. API key given as APPID. Request for:
         * specific city (possibly in given country), unit of measurement and language; 1 record
         */
        $weatherUrl = $configurations['defaults']['url']['urlStub'] . $configurations['defaults']['entries']['api'] .
            $configurations['defaults']['url']['cityAddition'] . $formEntries['city'] . ',' . $formEntries['country'] .
            $configurations['defaults']['url']['unitsAddition'] . $formEntries['units'] .
            $configurations['defaults']['url']['languageAddition'] . $formEntries['language'] .
            $configurations['defaults']['url']['numberAddition'] . $configurations['defaults']['entries']['count'];
    }

    if (isset($weatherUrl)) {
        $json = manageCURL($weatherUrl);
    }
    if (isset($json)) {
        $originalData = json_decode($json, $configurations['defaults']['jsonDecode']);
        $data = array_values_recursive($originalData);
        // Add the id weather with a unique key because it would otherwise be overlaid by the id for city
        if (isset($originalData['weather'])) {
            $data['weather_id'] = $originalData['weather'][0]['id'];
        }
    }

    return $data;
}
