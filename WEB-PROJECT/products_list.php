<?php
     session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Всички продукти</title>
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav id="nav_guests">
                <a class="nav-link" href="index.php">Начало</a>
                <a class="nav-link active" href="products_list.php">Всички продукти</a>
                <a class="nav-link" href="find_order.php">Информация за поръчка</a>
                <a class="nav-link" href="about.php">За нас</a></div>
                <div class="container-cart">
                    <a class="nav-icon" href="cart.php"><img src="images/cart.png" alt="Кошница" width="35px" height = "35px">
                    <p class="cart-index"><?php echo $_SESSION["cart_items"]; ?></p>
                    </a>
                </div>
                <a class="nav-icon" href="signin_admin.php"><img src="images/admin.png" alt="Влез като собсвеник" width="35px" height = "35px"></a>
        </nav>

        <section id="filter">
            <h1 class="heading"><?php 
                    if(!$_SESSION["filter_type_item"]) 
                        $_SESSION["filter_type_item"]="Всички продукти";
                    echo $_SESSION["filter_type_item"]; 
            ?></h1>
            <form class="container-filter" action="" method="post">
                <input class="filter-type" type='submit' name='type_0' value='Всички продукти'/>
                <input class="filter-type" type='submit' name='type_1' value='Обеци'/>
                <input class="filter-type" type='submit' name='type_2' value='Колие'/>
                <input class="filter-type" type='submit' name='type_3' value='Гривна'/>
                <input class="filter-type" type='submit' name='type_4' value='Часовник'/>
                <input class="filter-type" type='submit' name='type_5' value='Пръстен'/>
                <input class="filter-type" type='submit' name='type_6' value='Друго'/>
            </form>
            <span class="line-between-filter-items"> </span>
        </section>    

        <section id="items">
            <?php
            include "configurate_database.php";
            include "check_promotions.php";

            if(!$_SESSION["filter_sql"] || isset($_POST["type_0"])){
                $_SESSION["filter_sql"]="SELECT * FROM product p JOIN  product_type pt ON p.id_category = pt.id_category";
                $_SESSION["filter_type_item"]=$_POST['type_0'];
                header("Refresh:0");
            }

            if(isset($_POST["type_1"])){
                $_SESSION["filter_sql"] = "SELECT * FROM product p JOIN  product_type pt ON p.id_category = pt.id_category WHERE  p.id_category=1";
                $_SESSION["filter_type_item"]=$_POST['type_1'];
                header("Refresh:0");
            }

            if(isset($_POST["type_2"])){
                $_SESSION["filter_sql"] = "SELECT * FROM product p JOIN  product_type pt ON p.id_category = pt.id_category WHERE  p.id_category=2";
                $_SESSION["filter_type_item"]=$_POST['type_2'];
                header("Refresh:0");
            }

            if(isset($_POST["type_3"])){
                $_SESSION["filter_sql"] = "SELECT * FROM product p JOIN  product_type pt ON p.id_category = pt.id_category WHERE  p.id_category=7";
                $_SESSION["filter_type_item"]=$_POST['type_3'];
                header("Refresh:0");
            }

            if(isset($_POST["type_4"])){
                $_SESSION["filter_sql"] = "SELECT * FROM product p JOIN  product_type pt ON p.id_category = pt.id_category WHERE  p.id_category=8";
                $_SESSION["filter_type_item"]=$_POST['type_4'];
                header("Refresh:0");
            } 
            
            if(isset($_POST["type_5"])){
                $_SESSION["filter_sql"] = "SELECT * FROM product p JOIN  product_type pt ON p.id_category = pt.id_category WHERE  p.id_category=5";
                $_SESSION["filter_type_item"]=$_POST['type_5'];
                header("Refresh:0");
            }

            if(isset($_POST["type_6"])){
                $_SESSION["filter_sql"] = "SELECT * FROM product p JOIN  product_type pt ON p.id_category = pt.id_category WHERE  p.id_category=10";
                $_SESSION["filter_type_item"]=$_POST['type_6'];
                header("Refresh:0");
            }
            
                $result = mysqli_query($dbConn,$_SESSION["filter_sql"]);
                $_SESSION["filter_type_item"];
                while($row=mysqli_fetch_array($result)){
                    $id_product=$row['id_product'];
                    echo "<div class='container-item'>";
                        echo "<a href='product_info.php?id_product=$id_product'>";
                            echo "<img class='item-image' src='". $row['image'] ."' alt='image'>";
                            echo "<div class='container-item-text'>";
                                echo "<h2>". $row['title']."</h2>".
                                     "<span class='line-between-text'> </span>";
                                     if($discount=checkDiscount($id_product,$row['price']))
                                        echo "Цена:<p><span class='discount-price'><i>". $row['price']."лв.</span> ".$row['price']-$discount."лв.</i></p>";
                                    else echo"<p><i>Цена: ". $row['price']."лв.</i></p>"; 
                            echo "</div>";
                        echo "</a>";
                    echo "</div>";
                }
        ?>
        </section>
        
        <footer>
            <p>&copy; 2023 eCommerce. Всички права запазени.</p>
            <a href="#"><img src="images/facebook.png" alt="facebook" width="35px" height = "35px"></a>
            <a href="#"><img src="images/instagram.png" alt="instagram" width="35px" height = "35px"></a>
            <a href="#"><img src="images/pinterest.png" alt="pinterest" width="35px" height = "35px"></a>    
        </footer>
    </body>
</html>
