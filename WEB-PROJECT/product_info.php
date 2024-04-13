<?php
     session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <title>Продукт</title>
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="style.css">
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
        <form action="#" method="post">
            <?php
                include "configurate_database.php";

                $id_product=$_GET['id_product'];
                $sql = "SELECT * FROM product p JOIN  product_type pt ON p.id_category = pt.id_category WHERE p.id_product = $id_product";
                $result = mysqli_query($dbConn,$sql);
                $row=mysqli_fetch_array($result);

                echo "<h2 class='heading' '>" . $row['title'] ."</h2><br>";
                echo "<section id='item-info'>";
                    echo '<img class="item-image" src="'. $row['image'] .'" alt="image">';
                    echo "<div class='item-text'>".
                            "<h3 class='item-delails'>Вид продукт:" . $row['category'] . "</h3>" .
                            "<h3 class='item-delails'>Детайли: " . $row['description'] . "</h3>" ;
                            include "check_promotions.php";
                            if($discount=checkDiscount($id_product,$row['price']))
                                echo "<h3 class='item-delails'>Цена:<span class='discount-price'><i>". $row['price']."лв.</span> ".$row['price']-$discount."лв.</h3>";
                            else echo"<h3>Цена: ". $row['price']."лв.<h3>"; 
                            echo "<h3 class='item-delails'>Останали бройки: ". $row['quantity'] . " бр." . "</h3>";
                    echo '<input type="number" name="wanted_quantity" value="1"><br>';  
                    
                    if($row['quantity'] == 0){    	
                        echo '<input class="btn" type="submit" name="order_now" value="Поръчай сега" disabled/>
                            <input class="btn" type="submit" name="add_to_cart" value="Добави в кошницата" disabled/>';
                    }
                    else{
                        echo
                            '<input class="btn" type="submit" name="order_now" value="Поръчай сега" />
                            <input class="btn" type="submit" name="add_to_cart" value="Добави в кошницата" /></form>';
                    }
                    echo"</div>";

                echo "</section>";

                if(isset($_POST['add_to_cart']) || isset($_POST['order_now'])){
                    if($row['quantity'] >= $_POST['wanted_quantity']){   	
                        $sql_chart="INSERT INTO cart (id_cart, id_product, wanted_quantity) VALUES ({$_SESSION["cart_number"]}, '$id_product', {$_POST['wanted_quantity']})";
                        mysqli_query($dbConn,$sql_chart);
                        $_SESSION["cart_items"] ++;

                        if(isset($_POST['order_now'])){
                            header("Location: payment.php");
                            exit();
                            }
                        else{
                            header("Location: products_list.php");
                            exit();
                        }
                    }
                    else {
                        echo '<script src="script.js"></script>';
                        echo "<script>addNewSection('Няма достатъчно налични бройки!');</script>";
                    }
                }
            ?>          
        </form>
        <footer>
            <p>&copy; 2023 eCommerce. Всички права запазени.</p>
            <a href="#"><img src="images/facebook.png" alt="facebook" width="35px" height = "35px"></a>
            <a href="#"><img src="images/instagram.png" alt="instagram" width="35px" height = "35px"></a>
            <a href="#"><img src="images/pinterest.png" alt="pinterest" width="35px" height = "35px"></a>    
        </footer>
    </body>
</html>