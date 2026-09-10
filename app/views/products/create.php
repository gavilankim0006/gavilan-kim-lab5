
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Product Management</title>

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
        }

        .brand {
            font-size: 22px;
            font-weight: bold;
        }

        .container {
            max-width: 700px;
            margin: 45px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.07);
        }

        h1 {
            margin-bottom: 8px;
        }

        .subtitle {
            color: #777;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        input,
        textarea {
            width: 100%;
            padding: 13px 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            outline: none;
            transition: 0.2s;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.12);
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        button,
        .cancel {
            flex: 1;
            padding: 13px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }

        button {
            border: none;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .cancel {
            border: 1px solid #ddd;
            color: #555;
            background: white;
        }

        button:hover,
        .cancel:hover {
            opacity: 0.9;
        }

        @media (max-width: 600px) {
            .card {
                padding: 25px 20px;
            }

            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="brand">Product Manager</div>
</nav>

<div class="container">

    <div class="card">

        <h1>Add Product</h1>
        <p class="subtitle">Enter the details of your new product.</p>

        <form action="/products/store" method="post">

            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input
                    type="text"
                    id="product_name"
                    name="product_name"
                    placeholder="Enter product name"
                    required
                >
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    placeholder="Enter product description"
                ></textarea>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input
                    type="number"
                    id="price"
                    name="price"
                    step="0.01"
                    min="0"
                    placeholder="0.00"
                    required
                >
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input
                    type="number"
                    id="quantity"
                    name="quantity"
                    min="0"
                    placeholder="Enter quantity"
                    required
                >
            </div>

            <div class="buttons">
                <a class="cancel" href="/products">Cancel</a>
                <button type="submit">Save Product</button>
            </div>

        </form>

    </div>

</div>

</body>
</html>

