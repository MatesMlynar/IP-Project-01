<?php

function GenerateListTable($stmt, $poradi, $tableHeadings,$file, $isFromEmployeeList = false){

    echo "<table class='table'>";

        echo "<tr class='table__row'>";
        foreach($tableHeadings as $heading)
        {
               echo "<th class='table__heading'>";

                    echo "{$heading['text']}";

                    $classSortUp = $poradi === "{$heading['sort_up']}" ? "sorted":"";
                    echo "<a href='{$file}.php?poradi={$heading['sort_up']}'><span class='table__heading-arrow-up {$classSortUp}'></a> ";

                    $classSortDown = $poradi === "{$heading['sort_down']}" ? "sorted":"";
                    echo "<a href='{$file}.php?poradi={$heading['sort_down']}'><span class='table__heading-arrow-down {$classSortDown}'></a> ";

               echo "</th>";

        }
        echo "</tr>";

        while($row = $stmt->fetch())
        {
            echo "<tr class='table__row'>";
                if(!$isFromEmployeeList)
                {
                    echo "<td class='table__data'><a class='table__link' href='room.php?room_id=$row->room_id'>{$row->name}</a></td>";
                    echo "<td class='table__data'>{$row->no}</td>";
                    echo "<td class='table__data'>{$row->phone}</td>";
                }
                if($isFromEmployeeList){
                    echo "<td class='table__data'><a class='table__link' href='employee.php?employee_id=$row->employee_id'>{$row->name}</a></td>";
                    echo "<td class='table__data'>$row->room_name</td>";
                    echo "<td class='table__data'>$row->room_phone </td>";
                    echo "<td class='table__data'>$row->employee_job</td>";
                }
            echo "</tr>";
        }

    echo "</table>";
}
?>