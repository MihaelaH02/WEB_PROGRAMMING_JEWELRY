<?php
function checkDiscount($id_product, $price){
    include "configurate_database.php";
    $sql = "SELECT * FROM promotions WHERE id_product = ".$id_product;
    if($row=mysqli_fetch_assoc(mysqli_query($dbConn, $sql)))
        return 0.01 * (double)$row['discount'] * $price;
    else return 0;
}
?>