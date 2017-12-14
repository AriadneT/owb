<?php
/**
 * @param string $context
 * @param PDOException $connectionException
 */
function logError($context, $connectionException)
{
    // Only log errors in development mode, not context mode
    if ($context == 'development') {
        // Prepare error message
        $date = date("d M Y");
        // Adding PHP_EOL results in a new line after the message
        $errorMessage = 'Database error: ' . $connectionException->getMessage() . '. ' . $date . PHP_EOL;

        // Record error message in temporary file in append mode, then close file
        $openedErrorLog = fopen('Temp/Logs.log', 'a');
        fwrite($openedErrorLog, $errorMessage);
        fclose($openedErrorLog);
    }
}
