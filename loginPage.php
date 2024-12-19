<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Karyawan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
     body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('assets/background.jpeg');
            background-size: cover;
            background-position:center;
            color: #f8f9fa !important;
        }
    
        label {
            color:#f8f9fa !important;
            margin-bottom: 0.5vw;
        }
        .login-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.35);
            padding: 20px;
            flex-direction: column;
        }

        .login-container h2 {
            margin-bottom: 30px; 
            text-align: center;
            font-weight: bold;
            color: #333;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px; 
        }

        .form-group label {
            font-weight: bold;
            color: #555;
            font-size: 16px;
        }

        .form-group input {
            width: 100%;
            padding: 12px; 
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button[type="submit"] {
            width: 100%;
            color: #000;
            background: radial-gradient(circle, #ffff00, #E1AD15);
            border-radius: 50px;
            padding: 12px;
            border: none;
            font-size: 18px; 
            cursor: pointer;
            font-weight: bold;
        }

        button[type="submit"]:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.35);
        }

        .notification {
            display: none;
            background-color: #ffdddd;
            color: #d8000c;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #d8000c;
            border-radius: 5px;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #aaa;
        }

        .center-content {
          position: relative;
          display: flex;
          justify-content: center;
          align-items: center;
          padding:3vh;
          height: 30vh;
          text-align: center;
          transform: translateY(10%);
        }

        .sphere {
          width: 30px;
          height: 30px;
          border-radius: 50%;
          background: radial-gradient(circle, #ffff00, #E1AD15);
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
          z-index:1;
          transform: translateY(-25%);
        }

        .text-behind {
          position: absolute;
          font-size: 3vw;
          color: #fff;
          margin: 3vh;
          font-weight: bold;
          z-index: 0;
          white-space: nowrap;
        }
        .title {
          text-align: center;
          font-size: 1.5vw;
          font-weight: bold;
          white-space: nowrap;
          padding: 1vw 0;
        }

        .text-behind:first-child {
            transform: translateY(-50%); 
        }
        .text-behind:last-child {
            transform: translateY(50%); 
        }

    </style>
</head>
<body>
    <div class="login-container">
    <div class="center-content">
        <div class="text-behind">Hartono</div>
        <div class="text-behind">Collections</div>
        <div class="sphere"></div>
    </div>
        <form id="login-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group mb-5">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <div id="notification" class="notification"></div>
        </form>
        <div class="footer">&copy; 2024 Hartono Collection</div>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', async function (e) {
            e.preventDefault();

            const usernameField = document.getElementById('username');
            const passwordField = document.getElementById('password');
            const notification = document.getElementById('notification');

            const username = usernameField.value;
            const password = passwordField.value;

            const response = await fetch('login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ username, password }),
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: 'Login berhasil.',
                }).then(() => {
                    // Redirect after the modal is closed
                    window.location.href = 'dashboard.php'; // Redirect to dashboard
                });
            } else {
                // Reset fields
                usernameField.value = '';
                passwordField.value = '';

                Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Username atau password salah.',
                });
            }
        });
    </script>
</body>
</html>