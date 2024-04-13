<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="style.css">
        <title>Добави нов продукт</title>
    </head>
    <body>
    <nav id="nav_guests">
                <a class="nav-link" href="add_new_admin.php">Добави нова регистрация за собсвеник</a>
                <a class="nav-link active" href="add_product.php">Добави продукт</a>
                <a class="nav-link" href="add_promo_code.php">Добави промо код</a></div>
                <a class="nav-link" href="product_list_admin.php">Редактирай продукти</a></div>
                <a class="nav-link" href="index.php">Иход от профила</a></div>
        </nav>
        <h2 class="heading">Добавяне на нов продукт:</h2>
        <form action="" method="post" enctype="multipart/form-data">
        <section id='order-details'>
            
            Заглавие на продукта:<input type="text" name="title" required/><br>
            <div class="row">
                <div class="col-50">
                Вид продукт: <select name="product_type" required>
                    <?php 
                    include "configurate_database.php";
                        $sql="SELECT * FROM product_type";
                        $result=mysqli_query($dbConn, $sql);

                        while($row=mysqli_fetch_assoc($result))
                            echo "<option value= " . $row['id_category'] . ">" . $row['category'] . "</option>";
                    ?>
                </select><br>
                </div>
                <div class="col-50">
                    Изображение:<input type="file" name="image" required>
                </div>
            </div>
            Описание:<br><textarea name = "description" style="width:100%; height:50px; border-radius:3px;"></textarea><br><br>
            <div class="row">
                <div class="col-50">
                    Цена:<br><input type="number" step="0.01" name="price" size="5" style="width:82%;" required /> BGN<br><br>
                </div>
                <div class="col-50">
                    Количество:<br> <input type="number" name="quantity" style="width:82%;" required /> бр.
                </div>
            </div>
            <input type="submit" class='btn' name="submit" value="Добави обява" /><br>
        </section>
        </form>
<?php
	include "configurate_database.php";
    if (isset($_POST["submit"])) {
        include "validate_data.php";
        
        $title = mysqli_real_escape_string($dbConn, $_POST['title']);
        $validate = "SELECT * FROM product WHERE title = '" . $title . "'";
        $result = mysqli_query($dbConn, $validate);
        if (mysqli_num_rows($result) > 0) {
            echo '<script src="script.js"></script>';
            echo "<script>addNewSection('Вече има добавен продукт с това заглавие!');</script>";
        } else {
            $product_type = $_POST['product_type'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $quantity= $_POST['quantity'];
            $new_image_path = "";

            $target_file = "./images/" . basename($_FILES["image"]["name"]);
            $temp_name = $_FILES["image"]["tmp_name"];
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_extensions = array("jpeg", "jpg", "png");

            if (!in_array($imageFileType, $allowed_extensions)) {
                echo '<script src="script.js"></script>';
                echo "<script>addNewSection('Неуспешно качване на изображението!');</script>";
            }else{
                if (move_uploaded_file($temp_name, $target_file)) {
                    $new_image_path = $target_file;
                    $sql = "INSERT INTO product (title, id_category, image, description, price, quantity) VALUES ('$title', '$product_type', '$target_file', '$description', $price, $quantity)";
                    if (mysqli_query($dbConn, $sql)) {
                        header("Location: index_admin.php");
                        exit;
                    }
                }
            }
        }
    }

    if (isset($_GET['index.html']))
        $_SESSION["id_user"]=null;;
?>
</body>
</html>