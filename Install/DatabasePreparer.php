<?php
/**
 * @param array $configurations
 * @return PDO $databaseConnection
 */
function prepareDatabase($configurations)
{
    // Create and configure initial connection to MySQL
    $databaseConnection = connectToMySQL($configurations);

    createDatabase($databaseConnection);

    useDatabase($databaseConnection);

    createCityTable($databaseConnection);

    createDescriptionTable($databaseConnection);

    createJSONTable($databaseConnection);

    // Optional table stores old data from JSON table for use by developer, website owner and other interested parties
    createOldJSONTable($databaseConnection);

    // Ensure event scheduling is enabled
    turnOnEventScheduler($databaseConnection);

    // Create event to transfer and delete old JSON data. Function can be modified to simply delete the data.
    transferOldJSONData($databaseConnection);

    return $databaseConnection;
}

/**
 * @param array $configurations
 * @return PDO $databaseConnection
 */
function connectToMySQL($configurations)
{
    $databaseConnection = new PDO('mysql:host=' . $configurations['defaults']['databaseParameters']['host'] .
        ';dbname=' . $configurations['defaults']['databaseParameters']['databaseName'],
        $configurations['defaults']['databaseParameters']['user'],
        $configurations['defaults']['databaseParameters']['password']);
    // utf8 allows special characters to be saved as is
    $databaseConnection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
    // Allows error messages to be written if they occur
    $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $databaseConnection;
}

/**
 * @param PDO $databaseConnection
 */
function createDatabase($databaseConnection)
{
    $databaseConnection->query('CREATE DATABASE IF NOT EXISTS open_weather_map;');
}

/**
 * @param PDO $databaseConnection
 */
function useDatabase($databaseConnection)
{
    $databaseConnection->query('USE open_weather_map;');
}

/**
 * @param PDO $databaseConnection
 */
function createCityTable($databaseConnection)
{
    $createCityTableQuery = 'CREATE TABLE IF NOT EXISTS city 
            (
            city_id INTEGER(7) PRIMARY KEY, 
            city VARCHAR(58) COLLATE utf8_unicode_ci NOT NULL,
            country VARCHAR(2) NOT NULL,
            longitude DECIMAL(5,2), 
            latitude DECIMAL(4,2)
            );';
    $databaseConnection->query($createCityTableQuery);
}

/**
 * @param PDO $databaseConnection
 */
function createDescriptionTable($databaseConnection)
{
    $createDescriptionTableQuery = 'CREATE TABLE IF NOT EXISTS description
            (
            weather_id SMALLINT(3) UNSIGNED NOT NULL, 
            spoken_language VARCHAR(2) NOT NULL, 
            weather_description VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
            PRIMARY KEY (weather_id, spoken_language)
            );';
    $databaseConnection->query($createDescriptionTableQuery);
}

/**
 * @param PDO $databaseConnection
 */
function createJSONTable($databaseConnection)
{
    $createJSONTableQuery = 'CREATE TABLE IF NOT EXISTS json_data 
            (
            json_id INTEGER(10) AUTO_INCREMENT PRIMARY KEY, 
            query_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            spoken_language VARCHAR(2) NOT NULL, 
            metric TINYINT(1) NOT NULL, 
            city_id INTEGER(7) NOT NULL, 
            weather_id SMALLINT(3) UNSIGNED NOT NULL, 
            weather_icon VARCHAR(3), 
            temp SMALLINT(2), 
            pressure SMALLINT(4) UNSIGNED, 
            precipitation SMALLINT(3) UNSIGNED, 
            humidity SMALLINT(3) UNSIGNED, 
            visibility SMALLINT(5) UNSIGNED, 
            wind_speed DECIMAL(5,2) UNSIGNED, 
            wind_direction SMALLINT(3) UNSIGNED, 
            time_of_calculation INTEGER(10) UNSIGNED, 
            sunrise INTEGER(10) UNSIGNED, 
            sunset INTEGER(10) UNSIGNED, 
            FOREIGN KEY (city_id) REFERENCES city(city_id), 
            FOREIGN KEY (weather_id, spoken_language) REFERENCES description(weather_id, spoken_language)
            );';
    $databaseConnection->query($createJSONTableQuery);
}

/**
 * @param PDO $databaseConnection
 */
function createOldJSONTable($databaseConnection)
{
    $createJSONTableQuery = 'CREATE TABLE IF NOT EXISTS old_json_data 
            (
            json_id INTEGER(10) AUTO_INCREMENT PRIMARY KEY, 
            query_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
            spoken_language VARCHAR(2) NOT NULL, 
            metric TINYINT(1) NOT NULL, 
            city_id INTEGER(7) NOT NULL, 
            weather_id SMALLINT(3) UNSIGNED NOT NULL, 
            weather_icon VARCHAR(3), 
            temp SMALLINT(2), 
            pressure SMALLINT(4) UNSIGNED, 
            precipitation SMALLINT(3) UNSIGNED, 
            humidity SMALLINT(3) UNSIGNED, 
            visibility SMALLINT(5) UNSIGNED, 
            wind_speed DECIMAL(5,2) UNSIGNED, 
            wind_direction SMALLINT(3) UNSIGNED, 
            time_of_calculation INTEGER(10) UNSIGNED, 
            sunrise INTEGER(10) UNSIGNED, 
            sunset INTEGER(10) UNSIGNED, 
            FOREIGN KEY (city_id) REFERENCES city(city_id), 
            FOREIGN KEY (weather_id, spoken_language) REFERENCES description(weather_id, spoken_language)
            );';
    $databaseConnection->query($createJSONTableQuery);
}

/**
 * @param PDO $databaseConnection
 */
function turnOnEventScheduler($databaseConnection)
{
    $eventSchedulerEnablingQuery = 'SET GLOBAL event_scheduler = ON;';
    $databaseConnection->query($eventSchedulerEnablingQuery);
}

/**
 * @param PDO $databaseConnection
 */
function transferOldJSONData($databaseConnection)
{
    /*
     * Transfer and delete data older than 40 minutes every minute. 40 minutes rather than 20 minutes is used
     * to allow room for error. Minute event interval works, but 40-minute interval does not work or is inaccurate.
     * Depending on website's traffic and optimisation of server performance, interval may still need to be altered.
     *
     * If old data should not be saved, delete parts of query at lines 182, 183 and 185.
     */
    $transferDataQuery = 'CREATE EVENT IF NOT EXISTS `transfer_data`
    ON SCHEDULE EVERY 1 MINUTE
    ON COMPLETION PRESERVE
    DO
    BEGIN
    INSERT INTO  `old_json_data` SELECT * FROM `json_data` WHERE query_time < FROM_UNIXTIME(UNIX_TIMESTAMP() - 2400);
    DELETE FROM `json_data` WHERE query_time < FROM_UNIXTIME(UNIX_TIMESTAMP() - 2400);
    END';
    $databaseConnection->query($transferDataQuery);
}
