```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Product Management</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            color: #222;
        }

        .navbar {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 18px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-size: 22px;
            font-weight: bold;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout {
            color: white;
            text-decoration: none;
            padding: 8px 14px;
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 8px;
            transition: 0.2s;
        }

        .logout:hover {
            background: rgba(255,255,255,0.15);
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 20px;
        }

        h1 {
            font-size: 30px;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #777;
        }

        .add-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: bold;
            white-space: nowrap;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.06);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th {
            background: #f7f7fb;
            color: #555;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        tbody tr:hover {
            background: #fafaff;
        }

        .price {
            font-weight: bold;
            color: #667eea;
        }

        .quantity {
            background: #f0f1ff;
            color: #5967c9;
            padding: 5px 10px;
            border-radius: 20px;
            display: inline-block;
            font-size: 13px;
            font-weight: bold;
        }

        .edit {
            color: #667eea;
            text-decoration: none;
            font-weight: bold;
            margin-right: 12px;
        }

        .delete {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            color: #888;
            padding: 40px;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 15px 20px;
            }

            .user-area {
                font-size: 13px;
            }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .add-btn {
                width: 100%;
                text-align: center;
            }

            .container {
                margin-top: 25px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="brand">Product Manager</div>

    <div class="user-area">
        <span>👤 <?= $_SESSION['username'] ?></span>
        <a class="logout" href="/logout">Logout</a>
    </div>
</nav>

<div class="container">

    <div class="page-header">
        <div>
            <h1>Products</h1>
            <p class="subtitle">Manage your products and inventory.</p>
        </div>

        <a class="add-btn" href="/products/create">+ Add Product</a>
    </div>

    <div class="card">

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= $p->id ?></td>

                        <td>
                            <strong><?= $p->product_name ?></strong>
                        </td>

                        <td><?= $p->description ?></td>

                        <td class="price">
                            ₱<?= number_format($p->price, 2) ?>
                        </td>

                        <td>
                            <span class="quantity">
                                <?= $p->quantity ?> pcs
                            </span>
                        </td>

                        <td>
                            <a class="edit"
                               href="/products/edit/<?= $p->id ?>">
                                Edit
                            </a>

                            <a class="delete"
                               href="/products/delete/<?= $p->id ?>"
                               onclick="return confirm('Delete this product?')">
                                Delete
                            </a>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

</div>

</body>
</html>
```
