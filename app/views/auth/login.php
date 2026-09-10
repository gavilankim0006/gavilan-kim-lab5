
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Product Management</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: white;
            border-radius: 18px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        .logo {
            width: 65px;
            height: 65px;
            margin: 0 auto 20px;
            border-radius: 16px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: bold;
        }

        h1 {
            text-align: center;
            color: #222;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
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

        input {
            width: 100%;
            padding: 13px 15px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
            outline: none;
            transition: 0.2s;
        }

        input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.12);
        }

        .error {
            background: #fff0f0;
            color: #d63031;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        button:hover {
            transform: translateY(-1px);
            opacity: 0.92;
        }

        .hint {
            margin-top: 20px;
            padding: 12px;
            background: #f5f6ff;
            border-radius: 10px;
            text-align: center;
            color: #666;
            font-size: 13px;
        }

        .hint strong {
            color: #555;
        }
    </style>
</head>

<body>

<div class="login-card">

    <div class="logo">P</div>

    <h1>Welcome Back</h1>
    <p class="subtitle">Product Management System</p>

    <?php if (!empty($error)): ?>
        <div class="error">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form action="/login" method="post">

        <div class="form-group">
            <label for="username">Username</label>
            <input
                type="text"
                id="username"
                name="username"
                placeholder="admin"
                autocomplete="username"
                required
            >
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                placeholder="admin123"
                autocomplete="current-password"
                required
            >
        </div>

        <button type="submit">Login</button>

    </form>

    <div class="hint">
        Demo account: <strong>admin</strong> / <strong>admin123</strong>
    </div>

</div>

</body>
</html>

