<?php 
$i = 0;
$j = 0;

print "<h1>Battle Ships 1.0</h1><div class='board' id='board'>";

print "<div id='msgDiv'></div>";

print "<span style='text-align:center; display:inline-block; width: 20px;'>&nbsp;</span>";

foreach ($viewParams['columns'] as $column) {
    print "<span style='text-align:center; display:inline-block; width: 20px;'>" . $column . "</span>";
}

print "<br />";

foreach ($viewParams['rows'] as $row) {
    $i++;
    print "<span style='text-align:center; display:inline-block; width: 20px;'>" . $row . "</span>";
    foreach ($viewParams['columns'] as $column) {
        $j++;
        print "<span class='cell' id = 'cell_" . ($row.$column) . "' style='text-align:center; display:inline-block; width: 20px;background-color: #f9f7f7;'> . </span>";
        if ($j % count($viewParams['columns']) == 0) {
            print "<br />";
        }
    }
}
print "</div>";
?>