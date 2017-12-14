<?php
/**
 * @param array $configurations
 * @return array $formEntries
 */
function prepareInitialEntries($configurations)
{
    $dataOfIPAddress = [];

    // Get any data that may be available, given user's IP address, from the geoplugin website
    $geoIPURL = "http://www.geoplugin.net/php.gp?ip=" . $_SERVER['REMOTE_ADDR'];
    if (isset($geoIPURL)) {
        $dataOfIPAddress = unserialize(manageCURL($geoIPURL));
    }

    if ($dataOfIPAddress['geoplugin_city'] != '' && $dataOfIPAddress['geoplugin_countryCode'] != '') {
        // If city and country code could be determined, use them to show weather in user's location
        $formEntries = [
            'city' => $dataOfIPAddress['geoplugin_city'],
            'country' => $dataOfIPAddress['geoplugin_countryCode'],
            //Default language and units are German and metric, respectively
            'language' => 'de',
            'units' => 'metric'
        ];
    } else {
        // Otherwise, show weather from Jena, Germany (default setting)
        $formEntries = $configurations['defaults']['entries'];
    }

    return $formEntries;
}

/**
 * @param array $settings
 * @return array $formEntries
 */
function prepareSubsequentEntries($settings)
{
    $configurations = $settings[0];

    // Check form
    checkForm($settings, $_POST['languages']);

    // Make any necessary changes to city entry
    $city = checkCity($_POST['city'], $configurations);

    // Prepare form entries for use in weather report
    $formEntries = [
        'city' => $city,
        'country' => $_POST['country'],
        'language' => $_POST['language'],
        'units' => $_POST['units']
    ];

    return $formEntries;
}
