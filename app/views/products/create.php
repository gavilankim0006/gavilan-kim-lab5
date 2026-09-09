<!DOCTYPE html>
<html>
<head><title>Add Product</title></head>
<body>
    <h2>Add Product</h2>
    <form action="/products/store" method="post">
        <label>Product Name</label><br>
        <input type="text" name="product_name" required><br><br>
        <label>Description</label><br>
        <textarea name="description"></textarea><br><br>
        <label>Price</label><br>
        <input type="number" step="0.01" name="price" required><br><br>
        <label>Quantity</label><br>
        <input type="number" name="quantity" required><br><br>
        <button type="submit">Save</button>
        <a href="/products">Cancel</a>
    </form>
</body>
</html>