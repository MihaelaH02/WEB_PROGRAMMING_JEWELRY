<?php
     session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <title>Влез като собсвеник</title>
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
        
        <div class="form-heading">
            Впиши се като админ
        </div>
        <form action="#" method="post" class="login-form">
            <label> 
            Потребителско име:
            </label>
            <input type="text" name="username" required/><br>
            <label>Парола:</label>
            <input type="password" name="password" required />
            <input class="btn" type="submit" name="submit" value="Влез" /><br>
        </form>
<?php
	include "configurate_database.php";    
    if (isset($_POST["submit"])){
        $username =$_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT id_admin FROM signin_admin WHERE username='$username' AND password = '$password' ";
        if($sql_user=mysqli_fetch_assoc(mysqli_query($dbConn, $sql))){
            $_SESSION["id_user"] = $sql_user['id_admin'];
            header("Location: index_admin.php");
            exit();
        }
        else {
            echo '<script src="script.js"></script>';
            echo "<script>addNewSection('Неправилно потребителско име или парола!');</script>";
        }
    }
?>

</body>
</html>