<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="style.css">
        <title>Добави код за отстъпка</title>
    </head>
    <body>
    <nav id="nav_guests">
                <a class="nav-link" href="add_new_admin.php">Добави нова регистрация за собсвеник</a>
                <a class="nav-link" href="add_product.php">Добави продукт</a>
                <a class="nav-link active" href="add_promo_code.php">Добави промо код</a></div>
                <a class="nav-link" href="product_list_admin.php">Редактирай продукти</a></div>
                <a class="nav-link" href="index.php">Иход от профила</a></div>
        </nav>
        <h2 class="heading">Добавяне на код за отстъпка:</h2>
        <form action="#" method="post">
        <section id="order-details">
            Код:<input type="text" name="code" max="6" required/><br>
            Процентно намаление: <input type='number' name='discount' min='1' max='90' step='0.01' placeholder='persent'>
            <button type='submit' class="btn" name='submit'>Добави</button>
        </section>
        </form>
<?php
	include "configurate_database.php";
        
    if (isset($_POST["submit"])){
        $code = $_POST['code'];
        $discount= $_POST['discount'];
        
        $validate = "SELECT * FROM promotions WHERE code = '".$code."'";
            if (mysqli_num_rows(mysqli_query($dbConn, $validate)) == 0) 
                $sql="INSERT INTO promotions(id_product, code, discount) VALUES (Null,'".$code." ',". $_POST['discount'].")";
            else $sql="UPDATE promotions SET discount = ". $_POST['discount']." WHERE code = '".$code."'";

            mysqli_query($dbConn,$sql);
            
            header("Location: index_admin.php");
            exit();
        }

        if (isset($_GET['index.html']))
            $_SESSION["id_user"]=null;;
?>
</body>
</html>