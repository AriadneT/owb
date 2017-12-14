<?php
/**
 * @param array $data
 * @param array $formEntries
 * @param PDO $databaseConnection
 */
function updateDatabase($data, $formEntries, $databaseConnection)
{
    // If not city not already entered, insert new row in `city` table
    updateCitiesIfRequired($data, $databaseConnection);

    // If not weather description already entered, insert new row in table `description`
    updateDescriptionsIfRequired($data, $formEntries['language'], $databaseConnection);

    /*
     * Description and city details must be entered before data is added to `json_data`
     * because the other two tables contain `json_data`'s foreign keys
     */
    insertOtherJSONDetails($data, $formEntries, $databaseConnection);
}

/**
 * @param array $data
 * @param PDO $databaseConnection
 */
function updateCitiesIfRequired($data, $databaseConnection)
{
    // Check if city already entered into database
    $findCityQuery = 'SELECT * FROM `city` WHERE city_id = ' . $data['id'];
    if (!checkEntry($findCityQuery, $databaseConnection)) {
        // If not already entered, insert new row in table `city`
        insertCityDetails($data, $databaseConnection);
    }
}

/**
 * @param array $data
 * @param string $motherTongue
 * @param PDO $databaseConnection
 */
function updateDescriptionsIfRequired($data, $motherTongue, $databaseConnection)
{
    $findDescriptionQuery = "SELECT * FROM `description` 
            WHERE weather_id = " . $data['weather_id'] . " AND spoken_language = '" . $motherTongue . "'";
    if (!checkEntry($findDescriptionQuery, $databaseConnection)) {
        insertDescriptionDetails($data, $motherTongue, $databaseConnection);
    }
}
