<?php 
	function showMenu(){
		echo 
			"<br><a href='add_new_admin.php'>Добави нова регистрация за собсвеник</a>
        	<a href='add_product.php'>Добави продукт</a>
			<a href='add_promo_code.php'>Добави промо код</a>
    		<a href='product_list_admin.php'>Редактирай продукти</a>
        	<a href='index.php'>Иход от профила</a><br>";

        	if (isset($_GET['index.html']))
                $_SESSION["id_user"]=null;
	}
?>