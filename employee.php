<?php
$employee_id = filter_input(
    INPUT_GET,
    'employee_id',
    FILTER_VALIDATE_INT,
    ["options" => ["min_range" => 1]]
);

if (!$employee_id) {
    http_response_code(400);
    echo "<h1>400 Bad request</h1>";
    die();
}

require_once "inc/db_connect.php";

$stmt = $pdo->query("select employee.name as 'name', surname, job, wage, room.name as 'room_name', room.room_id as 'room_id' from employee join room on employee.room = room.room_id where employee.employee_id = $employee_id");
$employee__keys = $pdo->query("select room.room_id as 'room_id', room.name as 'room_name' from room join `key` on room.room_id = `key`.room where key.employee = $employee_id")->fetchAll();

if ($stmt->rowCount() === 0)
{
    http_response_code(404);
    echo "<h1>404 Not Found</h1>";
    die();
}

$employee = $stmt->fetch();
$short_name = substr($employee->name, 0, 1);

?>
<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail osoby <?php echo $employee->surname . " " . $short_name ?>.</title>
    <link rel="stylesheet" href="styles/employee.css">
    <link rel="stylesheet" href="styles/breadcrumb.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>

<section class="employee">

    <div class="employee__figure">
        <img class="employee__img" src="images/background.svg" alt="pozadi">
    </div>

    <div class="employee__content">

        <div class="breadcrumb-own">
            <a class="breadcrumb__link" href="index.html"><span class="breadcrumb__icon glyphicon glyphicon-home"></span>Rozcestník/ </a>
            <a class="breadcrumb__link " href="employees-list.php">Prohlížeč zaměstnanců/ </a>
            <a class="breadcrumb__link" href="room.php?employee_id=<?= $employee_id ?>">Detail zaměstnance</a>
        </div>

        <h1 class="employee__title">Karta osoby: <?=$employee->name?> <?= $employee->surname ?></h1>

        <dl class="dl-horizontal">

            <dt>Jméno</dt> <dd><?= $employee->name ?></dd>
            <dt>Příjmení</dt> <dd><?= $employee->surname?></dd>
            <dt>Pozice</dt> <dd><?= $employee->job?></dd>
            <dt>Mzda</dt> <dd> <?= $employee->wage ?> </dd>
            <dt>Místnost</dt> <dd><a class="employee__link" href="room.php?room_id=<?=$employee->room_id?>"><?= $employee->room_name ?></a></dd>
            <dt>Klíče</dt> <dd> <?php foreach($employee__keys as $key){echo "<a class='employee__link' href='room.php?room_id={$key->room_id}' class='emloyee__link'>$key->room_name</a>"; echo "<br>";} ?> </dd>

        </dl>

        <a class="employee__back-link" href="employees-list.php">Zpět na seznam zaměstnanců</a>
    </div>


</section>


<script src="https://kit.fontawesome.com/58083debf6.js" crossorigin="anonymous"></script>
</body>
</html>
