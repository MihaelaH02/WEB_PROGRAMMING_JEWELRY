<?php
     session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Информация за поръчка</title>
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <nav id="nav_guests">
                <a class="nav-link" href="index.php">Начало</a>
                <a class="nav-link" href="products_list.php">Всички продукти</a>
                <a class="nav-link active" href="find_order.php">Информация за поръчка</a>
                <a class="nav-link" href="about.php">За нас</a></div>
                <div class="container-cart">
                    <a class="nav-icon" href="cart.php"><img src="images/cart.png" alt="Кошница" width="35px" height = "35px">
                    <p class="cart-index"><?php echo $_SESSION["cart_items"]; ?></p>
                    </a>
                </div>
                <a class="nav-icon" href="signin_admin.php"><img src="images/admin.png" alt="Влез като собсвеник" width="35px" height = "35px"></a>
        </nav>
        <section id='container-replace-data'>
            <section id="find-order">
                <h1 class='heading'>Информация за поръчка:</h1>
                <form action="" method="post" class="product-search-form" enctype="multipart/form-data">
                    <label>Код на поръчката:</label>
                    <input type="number" name="order_number"/><br>
                    <input class='btn' type='submit' name='find' value='Провери'>
                </form>
            </section>
        </section>
    <?php
        include "configurate_database.php";
        include "order_data.php";

        if (isset($_POST["find"])){
            $sql ="SELECT * from order_items where id_order='".$_POST['order_number']."'";
            if($order = mysqli_fetch_array(mysqli_query($dbConn,$sql))){
                $_SESSION['currentOrder']=$order['id_order'];

                echo "<section id='order-details'>";
                    echo '<script src="script.js"></script>';
                    echo "<script>replaceSection();</script>";

                    echo "<h2 class='heading'>Поръчка с номер ".$order['id_order']."</h2>";
                    echo "<h3>Информация за поръчка:</h3>";
                    echo "<div class='container-order-data'>";
                        echo "Дата на поръчка: " .$order['date_order']."<br>";
                        echo "Дата на доставка: " . $order['shipping_date']."<br>";
                        echo "Обща цена: ". $order['total_price'];
                    echo "</div>";
                    echo "<h3>Поръчани продукти:</h3>";
                    include "print_products_in_cart.php";
                    printItems($order['id_cart']);

                    echo "<h3>Информация за поръчка:</h3>";
                    echo "<div class='container-order-data'>";

                        $sql="SELECT * from delivery where id_delivery = '".$order['id_delivery']."'";
                        $delivery = mysqli_fetch_array(mysqli_query($dbConn,$sql));
                        $sql="SELECT * from buyer where id_buyer = '".$delivery['id_buyer']."'";
                        $buyer = mysqli_fetch_array(mysqli_query($dbConn,$sql));
                        printDelivery($buyer,$delivery);

                        $sql="SELECT * from payment where id_payment = '".$order['id_payment']."'";
                        $payment = mysqli_fetch_array(mysqli_query($dbConn,$sql));
                        printPayment($payment);
                    echo "</div>";

                    if($order['order_status'] == "received") 
                        echo "<h3>Получена пратка!</h3>";
                    else 
                        echo "<form action='' method='post'><input class='btn' type='submit' name='changeStatus' value='Отбележи като получена.'></form>";
                }
                else {
                    echo '<script src="script.js"></script>';
                    echo "<script>addNewSection('Не е открита пратка с този номер.');</script>";
                }
                echo "</section>";
        }

        if (isset($_POST["changeStatus"])){
            $sql ="UPDATE order_items SET order_status ='received' WHERE id_order='".$_SESSION['currentOrder']."'";
            if(mysqli_query($dbConn,$sql))
                $_SESSION['currentOrder'] = 0;
        }
    ?>
    <footer>
            <p>&copy; 2023 eCommerce. Всички права запазени.</p>
            <a href="#"><img src="images/facebook.png" alt="facebook" width="35px" height = "35px"></a>
            <a href="#"><img src="images/instagram.png" alt="instagram" width="35px" height = "35px"></a>
            <a href="#"><img src="images/pinterest.png" alt="pinterest" width="35px" height = "35px"></a>    
        </footer>
    </body>
</html>