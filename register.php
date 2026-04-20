<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = mysqli_real_escape_string($conn, trim($_POST['fullname']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if (empty($fullname) || empty($email) || empty($username) || empty($password) || empty($confirm)) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Check if username or email already exists
        $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username' OR email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Username or email already exists.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (full_name, email, username, pass_word)
                    VALUES ('$fullname', '$email', '$username', '$hashed')";
            if (mysqli_query($conn, $sql)) {
                $success = "Account created! You can now log in.";
            } else {
                $error = "Something went wrong. Please try again.";
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
    <title>Register - Fitness Activity Log</title>
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
        }

        .form-group { margin-bottom: 18px; }

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

        .btn-primary { background: #1a1a1a; color: #fff; }
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

        .alert-success {
            background: #f0faf4;
            color: #2d7a4f;
            border: 1px solid #c3e8d4;
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

        .hint {
            font-size: 0.75rem;
            color: #aaa;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="logo">
        <h1>🏃 Fitness Log</h1>
        <p>Create your account</p>
    </div>

    <div class="card">
        <h2>Create Account</h2>

        <?php if ($error): ?>
            <div class="alert-error">⚠️ <?= $error ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert-success">✅ <?= $success ?> <a href="login.php">Log in now</a></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" placeholder="e.g. Juan Dela Cruz" value="<?= htmlspecialchars($_POST['fullname'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="e.g. juan@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Choose a username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="At least 6 characters" required>
                <p class="hint">Minimum 6 characters</p>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Repeat your password" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
    </div>

    <div class="footer-link">
        Already have an account? <a href="login.php">Log in here</a>
    </div>
</div>

</body>
</html>
