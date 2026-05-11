<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Activity - Fitness Log</title>
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
        }

        .form-group { margin-bottom: 20px; }

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
        <h2>Edit Activity</h2>

        <?php
        $id = (int)$_GET['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $type     = mysqli_real_escape_string($conn, $_POST['activity_type']);
            $duration = (int)$_POST['duration'];
            $distance = (float)$_POST['distance'];
            $location = mysqli_real_escape_string($conn, $_POST['location']);
            $date     = $_POST['activity_date'];

            $sql = "UPDATE activities SET
                        activity_type = '$type',
                        duration = $duration,
                        distance = $distance,
                        location = '$location',
                        activity_date = '$date'
                    WHERE id = $id";

            if (mysqli_query($conn, $sql)) {
                header("Location: index.php?msg=updated");
                exit();
            } else {
                echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
            }
        }

        $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM activities WHERE id = $id"));
        if (!$row) {
            echo "<p>Activity not found.</p>";
            exit();
        }
        ?>

        <form method="POST">
            <div class="form-group">
                <label>Activity Type</label>
                <select name="activity_type" required>
                    <?php
                    $types = ['Running','Walking','Cycling','Swimming','Gym Workout','Yoga','Hiking','Basketball','Football','Other'];
                    foreach ($types as $t) {
                        $selected = ($row['activity_type'] === $t) ? 'selected' : '';
                        echo "<option value='$t' $selected>$t</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Duration (minutes)</label>
                <input type="number" name="duration" min="1" value="<?= $row['duration'] ?>" required>
            </div>

            <div class="form-group">
                <label>Distance (km)</label>
                <input type="number" name="distance" step="0.1" min="0" value="<?= $row['distance'] ?>" required>
            </div>

            <div class="form-group">
                <label>Location</label>
                <input type="text" name="location" value="<?= htmlspecialchars($row['location']) ?>" required>
            </div>

            <div class="form-group">
                <label>Activity Date</label>
                <input type="date" name="activity_date" value="<?= $row['activity_date'] ?>" required>
            </div>

            <div class="btn-row">
                <a href="index.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Activity</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

