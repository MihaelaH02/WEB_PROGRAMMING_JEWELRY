<?php
    include "init_session_vars.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="navbar.css">
        <title>Начало</title>
    </head>
    <body>
        <nav id="nav_guests">
                <a class="nav-link active" href="index.php">Начало</a>
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
        <section class="intro-section">
            <h2>Открийте своя стил</h2>
            <p>Разгледайте нашата широка гама от продукти.</p>
        </section>
        <footer>
            <p>&copy; 2023 eCommerce. Всички права запазени.</p>
            <a href="#"><img src="images/facebook.png" alt="facebook" width="35px" height = "35px"></a>
            <a href="#"><img src="images/instagram.png" alt="instagram" width="35px" height = "35px"></a>
            <a href="#"><img src="images/pinterest.png" alt="pinterest" width="35px" height = "35px"></a>    
        </footer>
    </body>
</html>
