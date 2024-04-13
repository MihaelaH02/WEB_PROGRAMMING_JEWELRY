<?php
function sendMail($to,$numberOrder) {
    $title = 'Пратка ecommerce';
    $content = 'Пратка с номер '.$numberOrder." е успешно регистрирана. За повече информация посетете нашия сайт в секция 'Информация за поръчка'.";
    $from = 'jewery@ecommerce.com';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers  .= "From: " . $from . "\r\n";

    if(mail($to, $title, $content, $headers)) {
        echo "Успешно изпратен имейл!";
    }
}
?>
