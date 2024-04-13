<?php
    include "check_promotions.php";

    function printItems($cartNumber){
        include "configurate_database.php";

        $sql = "SELECT * FROM cart c JOIN product p ON c.id_product = p.id_product JOIN product_type pt ON p.id_category = pt.id_category WHERE id_cart=$cartNumber"; 
        $result = mysqli_query($dbConn,$sql);

        echo "<table class='product-table'>";
            echo "<form action='#'' method='post'>";

            while($row=mysqli_fetch_array($result)){
                $itemNumber=$row['item_number'];
                echo "<tr>";
                    echo "<th> <button type='submit' name='delete_item'  value='". $itemNumber ."'/>X</button></th>";
                    echo "<th>". $row['title']. "</th>".
                        "<th>".' <img src="'. $row['image'] .'" alt="image">'."</th>";
                    echo "<th>";
                    if($discount=checkDiscount($row['id_product'], $row['price']))
                        echo "<p><i>".$row['price']-$discount."лв.</i></p></th>";
                    else echo"<p><i>Цена: ". $row['price']."лв.</i></p></th>";
                    echo"<th>". $row['wanted_quantity']."бр.</th>";
                echo "</tr>";
            }
        echo "</form></table>";

        if(isset($_POST['delete_item'])){
            $itemNumber = $_POST['delete_item'];
            $sql = "DELETE FROM cart WHERE item_number = '$itemNumber' ";
            mysqli_query($dbConn,$sql);
            $_SESSION["cart_items"]--;
            header("Location: #");
            exit();
        }
    }

    function calculatePrices($cartNumber){
        $price=0;
        include "configurate_database.php";
        $sql = "SELECT * FROM cart c JOIN product p ON c.id_product = p.id_product WHERE id_cart=$cartNumber"; 
        $result = mysqli_query($dbConn,$sql);
        while($row=mysqli_fetch_array($result)){
            $pricePerProduct = $row['price'] - checkDiscount($row['id_product'],$row['price']);
            $price += $row['wanted_quantity'] * $pricePerProduct;
        }
        return round($price,2);
    }
?>