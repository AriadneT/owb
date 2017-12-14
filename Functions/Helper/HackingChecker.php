<?php
/**
 * @param array $settings
 * @param string $motherTongue
 */
function checkForm($settings, $motherTongue)
{
    list($configurations, $localisations) = $settings;
    // Only $_POST keys within the white list will be accepted
    $whiteList = $configurations['defaults']['whiteList'];

    foreach ($_POST as $key => $item) {
        // If $_POST key is not in white list, kill the website and give information to user
        if (!in_array($key, $whiteList)) {
            die($localisations['language'][$motherTongue]['die']);
        }
    }
}
