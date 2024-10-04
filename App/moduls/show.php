<?php

use App\moduls\product;


if(isset($_GET['show_id'])){
    $id = $_GET['show_id'];
    $product = Product::show($id);

    echo "<h1>Name: {$product['name']} </h1>";
    echo "<h1>Price: {$product['price']} </h1>";
}
?>

