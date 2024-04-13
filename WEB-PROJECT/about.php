<?php
     session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>За Нас - eCommerce</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="navbar.css">
</head>
<body>
    <nav id="nav_guests">
        <a class="nav-link" href="index.php">Начало</a>
        <a class="nav-link" href="products_list.php">Всички продукти</a>
        <a class="nav-link" href="find_order.php">Информация за поръчка</a>
        <a class="nav-link active" href="about.php">За нас</a></div>
        <div class="container-cart">
            <a class="nav-icon" href="cart.php"><img src="images/cart.png" alt="Кошница" width="35px" height = "35px">
            <p class="cart-index"><?php echo $_SESSION["cart_items"]; ?></p>
            </a>
        </div>
        <a class="nav-icon" href="signin_admin.php"><img src="images/admin.png" alt="Влез като собсвеник" width="35px" height = "35px"></a>
    </nav>

    <section id="about-gallery">
        <img src="images/about_1.png">
        <img src="images/about_2.jpg">
        <img src="images/about_3.webp">
    </section>

    <div class="container-info">
            <h1 class="heading">За eCommerce</h1>
        <section class="about-section">
            <h2>Кои сме ние</h2>
            <p>Ние сме eCommerce, екип, страстен към предоставянето на най-добрите бижута от цял свят. Нашата мисия е да доставяме бижута високо качество до вашия дом.</p>
            
            <h2>Нашата визия</h2>
            <p>В eCommerce вярваме в стил, комфорт и издръжливост. Ние внимателно подбираме всяко бижу, за да се уверим, че отговарят на нашите високи стандарти.</p>

            <h2>Защо да изберете нас</h2>
            <p>С обширна гама от стилове и размери, удобен за потребителя интерфейс за пазаруване и изключително обслужване на клиенти, ние сме ангажирани да направим вашето пазаруване на бижута приятно и задоволително.</p>
        </section>
    </div>

    <footer>
            <p>&copy; 2023 eCommerce. Всички права запазени.</p>
    </footer>
</body>
</html>
