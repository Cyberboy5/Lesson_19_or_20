<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



use App\moduls\product;


$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1; 

$products = [];
$totalPages = 1;

if (isset($_GET['col']) && isset($_GET['key']) && isset($_GET['search']) && $_GET['search'] !== '') {
    $col = $_GET['col'];
    $key = $_GET['key'];
    $search = $_GET['search'];

    if ($key == 'LIKE') {
        $products = Product::whereLIKE($col, "%$search%");
    } else {
        $products = Product::where($col, $key, $search);
    }

    $totalPages = 1; 
} else {
    $pagination = Product::pagination(10, $page);
    $products = $pagination['contents']; 
    $totalPages = $pagination['total_pages'];
}

if (isset($_POST['addProduct'])) {
    if (isset($_POST['name']) && isset($_POST['price'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        
        $data = [
            "name" => "{$name}",
            "price" => "{$price}"
        ];

        if (Product::create($data)) {
            header('Location: index.php');
            exit;
        } else {
            echo "Failed to add the product.";
        }
    } else {
        echo "Please provide both Name and Price.";
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

<div class="container mt-5">
    <h1 class = "mb-3">Product List</h1>
    <div class="row mb-4">
        <div class="col-md-4">
            <a href = 'index.php' class="btn btn-primary mb-3">Product List</a>
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addProductModal">
                Add Product
            </button>
        </div>

        <div class="col-md-8">
            <form class="form-inline float-right" method="GET" action="">
                <h5 class="mr-3">Filter Products:</h5>
                <div class="form-group mr-2">
                    <label for="col" class="sr-only">Column</label>
                    <select name="col" class="form-control" id="col" required>
                        <option value="id">ID</option>
                        <option value="name">Name</option>
                        <option value="price">Price</option>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <label for="key" class="sr-only">Operator</label>
                    <select name="key" class="form-control" id="key" required>
                        <option value="=">=</option>
                        <option value=">">></option>
                        <option value="<">
                            <
                        </option>
                        <option value="LIKE">LIKE</option>
                    </select>
                </div>
                <div class="form-group mr-2">
                    <label for="search" class="sr-only">Search Term</label>
                    <input type="text" class="form-control" name="search" id="search" placeholder="Enter search term" required>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= $product['name'] ?></td>
                        <td><?= $product['price'] ?>$</td>
                        <td>
                            <a class="btn btn-primary" href="../../../moduls/show.php?show_id=<?= $product['id'] ?>">Show</a>
                            <a class="btn btn-success" href="../../../moduls/edit.php?edit_id=<?= $product['id'] ?>">Edit</a>
                            <a class="btn btn-danger" href="../../../moduls/delete.php?delete_id=<?= $product['id'] ?>">Delete</a>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No Products Found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if ($totalPages > 1): ?>
    <nav>
    <ul class="pagination">
         <?php if ($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Previous</span>
                </a>
            </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">Next &raquo;</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
    </nav>
    <?php endif; ?>

</div>

<!-- Modal for adding product -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
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
                    <button type="submit" name="addProduct" class="btn btn-primary">Add</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
