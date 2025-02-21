<?php
session_start();
require_once('../conf/db.php');

$errorLogin = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? null;
    $password = $_POST['password'] ?? null;

    if ($login !== null && $password !== null) {
        $stmt = $db->prepare("SELECT * FROM user WHERE login = :login");
        $stmt->execute(['login' => $login]);
        $user = $stmt->fetch();

        if ($user) {
            $passwordDB=$user['password'];
            if(password_verify($password, $passwordDB)){
                $_SESSION['isLogged'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['admin'] = $user['admin'];
                $_SESSION['error'] = null;
                header('Location: user.php');
                exit;
            } else {
                $errorLogin=true;
            }
        }
        else {
            $errorLogin=true;
        }
    } else {
        $errorLogin=false;
    }
}

$_SESSION['isLogged'] = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Dobowy-Login</title>
    <style>
        body {
            background-image: url('https://t3.ftcdn.net/jpg/03/91/46/10/360_F_391461057_5P0BOWl4lY442Zoo9rzEeJU0S2c1WDZR.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .login-container {
            width: 400px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="login-container bg-white p-4 rounded shadow">
        <h1 class="display-4 mb-4">Witaj na logowaniu</h1>

        <?php if ($errorLogin): ?>
        <p class="text-danger">Niepoprawny login lub hasło.</p>
        <?php endif; ?>

        <form action="" method="post">
            <?php if (isset($_SESSION['error']) && $_SESSION['error'] !== null): ?>
            <p class="text-danger"><?= $_SESSION['error'] ?></p>
            <?php $_SESSION['error']=null; endif; ?>

            <div class="mb-3">
                <input type="text" class="form-control" name="login" placeholder="Login" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <button class="btn btn-success w-100" type="submit">Login</button>
        </form>
        <br>
        <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addFormModal">Jesteś tu nowy?</button>
    </div>


    <div class="modal fade" id="addFormModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="create.php" method="post">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addFormModalLabel">Rejestracja</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Login</span>
                            <input type="text" class="form-control" name="login" placeholder="Username" aria-label="Login" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Password</span>
                            <input type="password" class="form-control" name="password" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                        <button type="submit" class="btn btn-primary">Zapisz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>