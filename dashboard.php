<?php
include 'config.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f8d7da 0%, #f48fb1 100%);
        }
        
        .dashboard-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            color: #c2185b;
            margin-bottom: 20px;
        }
        
        .welcome-message {
            background: #fce4ec;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .btn-logout {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(135deg, #f48fb1 0%, #c2185b 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        
        .btn-logout:hover {
            opacity: 0.9;
        }
        
        .user-info {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
         .user-info h3 {
        color: #c2185b;
        margin-bottom: 10px;
    }
    
    .user-info p {
        color: #444;
        
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Dashboard</h1>
        
        <div class="welcome-message">
            <h2>Selamat datang, <?php echo htmlspecialchars($username); ?>!</h2>
            <p>Anda berhasil login ke sistem.</p>
        </div>
        
        <div class="user-info">
            <h3>Informasi Login</h3>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>ID User:</strong> <?php echo $_SESSION['user_id']; ?></p>
            <p><strong>Waktu Login:</strong> <?php echo date('d-m-Y H:i:s'); ?></p>
        </div>
        
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>
</body>
</html>