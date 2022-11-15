<?php
require_once "inc/db_connect.php";

$poradi = filter_input(INPUT_GET,"poradi");
$sorting_way = "";
$orderBy = "";

if($poradi)
{
    switch ($poradi)
    {
        case "jmeno_up":
            $sorting_way = "ASC";
            $orderBy = "surname";
            break;
        case "jmeno_down":
            $sorting_way = "DESC";
            $orderBy = "surname";
            break;
        case "mistnost_up":
            $sorting_way = "ASC";
            $orderBy = "room.name";
            break;
        case "mistnost_down":
            $sorting_way = "DESC";
            $orderBy = "room.name";
            break;
        case "tel_up":
            $sorting_way = "ASC";
            $orderBy = "room.phone";
            break;
        case "tel_down":
            $sorting_way = "DESC";
            $orderBy = "room.phone";
            break;
        case "pozice_up":
            $sorting_way = "ASC";
            $orderBy = "employee.job";
            break;
        case "pozice_down":
            $sorting_way = "DESC";
            $orderBy = "employee.job";
            break;
    }
}
else{
    $stmt = $pdo->query("select CONCAT(employee.name,' ',employee.surname,' ') as 'name', room.name as 'room_name', room.phone as 'room_phone', employee.job as 'employee_job', employee_id from employee join room on employee.room = room_id");
}

if($poradi)
{
    $stmt = $pdo->query("select CONCAT(employee.name,' ',employee.surname,' ') as 'name', room.name as 'room_name', room.phone as 'room_phone', employee.job as 'employee_job', employee_id from employee join room on employee.room = room_id order by  $orderBy $sorting_way");
}

if ($stmt->rowCount() == 0) {
    http_response_code(404);
    echo "<h1>Not found</h1>";
    die;
}

?>

<!doctype html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zaměstnanci</title>
    <link href="styles/employees-list.css" rel="stylesheet">
    <link href="styles/table-for-list.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/breadcrumb.css">
</head>
<body>

<section class="employees">

    <div class="employees__figure">
        <img class="employees__img" src="images/background.svg" alt="pozadi">
    </div>

    <div class="employees__content">

        <div class="breadcrumb-own">
            <a class="breadcrumb__link" href="index.html"><span class="breadcrumb__icon glyphicon glyphicon-home"></span>Rozcestník/ </a>
        </div>

        <h1 class="employees__title">Seznam zaměstnanců</h1>

        <?php
        require_once "inc/php-functions.php";
        $tableHeadings = [
            ["text" => "Jméno", "sort_up" => "jmeno_up", "sort_down" => "jmeno_down"],
            ["text" => "Místnost", "sort_up" => "mistnost_up", "sort_down" => "mistnost_down"],
            ["text" => "Telefon", "sort_up" => "tel_up", "sort_down" => "tel_down"],
            ["text" => "Pozice", "sort_up" => "pozice_up", "sort_down" => "pozice_down"],
        ];
        GenerateListTable($stmt, $poradi,$tableHeadings, "employees-list",true);
        ?>

    </div>



</section>

<script src="https://kit.fontawesome.com/58083debf6.js" crossorigin="anonymous"></script>
</body>
</html>
