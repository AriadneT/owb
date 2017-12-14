<?php
/**
 * @param array $formEntries
 */
function setSessionSettings($formEntries)
{
    $_SESSION['units'] = $formEntries['units'];
    $_SESSION['language'] = $formEntries['language'];
}
