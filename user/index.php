<?php
session_start();
require_once('../conf/db.php');
try{
    if (!isset($_SESSION['isLogged']) || $_SESSION['isLogged'] === false) {
        header('Location: login.php');
        exit;
    }

    if ($_SESSION['admin'] == 1) {
        header('Location: ../admin/index.php');
    }

    $nameFilter = $_GET['nameFiltr'] ?? null;

    if ($nameFilter === null) {
        $stmt = $db->query("SELECT message.*, user.login FROM message INNER JOIN user ON message.user_id = user.id WHERE message.deleted = 0");
    } else {
        $stmt = $db->prepare("SELECT message.*, user.login FROM message INNER JOIN user ON message.user_id = user.id WHERE user.login LIKE :nameFilter AND message.deleted = 0");
        $stmt->execute([
            ':nameFilter' => "%$nameFilter%"
        ]);
    }

    $data = $stmt->fetchAll();
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
        h1 {
            color: white;
            text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
        }
    </style>
</head>
<body class="container pt-3">
    <h1 class="text-center" style="font-size: xxx-large; font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif">D O B O W Y - F O R U M</h1>
    <br><br>
    <div id="content">
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
            foreach($data as $message):
        ?>
        <tr>
            <td><?= $message['content']?></td>
            <td><?= $message['login']?></td>
            <td><?= $message['date']?></td>
            <td><?php if($_SESSION['user_id'] == $message['user_id']): ?>
                <a href="../tasks/deleteMsg.php?id=<?=$message['id']?>">Usuń</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach ?>
        </tbody>
        </table>
        <form action="" method="get" class="form row mb-4">
            <div class="col-auto">
                <h4>Filtr użytkownika:</h4>
            </div>
            <div class="col-auto">
                <input class="form-control" type="text" name="nameFiltr" id="" value="<?=$nameFilter ?? null?>">
            </div>
            <div class="col-auto">
                <button class="btn btn-primary" type="submit">Filtruj</button>
            </div>
        </form>

        <div class="d-flex justify-content-between mt-3">       
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFormModal">Dodaj wpis</button>
            <form action="logout.php" method="post" class="d-inline">
                <button type="submit" class="btn btn-warning">Wyloguj</button>
            </form>
        </div>
        <br>
        <a href=""><h3 class="text-center" style="color: red, font-size: auto"> -> Uwaga! Odśwież stronę aby zobaczć najnowsze wpisy <- </h3></a>
        <div class="modal fade" id="addFormModal" tabindex="-1" aria-hidden="true">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>