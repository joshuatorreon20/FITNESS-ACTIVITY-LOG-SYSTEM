<?php
session_start();

// If already logged in, go to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            header("Location: index.php?msg=welcome");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fitness Activity Log</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f5f5f0;
            color: #1a1a1a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.8rem;
            color: #1a1a1a;
        }

        .logo p {
            font-size: 0.85rem;
            color: #999;
            margin-top: 4px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid #e8e8e4;
            padding: 36px;
        }

        .card h2 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.3rem;
            margin-bottom: 24px;
            color: #1a1a1a;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #e0e0dc;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            color: #1a1a1a;
            background: #fafaf8;
            transition: border 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #1a1a1a;
            background: #fff;
        }

        .btn {
            width: 100%;
            padding: 13px;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            margin-top: 8px;
        }

        .btn-primary {
            background: #1a1a1a;
            color: #fff;
        }

        .btn-primary:hover { background: #333; }

        .alert-error {
            background: #fff0f0;
            color: #d9534f;
            border: 1px solid #ffd6d6;
            border-radius: 8px;
            padding: 11px 14px;
            font-size: 0.85rem;
            margin-bottom: 18px;
        }

        .footer-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: #888;
        }

        .footer-link a {
            color: #1a1a1a;
            font-weight: 500;
            text-decoration: none;
        }

        .footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="logo">
        <h1>🏃 Fitness Log</h1>
        <p>Track your fitness activities</p>
    </div>

    <div class="card">
        <h2>Welcome back</h2>

        <?php if ($error): ?>
            <div class="alert-error">⚠️ <?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-primary">Log In</button>
        </form>
    </div>

    <div class="footer-link">
        Don't have an account? <a href="register.php">Register here</a>
    </div>
</div>

</body>
</html>


