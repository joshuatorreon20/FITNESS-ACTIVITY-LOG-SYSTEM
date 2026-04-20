<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Activity Log</title>
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
            color: #1a1a1a;
            letter-spacing: -0.3px;
        }

        header span {
            font-size: 0.8rem;
            color: #888;
            font-weight: 300;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .top-bar h2 {
            font-size: 1rem;
            font-weight: 500;
            color: #555;
        }

        .btn {
            display: inline-block;
            padding: 10px 22px;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            border: none;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #1a1a1a;
            color: #fff;
        }

        .btn-primary:hover { background: #333; }

        .btn-danger {
            background: #fff0f0;
            color: #d9534f;
            border: 1px solid #ffd6d6;
        }

        .btn-danger:hover { background: #ffe0e0; }

        .btn-warning {
            background: #fffbf0;
            color: #c8860a;
            border: 1px solid #ffe8b0;
            font-size: 0.8rem;
            padding: 6px 14px;
        }

        .btn-warning:hover { background: #fff3d0; }

        .btn-sm-danger {
            background: #fff0f0;
            color: #d9534f;
            border: 1px solid #ffd6d6;
            font-size: 0.8rem;
            padding: 6px 14px;
        }

        .btn-sm-danger:hover { background: #ffe0e0; }

        .card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e8e8e4;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #fafaf8;
            border-bottom: 1px solid #e8e8e4;
        }

        th {
            padding: 14px 20px;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        td {
            padding: 16px 20px;
            font-size: 0.9rem;
            color: #2a2a2a;
            border-bottom: 1px solid #f0f0ec;
        }

        tr:last-child td { border-bottom: none; }

        tr:hover td { background: #fafaf8; }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            background: #eef4ff;
            color: #3b7dd8;
        }

        .actions { display: flex; gap: 8px; }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #aaa;
        }

        .empty-state p { font-size: 0.95rem; margin-top: 8px; }

        .delete-all-bar {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #e8e8e4;
            border-radius: 12px;
            padding: 20px 24px;
        }

        .stat-card .label {
            font-size: 0.75rem;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .stat-card .value {
            font-family: 'DM Serif Display', serif;
            font-size: 1.8rem;
            color: #1a1a1a;
        }

        .alert {
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 20px;