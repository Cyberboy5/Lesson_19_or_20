<?php
use App\moduls\product;



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_GET['edit_id'])){
    $id = $_GET['edit_id'];
    if(isset($_POST['edit_product'])){
        if (isset($_POST['name']) && isset($_POST['price'])){
            $values = "";
            $name = htmlspecialchars(strip_tags($_POST['name']));
            $price =htmlspecialchars(strip_tags($_POST['price']));
    
            $data = [
                "name" => "{$name}",
                "price" => "{$price}"
            ];
            if (Product::update($data,$id)) {
                header('Location: index.php');
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product CRUD</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container">
        <div class="row">

        <div class="col-8">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="addStudentModalLabel">Update Product</h5>                 
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="edit_product" class="btn btn-primary">Update</button>
                    <a href = "index.php" type="button" class="btn btn-secondary">Bekor qilish</a>
                </div>
            </form>
        </div>
    </div>

    </div>
                
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
