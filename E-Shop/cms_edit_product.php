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
    $sql = "UPDATE product SET name = :name, brand = :brand, description = :description, unit_price = :unit_price WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $_POST['name']);
    $stmt->bindValue(':brand', $_POST['brand']);
    $stmt->bindValue(':description', $_POST['description']);
    $stmt->bindValue(':unit_price', $_POST['price']);
    $stmt->bindValue(':id', $_POST['id']);
    $stmt->execute();

    $category_sql = "UPDATE product_category SET category_id = :category_id WHERE product_id = :product_id";
    $category_stmt = $pdo->prepare($category_sql);
    $category_stmt->bindValue(':category_id', $_POST['category']);
    $category_stmt->bindValue(':product_id', $_POST['id']);
    $category_stmt->execute();

    header('Location: cms_edit_product.php?id=' . $_POST['id'] . '&mode=edit_product');
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM product WHERE id = :id AND delete_datetime IS NULL";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        header('Location: cms_inventory.php');
        exit();
    }
    // colors
    $color_sql = "SELECT * FROM product_color WHERE product_id = :id";
    $color_stmt = $pdo->prepare($color_sql);
    $color_stmt->bindValue(':id', $id);
    $color_stmt->execute();
    $colors = $color_stmt->fetchAll(PDO::FETCH_ASSOC);

    // categories
    $product_category_sql = "SELECT * FROM product_category WHERE product_id = :id";
    $product_category_stmt = $pdo->prepare($product_category_sql);
    $product_category_stmt->bindValue(':id', $id);
    $product_category_stmt->execute();
    $product_categories = $product_category_stmt->fetchAll(PDO::FETCH_ASSOC);

    // category list
    $category_sql = "SELECT * FROM category";
    $category_stmt = $pdo->prepare($category_sql);
    $category_stmt->execute();
    $categories = $category_stmt->fetchAll(PDO::FETCH_ASSOC);

    // images
    $image_sql = "SELECT * FROM product_image WHERE product_id = :id";
    $image_stmt = $pdo->prepare($image_sql);
    $image_stmt->bindValue(':id', $id);
    $image_stmt->execute();
    $images = $image_stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header('Location: cms_inventory.php');
    exit();
}
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

    <form id="product" class="section-p1" action="<?= $_SERVER['PHP_SELF'] ?>?id=<?= $id ?>" method="POST">
        <table id="inventory-table">
            <tr>
                <th><h4>Product Name </h4></th>
                <td><input  type="text" name="name" value="<?= $row['name'] ?>" required /></td>
            </tr>
            <tr>
                <th><h4>Product Category</h4></th>
                <td>
                    <select class="selection-type" name="category" id="">
                        <?php foreach ($categories as $category) : ?>
                            <option value="<?= $category['id'] ?>" <?= $category['id'] == $product_categories[0]['category_id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><h4>Brand</h4></th>
                <td><input type="text" name="brand" value="<?= $row['brand'] ?>" required /></td>
            </tr>
            <tr>
                <th><h4>Description</h4></th>
                <td><textarea name="description" id="" cols="100" rows="10" required><?= $row['description'] ?></textarea></td>
            </tr>
            <tr>
                <th><h4>Price</h4></th>
                <td><input type="number" name="price" value="<?= $row['unit_price'] ?>" required /></td>
            </tr>
            <tr>
                <input type="hidden" name="id" value="<?= $id ?>">
                <td colspan="2"><input class="action-link" type="submit" name="submit" value="Update" /></td>
            </tr>
        </table>
    </form>
    <form id="product" class="section-p1" action="cms_add_product_color.php" method="POST">
        <table>
            <tr>
                <th><h4>Colors</h4></th>
                <td>
                    <table>
                        <?php foreach ($colors as $color) : ?>
                            <tr>
                                <td><?= $color['color'] ?></td>
                                <td>
                                    <a class="action-link" href="/cms_change_color_visibility.php?id=<?= $color['id'] ?>" onclick="return confirm('Are you sure to <?= $color['is_hidden'] ? 'unhide' : 'hide' ?> <?= $color['color'] ?>?');"><?= $color['is_hidden'] ? 'Unhide' : 'Hide' ?></a><br>
                                    <a class="action-link" href="/cms_delete_product_color.php?id=<?= $color['id'] ?>" onclick="return confirm('Are you sure to remove <?= $color['color'] ?>?');">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2">
                                <input  type="text" name="color" id="" placeholder="Color" required>
                                <input  type="hidden" name="product_id" value="<?= $id ?>">
                                <input class="action-link"  type="submit" name="submit" value="Add Color" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
    <form id="product" class="section-p1" action="cms_add_product_image.php" method="POST">
        <table>
            <tr>
                <th><h4>Images</h4></th>
                <td>
                    <table>
                        <?php foreach ($images as $image) : ?>
                            <tr>
                                <td><img src="<?= $image['image_path'] ?>" alt="" width="100px"></td>
                                <td>
                                    <a class="action-link" href="/cms_change_image_visibility.php?id=<?= $image['id'] ?>" onclick="return confirm('Are you sure to <?= $image['is_hidden'] ? 'unhide' : 'hide' ?> this image?');"><?= $image['is_hidden'] ? 'Unhide' : 'Hide' ?></a><br>
                                    <a class="action-link" href="/cms_delete_product_image.php?id=<?= $image['id'] ?>" onclick="return confirm('Are you sure to remove this image?');">Remove</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (count($images) < 4) : ?>
                            <tr>
                                <td colspan="2">
                                    <input  type="text" name="image_path" id="" placeholder="Image Path" required>
                                    <input  type="hidden" name="product_id" value="<?= $id ?>">
                                    <input type="submit" name="submit" value="Add Image" />
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
        </table>
    </form>

    <script src="javascript/cms_inventory_script.js"></script>
</body>

<script>
    <?php
    if (isset($_GET['mode'])) {
        if ($_GET['mode'] == 'add_image') {
    ?>
            alert('Image added successfully');
        <?php
        } else if ($_GET['mode'] == 'delete_image') {
        ?>
            alert('Image deleted successfully');
        <?php
        } else if ($_GET['mode'] == 'image_visibility') {
        ?>
            alert('Image visibility changed successfully');
        <?php
        } else if ($_GET['mode'] == 'add_color') {
        ?>
            alert('Color added successfully');
        <?php
        } else if ($_GET['mode'] == 'delete_color') {
        ?>
            alert('Color deleted successfully');
        <?php
        } else if ($_GET['mode'] == 'color_visibility') {
        ?>
            alert('Color visibility changed successfully');
        <?php
        } else if ($_GET['mode'] == 'edit_product') {
        ?>
            alert('Product updated successfully');
    <?php
        }
    }
    ?>
</script>

</html>