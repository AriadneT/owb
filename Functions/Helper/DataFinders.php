<?php
/**
 * @param array $formEntries
 * @param PDO $databaseConnection
 * @return PDOStatement $recentEntryStatement
 */
function seekRecentEntry($formEntries, $databaseConnection)
{
    /*
     * Entries selected within a 20 minutes (1200 seconds) time limit relative to the query time.
     * If no country was selected, searching for a country in the database will not yield a positive result.
     */
    if ($formEntries['country'] == '') {
        $recentEntryQuery = "SELECT city, country, longitude, latitude, json_data.spoken_language, metric, 
                json_data.weather_id, weather_icon, temp, pressure, precipitation, humidity, visibility, wind_speed, 
                wind_direction, time_of_calculation, sunrise, sunset, weather_description FROM `json_data` 
                JOIN `city` ON json_data.city_id = city.city_id 
                JOIN `description` ON json_data.weather_id = description.weather_id 
                AND json_data.spoken_language = description.spoken_language 
                WHERE city = '" . $formEntries['city'] . "' AND query_time > FROM_UNIXTIME(UNIX_TIMESTAMP() - 1200)";
    } else {
        // If a country was selected, including it in the query improves accuracy of results
        $recentEntryQuery = "SELECT city, country, longitude, latitude, json_data.spoken_language, metric, 
                json_data.weather_id, weather_icon, temp, pressure, precipitation, humidity, visibility, wind_speed, 
                wind_direction, time_of_calculation, sunrise, sunset, weather_description FROM `json_data` 
                JOIN `city` ON json_data.city_id = city.city_id 
                JOIN `description` ON json_data.weather_id = description.weather_id 
                AND json_data.spoken_language = description.spoken_language 
                WHERE city = '" . $formEntries['city'] . "' 
                AND country = '" . $formEntries['country'] . "' 
                AND query_time > FROM_UNIXTIME(UNIX_TIMESTAMP() - 1200)";
    }
    $recentEntryStatement = $databaseConnection->query($recentEntryQuery);

    return $recentEntryStatement;
}

/**
 * @param string $findQuery
 * @param PDO $databaseConnection
 * @return bool $success
 */
function checkEntry($findQuery, $databaseConnection)
{
    $success = false;

    $findStatement = $databaseConnection->query($findQuery);
    if ($findStatement->rowCount() > 0) {
        $success = true;
    }

    return $success;
}

/**
 * @param string $motherTongue
 * @param array $entry
 * @param PDO $databaseConnection
 * @return string $value
 */
function translateDescription($motherTongue, $entry, $databaseConnection)
{
    $value = " ";

    $translationQuery = "SELECT weather_description FROM `description` 
            WHERE spoken_language = '" . $motherTongue . "' AND weather_id = " . $entry['weather_id'];
    $translationStatement = $databaseConnection->query($translationQuery);
    if ($translationStatement->rowCount() > 0) {
        while ($translationEntry = $translationStatement->fetchObject()) {
            $value = capitaliseFirstLetter($translationEntry->weather_description);
        }
    }

    return $value;
}
