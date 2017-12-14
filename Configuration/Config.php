<?php
return [
    'context' => 'development',
    'units' => [
        'metric' => [
            'wind_speed' => ' m/s',
            'speed' => ' m/s',
            'temp' => ' &#8451;',
            'breeze' => 10.8,
            'highWind' => 17.2,
            'gale' => 24.5,
            'storm' => 32.7
        ],
        'imperial' => [
            'wind_speed' => ' mph',
            'speed' => ' mph',
            'temp' => ' &#8457;',
            'breeze' => 25,
            'highWind' => 39,
            'gale' => 55,
            'storm' => 73
        ]
    ],
    'defaults' => [
        'entries' => [
            'api' => 'API Schlüssel hier',
            'city' => 'Deine Stadt',
            'country' => 'DE',
            'language' => 'de',
            'units' => 'metric',
            'count' => '1'
        ],
        'fields' => [
            'lon' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 2,
                'notNumber' => 0,
                'templateEntry' => 'LON_VALUE'
            ],
            'longitude' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 2,
                'notNumber' => 0,
                'templateEntry' => 'LON_VALUE'
            ],
            'lat' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 2,
                'notNumber' => 0,
                'templateEntry' => 'LAT_VALUE'
            ],
            'latitude' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 2,
                'notNumber' => 0,
                'templateEntry' => 'LAT_VALUE'
            ],
            'main' => [
                'use' => 0
            ],
            'description' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 1,
                'decimalPlaces' => 0,
                'notNumber' => 1,
                'templateEntry' => 'DESCRIPTION_VALUE'
            ],
            'weather_description' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 1,
                'decimalPlaces' => 0,
                'notNumber' => 1,
                'templateEntry' => 'DESCRIPTION_VALUE'
            ],
            'icon' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '',
                'picture' => 1,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 1,
                'templateEntry' => 'BODY'
            ],
            'weather_icon' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '',
                'picture' => 1,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 1,
                'templateEntry' => 'BODY'
            ],
            'base' => [
                'use' => 0
            ],
            'temp' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => 'units specific',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 0,
                'templateEntry' => 'TEMP_VALUE'
            ],
            'pressure' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => ' hpa',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 0,
                'templateEntry' => 'PRESSURE_VALUE'
            ],
            'grnd_level' => [
                'use' => 0
            ],
            'sea_level' => [
                'use' => 0
            ],
            'humidity' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => ' %',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 0,
                'templateEntry' => 'HUMIDITY_VALUE'
            ],
            'temp_min' => [
                'use' => 0
            ],
            'temp_max' => [
                'use' => 0
            ],
            'visibility' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => ' m',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 0,
                'templateEntry' => 'VISIBILITY_VALUE'
            ],
            'speed' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => 'units specific',
                'picture' => 0,
                'wind' => 1,
                'capitalise' => 0,
                'decimalPlaces' => 1,
                'notNumber' => 0,
                'templateEntry' => 'WIND_SPEED_VALUE'
            ],
            'wind_speed' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => 'units specific',
                'picture' => 0,
                'wind' => 1,
                'capitalise' => 0,
                'decimalPlaces' => 1,
                'notNumber' => 0,
                'templateEntry' => 'WIND_SPEED_VALUE'
            ],
            'deg' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '°',
                'picture' => 0,
                'wind' => 1,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 0,
                'templateEntry' => 'WIND_DIRECTION_VALUE'
            ],
            'wind_direction' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '°',
                'picture' => 0,
                'wind' => 1,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 0,
                'templateEntry' => 'WIND_DIRECTION_VALUE'
            ],
            'all' => [
                'use' => 0
            ],
            'dt' => [
                'use' => 1,
                'isDateTime' => 1,
                'hasUnit' => 'language/country specific',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 0,
                'templateEntry' => 'DT_VALUE'
            ],
            'time_of_calculation' => [
                'use' => 1,
                'isDateTime' => 1,
                'hasUnit' => 'language/country specific',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 0,
                'templateEntry' => 'DT_VALUE'
            ],
            'type' => [
                'use' => 0
            ],
            'message' => [
                'use' => 0
            ],
            'country' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 1,
                'templateEntry' => 'COUNTRY_VALUE'
            ],
            'sunrise' => [
                'use' => 1,
                'isDateTime' => 1,
                'hasUnit' => 'language/country specific',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 0,
                'templateEntry' => 'SUNRISE_VALUE'
            ],
            'sunset' => [
                'use' => 1,
                'isDateTime' => 1,
                'hasUnit' => 'language/country specific',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 0,
                'templateEntry' => 'SUNSET_VALUE'
            ],
            'name' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 1,
                'templateEntry' => 'CITY_VALUE'
            ],
            'city' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => '',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 1,
                'templateEntry' => 'CITY_VALUE'
            ],
            'cod' => [
                'use' => 0
            ],
            'city_id' => [
                'use' => 0
            ],
            'spoken_language' => [
                'use' => 0
            ],
            'weather_id' => [
                'use' => 0
            ],
            '3h' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => ' mm',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 0,
                'templateEntry' => 'PRECIPITATION_VALUE'
            ],
            'precipitation' => [
                'use' => 1,
                'isDateTime' => 0,
                'hasUnit' => ' mm',
                'picture' => 0,
                'wind' => 0,
                'capitalise' => 0,
                'decimalPlaces' => 0,
                'notNumber' => 0,
                'templateEntry' => 'PRECIPITATION_VALUE'
            ],
            'metric' => [
                'use' => 0
            ]
        ],
        'url' => [
            'urlStub' => 'http://api.openweathermap.org/data/2.5/weather?APPID=',
            'cityAddition' => '&q=',
            'unitsAddition' => '&units=',
            'languageAddition' => '&lang=',
            'numberAddition' => '&cnt='
        ],
        'jsonDecode' => 'true',
        'templates' => [
            'Resources/Private/Templates/Header.html',
            'Resources/Private/Templates/Form.html',
            'Resources/Private/Templates/MainTitles.html',
            'Resources/Private/Templates/SummarySection.html',
            'Resources/Private/Templates/DetailsSection.html',
            'Resources/Private/Templates/Footer.html'
        ],
        'errorTemplates' => [
            'Resources/Private/Templates/Header.html',
            'Resources/Private/Templates/Form.html',
            'Resources/Private/Templates/MainTitles.html',
            'Resources/Private/Templates/SummarySection.html',
            'Resources/Private/Templates/Footer.html'
        ],
        'unwantedCharacters' => [
            '[',
            ']',
            ';',
            ':',
            '_',
            '(',
            ')',
            '{',
            '}',
            '=',
            '\''
        ],
        'whiteList' => [
            'city',
            'country',
            'language',
            'units',
            'Suche',
            'Submit',
            'Envoyer',
            'Someter'
        ],
        'checkedOptions' => [
            '###CHECK_OPTION_DE###',
            '###CHECK_OPTION_EN###',
            '###CHECK_OPTION_FR###',
            '###CHECK_OPTION_ES###',
            '###CHECK_OPTION_METRIC###',
            '###CHECK_OPTION_IMPERIAL###'
        ],
        'databaseParameters' => [
            'host' => 'localhost',
            'user' => 'Username hier',
            'password' => 'Passwort hier',
            'databaseName' => 'mysql',
            'port' => '3306',
            'socket' => ''
        ]
    ],
    'filesToInclude' => [
        'Functions/Helper/EntryChecker.php',
        'Functions/Helper/WeatherDataRetriever.php',
        'Functions/Helper/HackingChecker.php',
        'Functions/Helper/DataFinders.php',
        'Functions/Helper/DataInserters.php',
        'Functions/Helper/DatabaseAdministrators.php',
        'Functions/Helper/CURLManager.php',
        'Functions/Helper/FormEntryArrayPreparers.php',
        'Functions/Helper/TemplateAssembler.php',
        'Functions/Helper/RawDataArrayPreparers.php',
        'Functions/Helper/ReplacementArrayPreparers.php',
        'Functions/Helper/UnitAttachers.php',
        'Functions/Helper/NumberConverters.php',
        'Functions/Helper/DatabaseErrorLogger.php',
        'Functions/Helper/SessionSettingsSetter.php',
        'Functions/Utility/ArrayDisplayUtility.php',
        'Functions/Utility/ArrayPreparationUtility.php',
        'Install/DatabasePreparer.php'
    ],
    'ajaxFilesToInclude' => [
        '../Helper/EntryChecker.php',
        '../Helper/WeatherDataRetriever.php',
        '../Helper/HackingChecker.php',
        '../Helper/DataFinders.php',
        '../Helper/DataInserters.php',
        '../Helper/DatabaseAdministrators.php',
        '../Helper/CURLManager.php',
        '../Helper/FormEntryArrayPreparers.php',
        '../Helper/TemplateAssembler.php',
        '../Helper/RawDataArrayPreparers.php',
        '../Helper/ReplacementArrayPreparers.php',
        '../Helper/UnitAttachers.php',
        '../Helper/NumberConverters.php',
        '../Helper/DatabaseErrorLogger.php',
        '../Helper/SessionSettingsSetter.php',
        '../Utility/ArrayPreparationUtility.php',
        '../../Install/DatabasePreparer.php'
    ],
    'body' => [
        '01d' => 'clearDayBody',
        '01n' => 'clearNightBody',
        '02d' => 'fewCloudsDayBody',
        '02n' => 'fewCloudsNightBody',
        '03d' => 'scatteredCloudsDayBody',
        '03n' => 'scatteredCloudsNightBody',
        '04d' => 'brokenCloudsDayBody',
        '04n' => 'brokenCloudsNightBody',
        '09d' => 'rainyDayBody',
        '10d' => 'rainyDayBody',
        '11d' => 'stormDayBody',
        '11n' => 'stormNightBody',
        '13d' => 'snowyDayBody',
        '13n' => 'snowyNightBody',
        '50d' => 'foggyDayBody',
        '50n' => 'foggyNightBody',
        '09n' => 'rainyNightBody',
        '10n' => 'rainyNightBody'
    ]
];
