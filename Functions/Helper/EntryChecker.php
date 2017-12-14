<?php
/**
 * @param string $city
 * @param array $configurations
 * @return string $city
 */
function checkCity($city, $configurations)
{
    // Characters like brackets, colons and underscores are to be removed from the text entry
    $unwantedCharacters = $configurations['defaults']['unwantedCharacters'];

    /*
     * Strips HTML and PHP tags.
     * Strips spaces, tabs, new lines, NUL-bytes and carriage returns at either end of $city
     */
    $city = str_replace($unwantedCharacters, '', trim(strip_tags($city)));

    return $city;
}
