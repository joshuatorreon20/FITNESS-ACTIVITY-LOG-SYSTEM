<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Activity - Fitness Log</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f5f5f0;
            color: #1a1a1a;
            min-height: 100vh;
        }

        header {
            background: #fff;
            border-bottom: 1px solid #e8e8e4;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.6rem;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e8e8e4;
            padding: 36px;
        }

        .card h2 {
            font-family: 'DM Serif Display', serif;
            font-size: 1.4rem;
            margin-bottom: 24px;
            color: #1a1a1a;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        input, select {
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

        input:focus, select:focus {
            outline: none;
            border-color: #1a1a1a;
            background: #fff;
        }

        .btn-row {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .btn {
            flex: 1;
            padding: 12px;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            border: none;
            transition: all 0.2s;
        }

        .btn-primary { background: #1a1a1a; color: #fff; }
        .btn-primary:hover { background: #333; }

        .btn-secondary {
            background: #fff;
            color: #555;
            border: 1px solid #e0e0dc;
        }

        .btn-secondary:hover { background: #f5f5f0; }
    </style>
</head>
<body>

<header>
    <h1>🏃 Fitness Activity Log</h1>
    <a href="index.php" style="font-size:0.85rem; color:#888; text-decoration:none;">← Back to list</a>
</header>

<div class="container">
    <div class="card">
        <h2>Add New Activity</h2>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type     = mysqli_real_escape_string($conn, $_POST['activity_type']);
            $duration = (int)$_POST['duration'];
            $distance = (float)$_POST['distance'];
            $location = mysqli_real_escape_string($conn, $_POST['location']);
            $date     = $_POST['activity_date'];

            $sql = "INSERT INTO activities (activity_type, duration, distance, location, activity_date)
                    VALUES ('$type', $duration, $distance, '$location', '$date')";

            if (mysqli_query($conn, $sql)) {
                header("Location: index.php?msg=added");
                exit();
            } else {
                echo "<p style='color:red; margin-bottom:16px;'>Error: " . mysqli_error($conn) . "</p>";
            }
        }
        ?>

        <form method="POST">
            <div class="form-group">
                <label>Activity Type</label>
                <select name="activity_type" required>
                    <option value="">-- Select Activity --</option>
                    <option value="Running">Running</option>
                    <option value="Walking">Walking</option>
                    <option value="Cycling">Cycling</option>
                    <option value="Swimming">Swimming</option>
                    <option value="Gym Workout">Gym Workout</option>
                    <option value="Yoga">Yoga</option>
                    <option value="Hiking">Hiking</option>
                    <option value="Basketball">Basketball</option>
                    <option value="Football">Football</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Duration (minutes)</label>
                <input type="number" name="duration" min="1" placeholder="e.g. 30" required>
            </div>

            <div class="form-group">
                <label>Distance (km)</label>
                <input type="number" name="distance" step="0.1" min="0" placeholder="e.g. 5.0" required>
            </div>

            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" placeholder="e.g. Rizal Park, Manila" required>
            </div>

            <div class="form-group">
                <label>Activity Date</label>
                <input type="date" name="activity_date" required>
            </div>

            <div class="btn-row">
                <a href="index.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Activity</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
