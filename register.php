<?php
include 'config.php';

// Proses registrasi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $encryption_type = $_POST['encryption_type']; // ambil dari pilihan user

    if (!empty($username) && !empty($password)) {
        // Cek apakah username sudah terdaftar
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username sudah digunakan!";
        } else {
            // Hash password sesuai tipe enkripsi
            $hashedPassword = hashPassword($password, $encryption_type);

            // Simpan user baru
            $stmt = $conn->prepare("INSERT INTO users (username, password, encryption_type) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $hashedPassword, $encryption_type);
            $stmt->execute();

            header("Location: index.php?registered=true");
            exit();
        }
        $stmt->close();
    } else {
        $error = "Harap isi semua field!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        /* Gunakan style yang sama dengan halaman login */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #f8d7da 0%, #f48fb1 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .register-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }
        
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #667eea;
            outline: none;
        }
        
        .btn-register {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #f48fb1 0%, #c2185b 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: opacity 0.3s;
        }
        
        .btn-register:hover {
            opacity: 0.9;
        }
        
        .error {
            background: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .login-link {
    text-align: center;
    margin-top: 20px;
}

.login-link a {
    color: #c2185b !important; /* merah cherry */
    text-decoration: none !important;
    font-weight: 500;
    transition: color 0.3s ease;
}

.login-link a:hover {
    text-decoration: underline !important;
    color: #ad1457 !important; /* merah cherry lebih gelap pas hover */
}

.login-link a:visited {
    color: #c2185b !important; /* tetap cherry setelah diklik */
}

    </style>
</head>
<body>
    <div class="register-container">
        <h2>Registrasi Akun</h2>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
    <label for="encryption_type">Pilih Jenis Enkripsi</label>
    <select id="encryption_type" name="encryption_type" required>
        <option value="bcrypt">bcrypt (default & paling aman)</option>
        <option value="md5">MD5</option>
        <option value="scrypt">scrypt (simulasi)</option>
    </select>
</div>
            
            <button type="submit" class="btn-register">Daftar</button>
        </form>
        
        <div class="login-link">
            <p>Sudah punya akun? <a href="index.php">Login di sini</a></p>
        </div>
    </div>
</body>
</html>