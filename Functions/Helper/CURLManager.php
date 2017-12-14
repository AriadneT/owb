<?php
/**
 * @param string $url
 * @return mixed $curlResult
 */
function manageCURL($url)
{
    // Initiate curl
    $cURLInitiation = curl_init($url);

    // Setting up the url
    curl_setopt($cURLInitiation, CURLOPT_URL, $url);
    // Setup for returning the response
    curl_setopt($cURLInitiation, CURLOPT_RETURNTRANSFER, 1);
    // Will wait for up to 500 ms before assuming that the results will not come and cutting off the connection
    curl_setopt($cURLInitiation, CURLOPT_TIMEOUT_MS, 500);

    // Get JSON from website
    $curlResult = curl_exec($cURLInitiation);
    curl_close($cURLInitiation);

    return $curlResult;
}
