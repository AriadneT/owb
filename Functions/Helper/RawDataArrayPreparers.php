<?php
/**
 * @param array $array
 * @return array $flattenedArray
 */
function array_values_recursive($array)
{
    $flattenedArray = [];

    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $flattenedArray = array_merge($flattenedArray, array_values_recursive($value));
        } else {
            $flattenedArray[$key] = $value;
        }
    }

    return $flattenedArray;
}

/**
 * @param array $data
 * @param array $configurations
 * @return array $data
 */
function checkArrayForDatabase($data, $configurations)
{
    $dataToCheck = $configurations['defaults']['fields'];

    foreach ($dataToCheck as $key => $value) {
        if (!isset($data[$key])) {
            $data[$key] = 'NULL';
        }
    }

    return $data;
}
