<?php


/**
 * Gets all the PII fields with their respective scores.
 *
 * @return int[]
 */
function piiFieldMap() : array
{
    return [
        "name" => 2,
        "mobile" => 10,
        "email" => 5,
        "credit_card" => 120
    ];
}
