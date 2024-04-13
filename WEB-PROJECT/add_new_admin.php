<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <link rel="stylesheet" href="navbar.css">
        <link rel="stylesheet" href="style.css">
        <title>Добави нов профил</title>
    </head>
    <body>
        <nav id="nav_guests">
                <a class="nav-link active" href="add_new_admin.php">Добави нова регистрация за собсвеник</a>
                <a class="nav-link" href="add_product.php">Добави продукт</a>
                <a class="nav-link" href="add_promo_code.php">Добави промо код</a></div>
                <a class="nav-link" href="product_list_admin.php">Редактирай продукти</a></div>
                <a class="nav-link" href="index.php">Иход от профила</a></div>
        </nav>
        <h2 class="heading">Добавяне на нов профил:</h2>
        <section id='order-details'>
            <form action="#" method="post">
        	<h3>Данни на лице:</h3><br> 
            Име:<input type="text" name="name" required/><br>
            Имейл:<input type="email" name="email" required /><br>
            Потребителско име:<input type="text" name="username" required/><br>
            Парола:<input type="password" name="password" required />
            <input type="submit" class="btn" name="submit" value="Добави профил" /><br>
            </form>
        </section>
<?php
	include "configurate_database.php";
    if (isset($_POST["submit"])){
        $name = $_POST['name'];
        $email= $_POST['email'];
        $username =$_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM signin_admin WHERE username='$username' AND password = '$password' ";
        $result = mysqli_query($dbConn, $sql);
        if(!mysqli_fetch_assoc($result)){
            $sql="INSERT INTO signin_admin (name, email, username, password) VALUES ('$name','$email', '$username', '$password')";
            mysqli_query($dbConn,$sql);
            header("Location: index_admin.php");
            exit();
        }
        else {
            echo '<script src="script.js"></script>';
            echo "<script>addNewSection('Вече има съществуващ профил с тези данни.');</script>";
        }
    }
    if (isset($_GET['index.html']))
                $_SESSION["id_user"]=null;;
?>
</body>
</html>