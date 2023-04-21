<?php
session_start();
require('components/database.php');
$current_page = 'inventory';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit();
}

if (isset($_POST['submit'])) {
    // add product
    $sql = "INSERT INTO product (name, brand, description, unit_price, is_hidden) VALUES (:name, :brand, :description, :unit_price, 1)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $_POST['name']);
    $stmt->bindValue(':brand', $_POST['brand']);
    $stmt->bindValue(':description', $_POST['description']);
    $stmt->bindValue(':unit_price', $_POST['unit_price']);
    $stmt->execute();
    // get id
    $product_id = $pdo->lastInsertId();
    // add product category
    $sql = "INSERT INTO product_category (product_id, category_id) VALUES (:product_id, :category_id)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':product_id', $product_id);
    $stmt->bindValue(':category_id', $_POST['category_id']);
    $stmt->execute();

    header('Location: cms_edit_product.php?id=' . $product_id);
}

$product_sql = "SELECT * FROM product WHERE delete_datetime IS NULL";
$product_stmt = $pdo->prepare($product_sql);
$product_stmt->execute();
$products = $product_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cms_inventory_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <title>TECHLIVE | Online Shop Smart Device</title>
</head>

<body>
    <?php include_once('components/cms_header.php'); ?>

    <section id="page-header">
        <h2>Content Management System</h2>
        <h4>Product Inventory</h4>
    </section>

    <section id="product" class="section-p1">
        <table id="inventory-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Visible?</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($products as $product) {
                    $product_category_sql = "SELECT * FROM product_category INNER JOIN category ON product_category.category_id = category.id WHERE product_id = :id";
                    $product_category_stmt = $pdo->prepare($product_category_sql);
                    $product_category_stmt->bindValue(':id', $product['id']);
                    $product_category_stmt->execute();
                    $product_categories = $product_category_stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                    <tr>
                        <td><?php echo $product['name']; ?></td>
                        <td>
                            <?php
                            foreach ($product_categories as $product_category) {
                                echo $product_category['name'] . '<br />';
                            }
                            ?>
                        <td><?php echo $product['brand']; ?></td>
                        <td><?php echo $product['description']; ?></td>
                        <td><?php echo $product['unit_price']; ?></td>
                        <td><?php echo $product['is_hidden'] ? 'No' : 'Yes'; ?></td>
                        <td>
                            <a class="action-link" href="cms_edit_product.php?id=<?php echo $product['id']; ?>">Edit</a> <br />
                            <a class="action-link" href="cms_change_product_visibility.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure to <?= $product['is_hidden'] ? 'unhide' : 'hide' ?> <?= $product['name'] ?>?');"><?= $product['is_hidden'] ? 'Unhide' : 'Hide' ?></a><br />
                            <a class="action-link" href="cms_delete_product.php?id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure to remove <?= $product['name'] ?>?');">Delete</a>   
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button id="add-product">Add Product</button>
    </section>

    <!-- Add the form overlay and form elements -->
    <div id="form-overlay">
        <form id="product-form" action="" method="POST">
            <h3>Add Product</h3>
            <label for="name">Product Name:</label>
            <input type="text" name="name" required>
            <label for="category">Product Category:</label>
            <select id="category" name="category_id" required>
                <?php
                $category_sql = "SELECT * FROM category";
                $category_stmt = $pdo->prepare($category_sql);
                $category_stmt->execute();
                $categories = $category_stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($categories as $category) {
                ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php } ?>
            </select>
            <label for="brand">Brand:</label>
            <input type="text" name="brand" required>
            <label for="description">Description:</label>
            <textarea name="description" required></textarea>
            <label for="unit_price">Price:</label>
            <input type="number" step="0.01" name="unit_price" required>
            <input type="submit" name="submit" value="Add" />
            <button type="button" id="cancel">Cancel</button>
        </form>
    </div>
    <script src="javascript/cms_inventory_script.js"></script>
</body>
<script>
    <?php
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 'visibility') {
    ?>
            alert('Product visibility has been changed.');
        <?php
        } else if ($_GET['mode'] == 'delete') {
        ?>
            alert('Product has been deleted.');
    <?php
        }
    }
    ?>
</script>

</html>