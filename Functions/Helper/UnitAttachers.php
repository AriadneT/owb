<?php
/**
 * @param string $value
 * @param string $unit
 * @return string
 */
function addUnit($value, $unit)
{
    return $value . $unit;
}

/**
 * @param string $value
 * @param string $key
 * @param string $unit
 * @param array $configurations
 * @return string
 */
function addMetricOrImperialUnit($value, $key, $unit, $configurations)
{
    return $value . $configurations['units'][$unit][$key];
}
