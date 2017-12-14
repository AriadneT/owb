<?php
/**
 * @return string $output
 */
function showPage()
{
    //Set up arrays with entries necessary for configuration and localisation
    $configurations = include('Configuration/Config.php');
    $localisations = include('Resources/Private/Localisation/Localisation.php');
    $settings = [$configurations, $localisations];

    //Include all files containing functions so that they can be used.
    $filesToInclude = $configurations['filesToInclude'];
    foreach ($filesToInclude as $insert) {
        if (file_exists($insert)) {
            include($insert);
        }
    }

    /*
     * This website is in development mode.
     * If it moves to production mode, change $context to 'production' and delete error log in Temp folder.
     */
    $context = $configurations['context'];
    $replacements = [];

    // Get array consisting of form entries
    if (!isset($_POST['city'])) {
        $formEntries = prepareInitialEntries($configurations);
    } else {
        $formEntries = prepareSubsequentEntries($settings);

        // Set session settings based on language and units chosen
        setSessionSettings($formEntries);
    }

    // Use try/catch to find errors in database procedures rapidly without breaking website
    try {
        /*
         * Create connection to MySQL.
         * Set up database, tables, and automated administrative events if not already available.
         */
        $databaseConnection = prepareDatabase($configurations);

        // Check database for identical (or highly similar entries) within last 20 minutes
        $recentEntryStatement = seekRecentEntry($formEntries, $databaseConnection);

        // If recent entry from the city available, fetch and prepare that as $replacements
        if ($recentEntryStatement->rowCount() > 0) {
            //Fetch array instead of object (fetchObject()) to avoid having to set up an extra array
            while ($entry = $recentEntryStatement->fetch(PDO::FETCH_ASSOC)) {
                // If imperial values are requested, recalculate wind speed and temperature first
                if ($formEntries['units'] == 'imperial') {
                    $entry = convertToImperialUnits($entry);
                }
                $replacements = assignInformation($entry, $formEntries, $settings, $databaseConnection);
            }
        } else {
            // If recent entry unavailable, remove space(s) from city name for use in OpenWeatherMap URL
            $formEntries['city'] = str_replace(' ', '', $formEntries['city']);
            // Fetch weather data from OpenWeatherMap.org as array
            $data = getDataFromJson($formEntries, $configurations);

            /*
             * Prepare $replacements array (for changeable parts of the HTML template)
             *
             * If city_id could not be extracted from the OpenWeatherMap website, prepare blank page
             * and error message for user, do not double-check array $data and do not add data to database
             */
            if (empty($data['id'])) {
                $replacements = $localisations['language'][$formEntries['language']]['error'];
            } else {
                $replacements = assignInformation($data, $formEntries, $settings, $databaseConnection);

                // If data not recorded, make it "null" to ensure the data is added to the database
                $data = checkArrayForDatabase($data, $configurations);

                updateDatabase($data, $formEntries, $databaseConnection);
            }
        }
    } catch (PDOException $connectionException) {
        // If in development mode, log error
        logError($context, $connectionException);
    }

    // Perform replacements on the HTML template, and save HTML as a string
    $output = showVariables($replacements, $settings, $formEntries['language']);

    return $output;
}