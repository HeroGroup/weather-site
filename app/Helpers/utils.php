<?php

function jalali_to_gregorian_string($inputDate) {
    $dateArray = explode("-", $inputDate);
    $gregorianDate = jalali_to_gregorian($dateArray[0], $dateArray[1], $dateArray[2]);

    if (strlen($gregorianDate[1]) < 2)
        $gregorianDate[1] = '0'.$gregorianDate[1];

    if (strlen($gregorianDate[2]) < 2)
        $gregorianDate[2] = '0'.$gregorianDate[2];

    return implode("-", $gregorianDate);
}
