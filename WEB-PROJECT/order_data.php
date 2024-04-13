<?php
function printPayment($paymentInfo){
    include "configurate_database.php";

        if($paymentInfo["id_payment_type"]==2){
            echo "<h4>Плащане с карта</h4>";
            $sql_card_type ="SELECT card_type FROM card_type WHERE id_card_type = '".$paymentInfo['id_card_type']."'";
            $row_card_type=mysqli_fetch_assoc(mysqli_query($dbConn, $sql_card_type));
            echo "<b>Тип карта:</b> ".$row_card_type['card_type']."<br>";
            echo '<b>Номер на картата:</b> '. $paymentInfo["card_number"].'<br>';
            echo '<b>Валидност:</b> '. $paymentInfo["expires"].'<br>';
            echo '<b>CVV:</b> '.$paymentInfo["cvv"].'<br>';
        }
        else echo "<h4>Плащане с наложен платеж</h4>";
    }

    function printDelivery($buyerInfo,$deliveryInfo){
        include "configurate_database.php";

        echo "<b>Име на получател:</b> ".$buyerInfo["name"]."<br>";
        echo '<b>Телефон:</b> ' .$buyerInfo["phone"].'<br>';
        echo '<b>e-mail:</b> ' .$buyerInfo["email"].'<br>';
        echo '<b>Адрес на доставка:</b> '.$deliveryInfo["address"].'<br>';
        $sql ="SELECT * FROM delivery_type WHERE id_delivery_type = '".$deliveryInfo['id_type']."'";
        $row_delivery_type=mysqli_fetch_assoc(mysqli_query($dbConn, $sql));
        echo '<b>Тип доставка:</b> '.$row_delivery_type["delivery_type"].'<br>';
        $sql ="SELECT * FROM delivery_company WHERE id_company = '".$deliveryInfo['id_delivery_company']."'";
        $row_delivery_company=mysqli_fetch_assoc(mysqli_query($dbConn, $sql));
        echo '<b>Доставчик:</b> '.$row_delivery_company["company"].'<br>';
        echo "<b>Цена за доставка:</b> ". ($row_delivery_company["price"] + (double)$row_delivery_type["additional_fee"])." лв.";

        return (double)$row_delivery_company["price"]+(double)$row_delivery_type["additional_fee"];
    }

    function calculatePromotions($promoCode,$price){
        include "configurate_database.php";

        if($promoCode!=null){
            $sql = "SELECT * FROM promotions WHERE code = '".$promoCode."'";
            $row_code=mysqli_fetch_assoc(mysqli_query($dbConn, $sql));
            echo "<b>Дълнителна отстъпка</b> -".$row_code['discount']." %";
            return 0.01*$row_code['discount']*$price;
        }
        return 0;
    }

    function calculateDeliveryDate($id_company){
        include "configurate_database.php";

        $sql ="SELECT shipping_time FROM delivery_company WHERE id_company = '".$id_company."'";
        $days=mysqli_fetch_assoc(mysqli_query($dbConn, $sql));
        $deliveryDate =new DateTime();
        $deliveryDate->modify('+'.(int)$days.' days');
        $deliveryDate = $deliveryDate->format('Y-m-d');
        echo "<br><b>Дата на доставка:</b> $deliveryDate" ;
        return $deliveryDate;
    }
?>