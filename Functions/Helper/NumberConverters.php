<?php
/**
 * @param array $array
 * @return array $array
 */
function convertToImperialUnits($array)
{
    $array['wind_speed'] = $array['wind_speed'] * 2.237;
    $array['temp'] = ($array['temp'] * (9.0 / 5.0)) + 32;

    return $array;
}

/**
 * @param integer $timeInSeconds
 * @param array $formEntries
 * @param array $localisations
 * @return string $convertedTime
 */
function ConvertSecondsToDateTime($timeInSeconds, $formEntries, $localisations)
{
    // Convert to date and time
    $utcTime = new DateTime();
    $utcTime->setTimestamp($timeInSeconds);

    $localTime = clone $utcTime;
    /*
     * If a country is selected, a time zone relevant to the country is chosen.
     * In large countries (Australia, Canada), this may not be correct for the selected city,
     * but it is still more accurate than using London's time zone.
     */
    if ($formEntries['country'] != '') {
        $localTime->setTimezone(new DateTimeZone($localisations['countries'][$formEntries['country']]));
    } else {
        //Otherwise, use default time zone for Berlin, London, Paris or Madrid, depending on language chosen
        $localTime->setTimezone(new DateTimeZone($localisations['language'][$formEntries['language']]['timeZone']));
    }

    // Format date and time, depending on language chosen
    $convertedTime = $localTime->format($localisations['language'][$formEntries['language']]['dateTimeFormat']);

    return $convertedTime;
}

/**
 * @param array $array
 * @return array $array
 */
function convertToMetricUnits($array)
{
    $array['speed'] = $array['speed'] / 2.237;
    $array['temp'] = ($array['temp'] - 32) * (5.0 / 9.0);

    return $array;
}
