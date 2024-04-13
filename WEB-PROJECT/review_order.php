<?php
     session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="style.css">
        <title>Преглед</title>
    </head>
    <body>
    <nav id="nav_guests">
            <a class="nav-link" href="index.php">Начало</a>
            <a class="nav-link" href="products_list.php">Всички продукти</a>
            <a class="nav-link" href="find_order.php">Информация за поръчка</a>
            <a class="nav-link" href="about.php">За нас</a></div>
            <div class="container-cart">
                <a class="nav-icon" href="cart.php"><img src="images/cart.png" alt="Кошница" width="35px" height = "35px">
                <p class="cart-index"><?php echo $_SESSION["cart_items"]; ?></p>
                </a>
            </div>
            <a class="nav-icon" href="signin_admin.php"><img src="images/admin.png" alt="Влез като собсвеник" width="35px" height = "35px"></a>
        </nav>
        <h2 class="heading">Преглед</h2>
        <section id='order-details'>
            <form action="#" method="post">
                
            <?php
            include "configurate_database.php";
            include "print_products_in_cart.php";

            echo "<h3>Продукти</h3>";
            printItems($_SESSION['cart_number'],"Премахни");
            $price=calculatePrices($_SESSION['cart_number']);
            
            include "order_data.php";
            $paymentInfo = $_SESSION['paymentInfo'];
            $deliveryInfo = $_SESSION['deliveryInfo'];
            $promoCode = $_SESSION['promo_code'];

            echo "<h3>Данни за плащане</h3>";
            echo "<div class='container-order-data'>";
                printPayment($paymentInfo);
                echo "<input type='submit' class='btn' name='edit_payment' value='Редактирай' style='width:150px;'>";
            echo "</div>";

            echo "<h3>Данни за доставка</h3>";
            echo "<div class='container-order-data'>";
                $shippingFee=printDelivery($deliveryInfo['buyer'],$deliveryInfo);  
                $deliveryDate = calculateDeliveryDate($deliveryInfo['id_delivery_company']);
                echo "<br><input type='submit' class='btn' name='edit_delivery' value='Редактирай' style='width:150px;'>";
            echo"</div>";

            echo "<h3>Промо-код</h3>";
            echo "<div class='container-order-data'>";
                $discount = calculatePromotions($promoCode,$price);
                echo $discount == 0 ? 'няма':"";
            echo "</div>";

            $price -= $discount;
            $price += $shippingFee;          
            echo "<h3>Обща сума: ". round($price, 2)." лв.</h3>";

            echo "<input type='submit' class='btn' name='order' value='Поръчай' style='width:150px;'>";
            echo "<input type='submit' class='btn' name='cancel' value='Отказ' style='width:150px;'>";
            echo "</form>";
        echo "</section>";

        if(isset($_POST['edit_payment'])){
            header("Location: payment.php");
            exit();
        }

        if(isset($_POST['edit_delivery'])){
            header("Location: payment.php");
            exit();
        }

        if(isset($_POST['cancel'])){
            $$_SESSION['paymentInfo'] = array(
                "id_payment_type" => null,
                "id_card_type" => null,
                "card_number" => null,
                "expires" => null,
                "cvv" =>null);
            $_SESSION['deliveryInfo'] = array(
                "buyer" =>  array(
                    "name" => null,
                    "phone" => null,
                    "email" => null),
                "address" => null,
                "id_type" => null,
                "id_delively_company" => null);
            $_SESSION['promo_code']=null;
            header("Location: products_list.php");
            exit();
        }

        if(isset($_POST['order'])){
            $sql="INSERT INTO payment (id_payment_type, id_card_type, card_number, expires, cvv) VALUES (".$paymentInfo['id_payment_type'].", ".($paymentInfo['id_card_type'] ? (int)$paymentInfo['id_card_type']  : 'NULL').", '".$paymentInfo['card_number']."', '".$paymentInfo['expires'] ."', ".(int)($paymentInfo['cvv']).")";
            if (mysqli_query($dbConn, $sql)){
                $IdPayment = mysqli_insert_id($dbConn);

                $sql="INSERT INTO buyer (name, phone, email) VALUES ('".$deliveryInfo["buyer"]["name"]."', '".$deliveryInfo["buyer"]["phone"]."', '".$deliveryInfo["buyer"]["email"]."')";
                if (mysqli_query($dbConn, $sql)) {
                    $IdBuyer = mysqli_insert_id($dbConn);

                    $sql="INSERT INTO delivery (id_buyer, address, id_type, id_delivery_company) VALUES ($IdBuyer,'".$deliveryInfo["address"]."', ".$deliveryInfo['id_type'].",".$deliveryInfo['id_delivery_company'].")";
                    if (mysqli_query($dbConn, $sql)) {
                        $IdDelivery = mysqli_insert_id($dbConn);

                        $curentDate = date('Y-m-d');
                        $sql = "SELECT * FROM promotions WHERE code = '".$promoCode."'";
                        $row_code=mysqli_fetch_assoc(mysqli_query($dbConn, $sql));
                        $id_promo=$row_code['id_promo'];
                        $sql="INSERT INTO order_items (date_order, id_cart, id_delivery, shipping_date, id_payment, id_promo, total_price,order_status) VALUES ('$curentDate', ".$_SESSION['cart_number'].",'$IdDelivery', '$deliveryDate', '$IdPayment'," . ($id_promo ? (int)$id_promo : 'null').", '$price','send')";//промо кода не работи
                        if (mysqli_query($dbConn, $sql)){
                            $idOrder = mysqli_insert_id($dbConn);
                            $_SESSION['id_order'] = $idOrder;
                            afterOrdering();
                            header("Location: finished_order.php");
                            exit();
                        }
                    }
                }
            }
        }

        function afterOrdering(){
            include "configurate_database.php";
            $cart = "SELECT * FROM cart WHERE id_cart =".(int)$_SESSION['cart_number']; 
            $resultCart = mysqli_query($dbConn,$cart);
            while($rowChart = mysqli_fetch_array($resultCart)){
                $item = "SELECT * FROM product WHERE id_product = '".$rowChart['id_product']."'";
                $result=mysqli_query($dbConn,$item);
                while($rowItem=mysqli_fetch_array($result)){
                    $itemChange = "UPDATE product SET quantity = ".((int)$rowItem['quantity'] - (int)$rowChart['wanted_quantity'])." WHERE id_product = '" . $rowItem['id_product'] . "'";
                    mysqli_query($dbConn,$itemChange);
                }
            }
            $_SESSION["cart_number"]=null;
        }
        ?>
    </body>
</html>