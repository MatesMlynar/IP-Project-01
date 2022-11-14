<?php
require_once "inc/db_connect.php";

$poradi = filter_input(INPUT_GET,"poradi");
$sorting_way = "";
$orderBy = "";

if($poradi)
{
    switch ($poradi)
    {
        case "nazev_up":
            $sorting_way = "ASC";
            $orderBy = "name";
            break;
        case "nazev_down":
            $sorting_way = "DESC";
            $orderBy = "name";
            break;
        case "cislo_up":
            $sorting_way = "ASC";
            $orderBy = "no";
            break;
        case "cislo_down":
            $sorting_way = "DESC";
            $orderBy = "no";
            break;
        case "tel_up":
            $sorting_way = "ASC";
            $orderBy = "phone";
            break;
        case "tel_down":
            $sorting_way = "DESC";
            $orderBy = "phone";
            break;
    }
}
else{
        $stmt = $pdo->query("select name, no, phone, room_id from room");
}

if($poradi)
{
    $stmt = $pdo->query("select name, no, phone, room_id from room order by $orderBy $sorting_way");
}


if ($stmt->rowCount() == 0) {
    echo "Záznam neobsahuje žádná data";
}

?>

<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Místnosti</title>
    <link rel="stylesheet" href="styles/rooms-list.css">
    <link rel="stylesheet" href="styles/table-for-list.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/breadcrumb.css">
</head>
<body>

<section class="rooms">

    <div class="rooms__figure">
        <img class="rooms__img" src="images/background.svg" alt="pozadi">
    </div>

    <div class="rooms__content">

        <div class="breadcrumb-own">
            <a class="breadcrumb__link" href="index.html"><span class="breadcrumb__icon glyphicon glyphicon-home"></span>Rozcestník/ </a>
        </div>

        <h1 class="rooms__title">Seznam místností</h1>
        <?php
        require_once "inc/php-functions.php";
        $tableHeadings = [
            ["text" => "Název", "sort_up" => "nazev_up", "sort_down" => "nazev_down"],
            ["text" => "Číslo", "sort_up" => "cislo_up", "sort_down" => "cislo_down"],
            ["text" => "Telefon", "sort_up" => "tel_up", "sort_down" => "tel_down"],
        ];
        GenerateListTable($stmt, $poradi,$tableHeadings,"rooms-list");
        ?>

    </div>

</section>


<script src="https://kit.fontawesome.com/58083debf6.js" crossorigin="anonymous"></script>
</body>
</html>


