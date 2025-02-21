<?php
session_start();
try{
    require_once('../conf/db.php');

    if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] === false) {
        header('Location: ../user/login.php');
        exit;
    }

    if ($_SESSION['admin'] != 1) {
        header('Location: ../user/index.php');
        exit;
    }

    $loginFilter = $_GET['login'] ?? null;
    if ($loginFilter === null) {
        $stmt = $db->query("SELECT * FROM user");
    } else {
        $stmt = $db->prepare("SELECT * FROM user WHERE login LIKE :login");
        $stmt->execute([
            ':login' => "%$loginFilter%",
        ]);
    }
    $dataUSER = $stmt->fetchAll();

    $nameFilter = $_GET['nameFiltr'] ?? null;

    if ($nameFilter === null) {
        $stmt = $db->query("SELECT message.*, user.login FROM message INNER JOIN user ON message.user_id = user.id");
    } else {
        $stmt = $db->prepare("SELECT message.*, user.login FROM message INNER JOIN user ON message.user_id = user.id WHERE user.login LIKE :nameFilter");
        $stmt->execute([
            ':nameFilter' => "%$nameFilter%"
        ]);
    }
    $dataMSG = $stmt->fetchAll();
}
catch(PDOException $e) {?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Lista zadań</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <style>
                th {
                    font-family: 'Courier New', Courier, monospace;
                }
                body {
                    background-image: url('https://coolbackgrounds.io/images/backgrounds/index/compute-ea4c57a4.png');
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                }

                #content {
                    background-color: rgba(255, 255, 255, 0.8);
                    padding: 20px;
                    border-radius: 10px;
                }
                h1 {
                    color: white;
                    text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
                }
            </style>
        </head>
        <body class="container pt-3">
            <div id="content">
                <h1 class="text-center" style="font-size: x-large;">Przepraszamy, wystąpił błąd po stronie serwera...</h1>
                <br>
                <h3 class="text-center" style="font-size: large;"><i>Staramy się to naprawić</i></h3>
                <br>
                <h4 class="text-center"><b>Wyjątek <?=$e?></b></h4>
            </div>
        </body>
    </html>
<?php
}
catch(Exception $e) {?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Lista zadań</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
            <style>
                th {
                    font-family: 'Courier New', Courier, monospace;
                }
                body {
                    background-image: url('https://coolbackgrounds.io/images/backgrounds/index/compute-ea4c57a4.png');
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                }

                #content {
                    background-color: rgba(255, 255, 255, 0.8);
                    padding: 20px;
                    border-radius: 10px;
                }
                h1 {
                    color: white;
                    text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
                }
            </style>
        </head>
        <body class="container pt-3">
            <div id="content">
                <h1 class="text-center" style="font-size: x-large;">Przepraszamy, wystąpił błąd po stronie serwera...</h1>
                <br>
                <h3 class="text-center" style="font-size: large;"><i>Staramy się to naprawić</i></h3>
                <br>
                <h4 class="text-center"><b>Wyjątek <?=$e?></b></h4>
            </div>
        </body>
    </html>
<?php
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista zadań</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    body {
        background-image: url('https://asset.gecdesigns.com/img/background-templates/abstract-gold-and-black-gradient-triangle-background-design-10032406-1710079670779-cover.webp');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    #content {
        background-color: rgba(255, 255, 255, 0.8); 
        padding: 20px;
        border-radius: 10px;
    }

    .content {
        background-color: rgba(255, 255, 255, 0.8); 
        padding: 20px;
        border-radius: 10px;
    }

    .table {
        background-color: rgba(255, 255, 255, 0.6); 
        border-radius: 10px;
        overflow: hidden; 
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .table th:nth-child(1), .table td:nth-child(1) {
        width: 60%;
    }

    .table th:nth-child(2), .table td:nth-child(2),
    .table th:nth-child(3), .table td:nth-child(3),
    .table th:nth-child(4), .table td:nth-child(4) {
        width: 13.33%;
    }

    h1, h2 {
        color: black;
        text-shadow: none;
    }
    </style>
</head>
<body class="container pt-3">

    <div id="content">
        <h1 class="text-center" style="font-size: xxx-large; font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif">Lista użytkowników</h1>
        <div class="content">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Login</th>
                        <th>Password</th>
                        <th>Admin</th>
                        <th>Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataUSER as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['login'] ?></td>
                        <td><?= $user['password'] ?></td>
                        <td><?php if($user['admin'])echo "tak"; else echo "nie"?></td>
                        <td>
                            <form action="delete.php" method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form action="" method="get" class="form row mb-4">
                <div class="col-auto">
                    <h3>Filtruj:</h3>
                </div>
                <div class="col-auto">
                    <input class="form-control" type="text" name="login" id="" value="<?=$loginFilter?>">
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" type="submit">Filtruj</button>
                </div>
            </form>  

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFormModal">Dodaj użytkownika</button>

            <div class="modal fade" id="addFormModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="../user/create.php" method="post">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addFormModalLabel">Tworzenie użytkownika</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
                            </div>
                            <div class="modal-body">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Login</span>
                                    <input type="text" class="form-control" placeholder="Username" aria-label="Login" aria-describedby="basic-addon1" name="login">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1">Password</span>
                                    <input type="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" name="password">
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
        </div>
                
        <br><br>

        <h1 class="text-center" style="font-size: xxx-large; font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif">D O B O W Y - F O R U M</h1>
        
        <div class="content">
            <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Wpis</th>
                    <th>Użytkownik</th>
                    <th>Data</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
                foreach($dataMSG as $message):
            ?>
            <tr>
                <td><?= $message['content']?></td>
                <td><?= $message['login']?></td>
                <td><?= $message['date']?></td>
                <td><a href="../tasks/deleteMsg.php?id=<?=$message['id']?>">Usuń</a></td>
                </tr>
            <?php endforeach ?>
            </tbody>
            </table>
            <form action="" method="get" class="form row mb-4">
                <div class="col-auto">
                    <h4>Pokaż wiadomości od użytkownika:</h4>
                </div>
                <div class="col-auto">
                    <input class="form-control" type="text" name="nameFiltr" id="" value="<?=$nameFilter ?? null?>">
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" type="submit">Filtruj</button>
                </div>
            </form>

            <div class="d-flex justify-content-between mt-3">       
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFormModal2">Dodaj wpis</button>
            </div>
            <div class="modal fade" id="addFormModal2" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <form action="../tasks/createMsg.php" method="post">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="addFormModalLabel">Nowy wpis</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zamknij"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <textarea class="form-control" id="name-text" name="nowyWpis"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zamknij</button>
                        <button type="submit" class="btn btn-primary">Wyślij</button>
                    </div>
                </form>
                </div>
            </div>
            </div>
        </div>
        <br>
        <div class="d-flex justify-content-end">
                <a href="../user/logout.php"><button type="button" class="btn btn-danger">Wyloguj</button></a>
        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>