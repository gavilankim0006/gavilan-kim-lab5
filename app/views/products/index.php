<!DOCTYPE html>
<html>
<head><title>Products</title></head>
<body>
    <h2>Products</h2>
    <p>Logged in as <?= $_SESSION['username'] ?> | <a href="/logout">Logout</a></p>
    <a href="/products/create">+ Add Product</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th><th>Name</th><th>Description</th>
            <th>Price</th><th>Qty</th><th>Actions</th>
        </tr>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><?= $p->id ?></td>
            <td><?= $p->product_name ?></td>
            <td><?= $p->description ?></td>
            <td><?= $p->price ?></td>
            <td><?= $p->quantity ?></td>
            <td>
                <a href="/products/edit/<?= $p->id ?>">Edit</a> |
                <a href="/products/delete/<?= $p->id ?>" onclick="return confirm('Delete this product?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>