<?php

use App\moduls\product;

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    Product::delete($id);
    header("Location:index.php");

}

?>

