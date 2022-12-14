<?php

function toPersianNum($number)
{
    $number = str_replace("1", "۱", $number);
    $number = str_replace("2", "۲", $number);
    $number = str_replace("3", "۳", $number);
    $number = str_replace("4", "۴", $number);
    $number = str_replace("5", "۵", $number);
    $number = str_replace("6", "۶", $number);
    $number = str_replace("7", "۷", $number);
    $number = str_replace("8", "۸", $number);
    $number = str_replace("9", "۹", $number);
    $number = str_replace("0", "۰", $number);
    return $number;
}

function categoryConversion($category)
{
    switch ($category) {
        case "headphone":
            $category = "هدفون";
            break;
        case "handsfree":
            $category = "هندزفری";
            break;
        case "mobileCover":
            $category = "کاور موبایل";
            break;
        default:
            $category = "ساعت هوشمند";
    }
    return $category;
}

function setNull($input)
{
    if (trim($input) == "") {
        $input = null;
    }
    return $input;
}