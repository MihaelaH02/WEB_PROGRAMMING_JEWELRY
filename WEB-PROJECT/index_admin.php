<?php
     session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <title>Начало за администратор</title>
    </head>
    <body>
    <nav id="nav_guests">
                <a class="nav-link" href="add_new_admin.php">Добави нова регистрация за собсвеник</a>
                <a class="nav-link" href="add_product.php">Добави продукт</a>
                <a class="nav-link" href="add_promo_code.php">Добави промо код</a></div>
                <a class="nav-link" href="product_list_admin.php">Редактирай продукти</a></div>
                <a class="nav-link" href="index.php">Иход от профила</a></div>
    </nav>
        <h2 class="heading">Добър ден, 
        <?php 
            include "configurate_database.php";
            $id_user = $_SESSION["id_user"];
            $sql = "SELECT name FROM signin_admin WHERE id_admin='$id_user'";
            if($row=mysqli_fetch_assoc(mysqli_query($dbConn, $sql)))
                echo $row['name']."</h2>";
            
            if (isset($_GET['index.html']))
                $_SESSION["id_user"]=null;;
        ?>
    </body>
</html>
