<?php 

$currentParams = $viewParams ? $viewParams : $currentParams;
require_once 'Console/Table.php';

$tbl = new Console_Table();

$i = 0;
$j = 0;

print "Battle Ships 1.0 \n";

if($currentParams['columns'])
foreach ($currentParams['columns'] as $column) {
    $tbl->setHeaders(array_merge(array(' '), $currentParams['columns']));
}
print "\n";
if($currentParams['rows'] && $currentParams['columns'])
foreach ($currentParams['rows'] as $row) {
    $j++;
    $rowValues = array();
    $rowValues[] = $row;
    
    foreach ($currentParams['columns'] as $column) {
        if (isset($currentParams['currentShootsArray']) && in_array(strtoupper($row.$column), $currentParams['currentShootsArray'])) {
            if (in_array(strtoupper($row.$column), $currentParams['shipsArray'])) {
                $rowValues[$row.$column] = 'x';
            } else {
                $rowValues[$row.$column] = '-';
            }
        } else {
            $rowValues[$row.$column] = '.';
        }
    }
    
    $currentRow[$row] = $rowValues;
}
if($currentRow) {
    foreach ($currentRow as $r){
        $tbl->addRow($r);
    }
}

echo $tbl->getTable();
   

?>