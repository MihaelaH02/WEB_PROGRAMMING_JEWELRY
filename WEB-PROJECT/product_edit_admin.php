<?php
     session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="style.css">
        <title>Редактирай продукт</title>
    </head>
    <body>
        <nav id="nav_guests">
            <a class="nav-link" href="add_new_admin.php">Добави нова регистрация за собсвеник</a>
            <a class="nav-link" href="add_product.php">Добави продукт</a>
            <a class="nav-link" href="add_promo_code.php">Добави промо код</a></div>
            <a class="nav-link" href="product_list_admin.php">Редактирай продукти</a></div>
            <a class="nav-link" href="index.php">Иход от профила</a></div>
        </nav>
        <h2 class='heading'>Редактирай продукт:</h2>
        <form action="#" method="post"  enctype="multipart/form-data">
            <?php
                echo "<section id='order-details'>";
                include "configurate_database.php";

                $id_product=$_SESSION['edit_product'];
                $sql_product = "SELECT * FROM product p JOIN  product_type pt ON p.id_category = pt.id_category WHERE p.id_product = $id_product";
                $product_to_edit = mysqli_query($dbConn,$sql_product);
                $row_product=mysqli_fetch_array($product_to_edit);

            echo 'Заглавие на продукта: <input type="text" name="title" value="'. $row_product['title'] .'"required/><br>'.
                 'Вид продукт: <select name="product_type" required>';
                    $sql_category="SELECT * FROM product_type";
                    $category=mysqli_query($dbConn, $sql_category);
                    while($row_category=mysqli_fetch_assoc($category)){
                        $selected = ($row_category["id_category"]==$row_product['id_category']) ? "selected" : "";
                        echo "<option value= '" . $row_category['id_category']. "'  $selected>" . $row_category['category'] . "</option>";
                    }
            echo '</select><br>';
            echo 'Изображение:<br> <img src="'. $row_product['image'] .'" class="item-image" alt="image"><br>';
            echo 'Ново изображение: <input type="file"  name="new_image"><br>';
            echo 'Описание:<textarea name = "description">'. $row_product['description'] .'</textarea><br><br>'.
            '<div class="row">'.
                '<div class="col-50">'.
                    'Цена:<br> <input type="number" step="0.01" name="price" size="5" value="'. $row_product['price'] .'" style="width:82%;" required /> BGN<br><br>'.
                '</div>'.
                '<div class="col-50">'.
           	        'Количество:<br> <input type="number" name="quantity" value="'. $row_product['quantity'] .'" style="width:82%;" required /> бр.'.
                '</div>'.
            '</div>'.    
            '<input class="btn" type="submit" name="submit" value="Редактирай обява" /><br>'.
        '</form>'.
        '</section>';

            if (isset($_POST['submit'])) {
                $title = $_POST['title'];
                $product_type = $_POST['product_type'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $quantity = $_POST['quantity'];
                $new_image_path = "";

                if (isset($_FILES["new_image"]["name"]) && $_FILES["new_image"]["name"] != "") {
                    $target_file = "./images/" . basename($_FILES["new_image"]["name"]);
                    $temp_name = $_FILES["new_image"]["tmp_name"];
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $allowed_extensions = array("jpeg", "jpg", "png");

                    if (!in_array($imageFileType, $allowed_extensions)) {
                        echo '<script src="script.js"></script>';
                        echo "<script>addNewSection('Невалиднен файлов формат!');</script>";
                    } else {
                        if (move_uploaded_file($temp_name, $target_file)) {
                            $new_image_path = $target_file;
                        }
                    }
                }

                $image_path_to_use = $new_image_path != "" ? $new_image_path : $row_product['image'];
                $sql_edit = "UPDATE product SET title='" . mysqli_real_escape_string($dbConn, $title) . "', id_category='" . mysqli_real_escape_string($dbConn, $product_type) . "', description='" . mysqli_real_escape_string($dbConn, $description) . "', image='" . mysqli_real_escape_string($dbConn, $image_path_to_use) . "', price=" . mysqli_real_escape_string($dbConn, $price) . ", quantity=" . mysqli_real_escape_string($dbConn, $quantity) . " WHERE id_product='" . $row_product['id_product'] . "'";
                mysqli_query($dbConn, $sql_edit);

                $_SESSION['id_product_view'] = null;
                header("Location: index_admin.php");
                exit();
            }
            
            if (isset($_GET['index.html']))
                $_SESSION["id_user"]=null;;
?>
</body>
</html>