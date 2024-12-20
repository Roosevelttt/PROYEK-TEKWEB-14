<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Karyawan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
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
            background-position: center;
            color: #f8f9fa !important;
        }

        label {
            color: #f8f9fa !important;
            margin-bottom: 0.5vw;
        }

        .login-box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.35);
            padding: 5px 50px 30px;
            flex-direction: column;
            width: 400px;
        }

        .login-box h2 {
            margin-bottom: 30px;
            text-align: center;
            font-weight: bold;
            color: #333;
            font-size: 24px;
        }

        .login-box .user-box {
            position: relative;
        }

        .login-box .user-box input {
            width: 100%;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            margin-bottom: 30px;
            border: none;
            border-bottom: 1px solid #fff;
            outline: none;
            background: transparent;
        }

        .login-box .user-box label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 10px 0;
            font-size: 16px;
            color: #fff;
            pointer-events: none;
            transition: .5s;
        }

        .login-box .user-box input:focus~label,
        .login-box .user-box input:valid~label {
            top: -20px;
            left: 0;
            color: #03e9f4;
            font-size: 12px;
        }

        .login-box form a {
            position: relative;
            display: inline-block;
            padding: 10px 20px;
            color: #03e9f4;
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            overflow: hidden;
            transition: .5s;
            margin-top: 40px;
            letter-spacing: 4px
        }

        button[type="submit"] {
            margin: 40px auto 10px;
            font-size: 1rem;
            padding: 0.75rem 2.5rem;
            display: block;
            background: rgba(131, 131, 131, 0.06);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color:rgb(255, 255, 255);
            font-weight: 600;
            border-radius: 30px;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
        }

        button[type="submit"]:hover {
            background-color:rgb(0, 0, 0);
            color:rgb(255, 255, 255);
            border-color:rgb(255, 255, 255);
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

        .center-content {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 3vh;
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
            z-index: 1;
            transform: translateY(-25%);
        }

        .text-behind {
            position: absolute;
            font-size: 45px;
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
        .responsive-image {
        width: 100%; /* Gambar akan mengikuti lebar kontainer */
        height: auto; /* Tinggi gambar disesuaikan secara proporsional */
        max-width: 100%; /* Tidak akan melampaui lebar kontainer */
        display: block; /* Menghindari jarak tambahan */
        }

        .navbar-logo {
        height: 100%; /* Gambar akan mengikuti tinggi navbar */
        max-height: 50px; /* Batas maksimal tinggi gambar */
        width: auto; /* Lebar otomatis berdasarkan proporsi gambar */
        object-fit: contain; /* Menjaga proporsi gambar */
        padding: 5px; /* Opsional: memberikan jarak di sekitar gambar */
        }
    </style>
</head>

<body>
    <div class="login-box">
    <div class="center-content">
            <img src="assets/logo6trsnprnt_1.png" alt="Deskripsi gambar" class="responsive-image">
        </div>
        <form id="login-form">
            <div class="user-box">
                <input id="username" type="text" name="username" required>
                <label>Username</label>
            </div>
            <div class="user-box">
                <input id="password" type="password" name="password" required>
                <label>Password</label>
            </div>
            <button type="submit">Login</button>
            <div id="notification" class="notification"></div>
        </form>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', async function(e) {
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
                body: JSON.stringify({
                    username,
                    password
                }),
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses',
                    text: 'Login berhasil.',
                }).then(() => {
                    // Redirect after the modal is closed
                    window.location.href = 'index.php'; // Redirect to dashboard
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
