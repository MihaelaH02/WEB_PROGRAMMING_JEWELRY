<?php
     session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="style.css">
        <title>Всички продукти от количката</title>
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

        <h2 class='heading'>Количка</h2>
        <?php
            include "print_products_in_cart.php";
            echo "<section id='container-table'>";
                $itemNumber=printItems($_SESSION['cart_number']);
                echo "<div class='heading'>Обща цена: ".calculatePrices($_SESSION['cart_number'])." лв.</div>";
                echo '<form action="#" method="post">';
                echo "<input class='btn' type='submit' name='pay' value='Поръчай' style='margin-left: 45%;'/></form>";
                
                if (isset($_POST['pay'])){
                    if($_SESSION["cart_items"]>0){
                        header("Location: payment.php");
                        exit();
                    }   
                    echo '<script src="script.js"></script>';
                    echo "<script>addNewSection('Количката ви е празна!');</script>";
                }
                echo "</section>";
        ?>
        <footer>
            <p>&copy; 2023 eCommerce. Всички права запазени.</p>
            <a href="#"><img src="images/facebook.png" alt="facebook" width="35px" height = "35px"></a>
            <a href="#"><img src="images/instagram.png" alt="instagram" width="35px" height = "35px"></a>
            <a href="#"><img src="images/pinterest.png" alt="pinterest" width="35px" height = "35px"></a>    
        </footer>
    </body>
</html>