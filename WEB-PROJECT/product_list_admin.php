<?php
     session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="style.css">
        <title>Всички продукти за администратор</title>
    </head>
    <body>
        <nav id="nav_guests">
            <a class="nav-link" href="add_new_admin.php">Добави нова регистрация за собсвеник</a>
            <a class="nav-link" href="add_product.php">Добави продукт</a>
            <a class="nav-link" href="add_promo_code.php">Добави промо код</a></div>
            <a class="nav-link active" href="product_list_admin.php">Редактирай продукти</a></div>
            <a class="nav-link" href="index.php">Иход от профила</a></div>
        </nav>
        <h2 class="heading">Списък с продукти</h2>

        <?php
        include "configurate_database.php";
         $sql = "SELECT * FROM product p JOIN  product_type pt ON p.id_category = pt.id_category";

        $result = mysqli_query($dbConn,$sql);
        echo "<section id='container-table'>";
        echo"<table class='product-table'>";
        echo "<form action='#' method='post'>";
        while($row=mysqli_fetch_array($result)){
                $id_product=$row['id_product'];
                echo "<tr>";
                    echo "<th> <button type='submit' name='delete_product'  value='". $id_product ."'/>X</button></th>";
                    echo "<th>".' <img src="'. $row['image'] .'" alt="image">'."</th>".
                         "<th>". $row['title']. "</th>".
                         "<th>". $row['category']. "</th>".
                         "<th>". $row['price']. "лв.</th>".
                         "<th>";
                                $sql = "SELECT * FROM promotions WHERE id_product =".$id_product;
                                if(!$row=mysqli_fetch_assoc(mysqli_query($dbConn, $sql))) $row['discount']=null; 
                                echo "Промоция:<br><input type='number' name='discount_".$id_product."' min='0' max='90' step='0.01' placeholder='percent' value='".$row['discount']."' style='width:150px;'>
                                <button type='submit' class='btn' name='add_promo' value='". $id_product ."' style='width:150px;'>Добави</button>".
                         "</th>".
                         "<th> <button type='submit' class='btn' name='edit_product'  value='". $id_product ."' style='width:150px;'/>Редактирай</button></th>";
                echo "</tr>";
            }
            echo '</form>';
            echo "</table>";
            echo '</section>';

            if (isset($_POST["add_promo"])){
                $id_product = $_POST["add_promo"];
                $discount= $_POST['discount_'.$id_product.''];
                echo $discount;

                $validateItem = "SELECT * FROM promotions WHERE id_product = ".$id_product;
                if (mysqli_num_rows(mysqli_query($dbConn, $validateItem)) == 0) 
                    $sql = "INSERT INTO promotions (id_product, code, discount) VALUES (" . $id_product . ", NULL, " . $discount . ")";
                else $sql="UPDATE promotions SET discount = ". $_POST['discount']." WHERE id_product = ".$id_product;
                mysqli_query($dbConn,$sql);
                echo "<script>window.location.href = 'product_list_admin.php';</script>";
                exit();
            }

            if (isset($_POST["edit_product"])){
                $_SESSION['edit_product'] = $_POST['edit_product'];
                echo "<script>window.location.href = 'product_edit_admin.php';</script>";
                exit();
            }
            
            if(isset($_POST['delete_product'])){
                $sql = "DELETE FROM product WHERE id_product = '" . $_POST['delete_product']."' ";
                mysqli_query($dbConn,$sql);
                echo "<script>window.location.href = 'product_list_admin.php';</script>";
                exit();
            }

            if (isset($_GET['index.html']))
                $_SESSION["id_user"]=null;;
        ?>        


    </body>
</html>
