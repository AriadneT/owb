<?php
/**
 * @param array $data
 * @param PDO $databaseConnection
 */
function insertCityDetails($data, $databaseConnection)
{
    // Lock table to prevent further insertions into it (e.g. from other sessions) or searches in it until complete
    $databaseConnection->query('LOCK TABLES `city` WRITE');

    $insertCityQuery = "INSERT INTO `city` (city_id, city, country, longitude, latitude) VALUES 
            (" .
            $data['id'] . ",'" .
            $data['name'] . "','" .
            $data['country'] . "'," .
            $data['lon'] . "," .
            $data['lat'] .
            ")";
    $databaseConnection->query($insertCityQuery);

    // Unlock table to allow further insertions into it or searches in it
    $databaseConnection->query('UNLOCK TABLES');
}

/**
 * @param array $data
 * @param array $formEntries
 * @param PDO $databaseConnection
 */
function insertOtherJSONDetails($data, $formEntries, $databaseConnection)
{
    // The metric column in the database is boolean, so 1 for true and 0 for false
    if ($formEntries['units'] == 'metric') {
        $metric = 1;
    } else {
        $metric = 0;
        // If data is imperial, convert them to metric data for easier comparison later
        $data = convertToMetricUnits($data);
    }

    // Prevent insertion of JSON data into MySQL database from failing by performing calculations before the insertion
    if ($data['deg'] != 'NULL') {
        $data['deg'] = number_format($data['deg'], 0);
    }
    if ($data['temp'] != 'NULL') {
        $data['temp'] = number_format($data['temp'], 0);
    }

    // Lock table to prevent further insertions into it (e.g. from other sessions) or searches in it until complete
    $databaseConnection->query('LOCK TABLES `json_data` WRITE');

    $insertOtherDataQuery = "INSERT INTO `json_data` 
            (
            spoken_language, 
            metric, 
            city_id, 
            weather_id, 
            weather_icon, 
            temp, 
            pressure, 
            precipitation, 
            humidity, visibility, 
            wind_speed, 
            wind_direction, 
            time_of_calculation, 
            sunrise, 
            sunset
            ) 
            VALUES 
            ('" .
            $formEntries['language'] . "'," .
            $metric . "," . $data['id'] . "," .
            $data['weather_id'] . ",'" .
            $data['icon'] . "'," .
            $data['temp'] . "," .
            $data['pressure'] . "," .
            $data['3h'] . "," .
            $data['humidity'] . "," .
            $data['visibility'] . "," .
            $data['speed'] . "," .
            $data['deg'] . "," .
            $data['dt'] . "," .
            $data['sunrise'] . "," .
            $data['sunset'] .
            ")";
    $databaseConnection->query($insertOtherDataQuery);

    // Unlock table to allow further insertions into it or searches in it
    $databaseConnection->query('UNLOCK TABLES');
}

/**
 * @param array $data
 * @param string $motherTongue
 * @param PDO $databaseConnection
 */
function insertDescriptionDetails($data, $motherTongue, $databaseConnection)
{
    // Lock table to prevent further insertions into it (e.g. from other sessions) or searches in it until complete
    $databaseConnection->query('LOCK TABLES `description` WRITE');

    $insertDescriptionQuery = "INSERT INTO `description` (weather_id, spoken_language, weather_description) VALUES 
            (" .
            $data['weather_id'] . ",'" .
            $motherTongue . "','" .
            $data['description'] .
            "')";
    $databaseConnection->query($insertDescriptionQuery);

    // Unlock table to allow further insertions into it or searches in it
    $databaseConnection->query('UNLOCK TABLES');
}
