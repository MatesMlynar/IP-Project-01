<?php
$room_id = filter_input(
    INPUT_GET,
    'room_id',
    FILTER_VALIDATE_INT,
    ["options" => ["min_range" => 1]]
);

if (!$room_id) {
    http_response_code(400);
    echo "<h1>Bad request</h1>";
    die;
}

require_once "inc/db_connect.php";

$stmt = $pdo->prepare("SELECT * FROM `room` WHERE `room_id`=:room_id");
$stmt->execute(['room_id' => $room_id]);

if ($stmt->rowCount() === 0)
{
    http_response_code(404);
    echo "<h1>Not found</h1>";
    die;
}

$room = $stmt->fetch();

$room_wage = $pdo->query("select AVG(wage) as 'wage' from employee where room = $room_id")->fetch();
$room_people = $pdo->query("select CONCAT(name,' ',surname,' ') as 'name',employee_id as 'id' from employee where room = $room_id")->fetchAll();
$room_keys = $pdo->query("select CONCAT(name,' ',surname,' ') as 'name',employee_id as 'id' from employee join ip_3.key on employee.employee_id = ip_3.key.employee where ip_3.key.room = $room_id")->fetchAll();

?>

<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Místnost č. <?= $room->no ?></title>
    <link rel="stylesheet" href="styles/room.css">
    <link rel="stylesheet" href="styles/breadcrumb.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>

<section class="room">

    <div class="room__figure">
        <img class="room__img" src="images/background.svg" alt="pozadi">
    </div>

    <div class="room__content">

        <div class="breadcrumb-own">
            <a class="breadcrumb__link" href="index.html"><span class="breadcrumb__icon glyphicon glyphicon-home"></span>Rozcestník/ </a>
            <a class="breadcrumb__link " href="rooms-list.php">Prohlížeč místnosti/ </a>
            <a class="breadcrumb__link" href="room.php?room_id=<?= $room_id ?>">Detail místnosti</a>
        </div>

        <h1 class="room__title">Místnost č. <?= $room->no ?></h1>

        <dl class="dl-horizontal">

            <dt>Číslo</dt> <dd><?= $room->no ?></dd>
            <dt>Název</dt> <dd><?= $room->name ?></dd>
            <dt>Telefon</dt> <dd><?= $room->phone?></dd>
            <dt>Lidé</dt> <dd> <?php foreach($room_people as $person) {echo "<a href='employee.php?employee_id={$person->id}' class='room__link'>$person->name</a>"; echo "<br>";} ?> </dd>
            <dt>Průměrná mzda</dt> <dd><?= $room_wage->wage ?></dd>
            <dt>Klíče</dt> <dd><?php foreach($room_keys as $person){echo "<a href='employee.php?employee_id={$person->id}' class='room__link'>$person->name</a>"; echo "<br>";} ?></dd>

        </dl>

        <a class="room__back-link" href="rooms-list.php">Zpět na seznam místností</a>
    </div>




</section>

<script src="https://kit.fontawesome.com/58083debf6.js" crossorigin="anonymous"></script>
</body>
</body>
</html>
