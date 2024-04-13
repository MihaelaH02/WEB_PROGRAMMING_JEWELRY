<?php
function validateTextField($data, $fieldName){
    /*if(!type_alpha($data))
        return "Полето за ".$fieldName." трябва да съдържа само букви!";*/
}

function validatePhoneNumber($data){
    if(strlen($data) != 10)
        return "Телефонният номер тябва да съдържа 10 цифри!";
}

function validateCardDate($data){
    $parsedDate = date_create_from_format('m/Y', $data);
    if ($parsedDate)
        if ($parsedDate >= (new DateTime()))
            return null;
    return "Невалиден формат за дата!";
}
?>