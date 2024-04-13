<?php
     session_start();
     $_SESSION['promo_code']=null;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Данни за плащане</title>
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="style.css">
        <script src="script.js"></script>
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

        <section id="order-info">
            <h3 class="heading">Данни за поръчка</h3>
            <?php
                echo '<form method="post" action="#" >';
                include "configurate_database.php";
                echo '<div class="card">';
                    echo '<div class="container-order">';
                        echo '<div class="col-50">';
                            $paymentInfo=$_SESSION['paymentInfo'];

                            echo '<h3>Данни за плащане:</h3>';
                            echo "<label for='typepay'>Вид плащане:</label> <select id='typepay' name='payment_type' onchange='handleSelectPayment()' required>"; 
                                $sql="SELECT * FROM payment_type";
                                $result=mysqli_query($dbConn, $sql);

                                while($row=mysqli_fetch_assoc($result)){
                                    $selected = ($paymentInfo["id_payment_type"]==$row['id_payment_type']) ? "selected" : "";
                                    echo "<option value= '" . $row['id_payment_type'] ."'". "$selected>" . $row['payment_type'] . "</option>";
                                }
                            echo "</select><br>";
                            echo "<label for='ctype'>Тип карта:</label><select id='ctype' class='card-info' name='card_type' disabled>";
                                $sql="SELECT * FROM card_type";
                                $result=mysqli_query($dbConn, $sql);

                                while($row=mysqli_fetch_assoc($result)){
                                    $selected = ($paymentInfo['id_card_type']==$row['id_card_type']) ? "selected" : "";
                                    echo "<option value= " . $row['id_card_type'] . " $selected>"  . $row['card_type'] . "</option>";
                                }
                            echo "</select><br>";
                            echo "<label for='ccnum'>Номер на картата:</label><input type='text' id='ccnum' class='card-info' name='card_number' value = '".$paymentInfo["card_number"]."' disabled/><br>";
                            echo '<div class="row">';
                                echo '<div class="col-50">';
                                    echo "<label for='exprs'>Валидност:</label><input type='text' id='exprs' class='card-info' name='expires' value = '".$paymentInfo["expires"]."' disabled/><br>";
                                echo"</div>";
                                echo '<div class="col-50">';
                                    echo "<label for='cvv'>CVV:</label><input type='text' id='cvv' name='cvv' class='card-info' pattern='^\d{3}' value = '".$paymentInfo["cvv"]."' disabled/><br>";
                                echo'</div>';
                            echo  '</div>'; 
                            echo  '<div class="container-promo">';
                                echo "<label for='promo'>Въведи код:</label><input type='text' id='promo' name='code' value='".$_SESSION['promo_code'] ."'/><br>";
                            echo '</div>';
                        echo '</div>';  

                        echo '<div class="col-50">';   
                            $deliveryInfo = $_SESSION['deliveryInfo'];    
                            echo '<h3>Данни за доставка:</h3></center>';
                            echo "<label for='fname'>Име:</label><input type='text' id='fname' name='name' value = '".$deliveryInfo["buyer"]["name"]."' required/><br>";
                            echo "<label for='fphone'>Телефонен номер:</label> <input type='text' id='fphone' name='phone' value = '".$deliveryInfo["buyer"]["phone"]."' required/><br>";
                            echo "<label for='fmail'>E-mail: </label><input type='email' id='fmail' name='email' value = '".$deliveryInfo["buyer"]["email"]."' required/><br>";
                            echo "<label for='adr'>Адрес на доставка: </label><input type='text' id='adr' name='address' value = '".$deliveryInfo["address"]."'required/><br>";
                        
                            echo "<label for='typedlvr'>Вид на доставка: </label><select id='typedlvr' name='id_type' required>";

                                $sql="SELECT * FROM delivery_type";
                                $result=mysqli_query($dbConn, $sql);
                                while($row=mysqli_fetch_assoc($result)){
                                    $selected = ($deliveryInfo['id_type']==$row['id_delivery_type']) ? "selected" : "";
                                    echo "<option value= " . $row['id_delivery_type'] . " $selected>" . $row['delivery_type'] ." + ". $row['additional_fee']."лв.". "</option>";
                                }
                            echo "</select><br>";
                            echo "<label for='dlvr'>Доставчик:</label><select id='dlvr' name='id_delivery_company' required>";
                                    
                                $sql="SELECT * FROM delivery_company";
                                $result=mysqli_query($dbConn, $sql);
                                while($row=mysqli_fetch_assoc($result)){
                                    $selected = ($deliveryInfo['id_delivery_company']==$row['id_company']) ? "selected" : "";
                                    echo "<option value= " . $row['id_company'] . ">" . $row['company'] ." - ". $row['price'] ."лв. - ".$row['shipping_time'] ." дни". "</option>";
                                }
                            echo "</select><br>";
                        echo "</div>";
                    echo '</div>';   
                    echo '<div class="payment-submit">';
                        echo "<input class='btn' type='submit' name='finish' value='Продължи'>";
                    echo '</div>';
                echo '</card>';
                echo "</form>";

            if (isset($_POST['finish'])){
                
                if($_POST['payment_type'] == 1){
                    $_SESSION['paymentInfo']["id_payment_type"] = 1;
                    $_SESSION['paymentInfo']["id_card_type"] = null;
                    $_SESSION['paymentInfo']["card_number"] = null;
                    $_SESSION['paymentInfo']["expires"] = null;
                    $_SESSION['paymentInfo']["cvv"] = null;
                }
                else{
                    $_SESSION['paymentInfo']["id_payment_type"] = 2;
                    $_SESSION['paymentInfo']["id_card_type"] = $_POST['card_type'];
                    $_SESSION['paymentInfo']["card_number"] = $_POST['card_number'];
                    $_SESSION['paymentInfo']["expires"] = $_POST['expires'];
                    $_SESSION['paymentInfo']["cvv"] = $_POST['cvv'];
                }

                $buyerInfo = array(
                    "name" => $_POST['name'],
                    "phone" => $_POST['phone'],
                    "email" => $_POST['email']);
    
                $deliveryInfo = array(
                    "buyer" => $buyerInfo,
                    "address" => $_POST['address'],
                    "id_type" => $_POST['id_type'],
                    "id_delivery_company" => $_POST['id_delivery_company'],
                );
                $_SESSION['deliveryInfo'] = $deliveryInfo;

                if($code=$_POST['code']){
                    $sql = "SELECT * FROM promotions WHERE code='".$code."'";
                    if(mysqli_fetch_assoc(mysqli_query($dbConn, $sql))){
                        $_SESSION['promo_code'] = $code;
                    }
                    else {
                        echo '<script src="script.js"></script>';
                        echo "<script>addNewSection('Невалиден код!');</script>";
                        return;
                    }
                }
                echo "<script>window.location.href = 'review_order.php';</script>";
            }
            ?>
        </section>

        <footer>
            <p>&copy; 2023 eCommerce. Всички права запазени.</p>
            <a href="#"><img src="images/facebook.png" alt="facebook" width="35px" height = "35px"></a>
            <a href="#"><img src="images/instagram.png" alt="instagram" width="35px" height = "35px"></a>
            <a href="#"><img src="images/pinterest.png" alt="pinterest" width="35px" height = "35px"></a>    
        </footer>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                handleSelectPayment();
            });
        </script>
    </body>
</html>