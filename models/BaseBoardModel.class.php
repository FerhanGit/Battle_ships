<?php 
class BaseBoardModel
{
    const LABELS = array(
            "rows" => array(0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D', 4 => 'E', 5 => 'F', 6 => 'G', 7 => 'H', 8 => 'I', 9 => 'J'), 
            "columns" => array(0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10));
    
    const COUNT_BATTLESHIPS = 1;
    const COUNT_DESTROYERS = 2;
    
    const SIZE_BATTLESHIPS = 5;
    const SIZE_DESTROYERS = 4;
    
    public static $_orientations = array(0 =>'horizontal', 1 => 'vertical');
    public static $currentShipArray = array();
    public static $shipsArray = array();
    public static $allPositions = array();
    
    
    /**
     * Returns all row/column labels
     * @return array self::LABELS
     */
    public function getBoardLabels()
    {
        return self::LABELS;
    }
    
    /**
     * Returns the maximum allowed count for a ship of type "Battleships"
     * @return int self::COUNT_BATTLESHIPS
     */
    public function getBattleShipsCount()
    {
        return self::COUNT_BATTLESHIPS;
    }
   
    
    /**
     * Returns the maximum allowed count for a ship of type "Destroyer"
     * @return int self::COUNT_DESTROYERS
     */
    public function getDestroyersCount()
    {
        return self::COUNT_DESTROYERS;
    }
   
    /**
     * Returns the predefined size for a ship of type "Battleships"
     * @return int self::SIZE_BATTLESHIPS
     */
    public function getBattleShipsSize()
    {
        return self::SIZE_BATTLESHIPS;
    }
   
    /**
     * Returns the predefined size for a ship of type "Destroyer"
     * @return int self::SIZE_DESTROYERS
     */
    public function getDestroyersSize()
    {
        return self::SIZE_DESTROYERS;
    }
   
    
    /**
     * Returns all possible game board positions like "A1, A2,..., J9, J10"
     * 
     * @return array $result
     */
    public static function getAllCells()
    {
        $result = array();
        $labels = self::LABELS;
        foreach ($labels['rows'] as $column) {
            foreach ($labels['columns'] as $row) {
                $result[] = $column.$row;
            }
        }
        return $result;
    }
    
     
    /**
     * Place a new ship into the game board 
     * 
     * @param type $type
     * @return array $shipsArray
     */
    public static function placeShip($type='BattleShip')
    {
        $allPositions = array();
               
        $labels = self::LABELS;
        
        foreach ($labels['rows'] as $row) {
            foreach ($labels['columns'] as $column) {
                $allPositions[] = $row.$column;
                $allRows[$row][] = $row.$column;
                $allColumns[$column][] = $row.$column;
            }
        }
        
        self::$allPositions = $allPositions;
        
        if ($type == 'BattleShip') {
            $shipSize = self::SIZE_BATTLESHIPS;
        } else{
            $shipSize = self::SIZE_DESTROYERS;
        }
        
        $orientation = array_rand(self::$_orientations);
        $fisrtCell = array_rand($allPositions);

        self::getNextShip($shipSize, $allPositions, $allRows, $allColumns);
      
        return self::$shipsArray;
    }
    
    
    
    /**
     * Calculate the position of a new ship on game board 
     * - if there is an overlap with any other ship on the board, the position of the current one is precalculated
     * 
     * @param type $shipSize
     * @param type $allPositions
     * @param type $allRows
     * @param type $allColumns
     * @return array $currentShipArray
     */
    public static function getNextShip($shipSize, $allPositions, $allRows, $allColumns)
    {
        self::$currentShipArray = array();
        
        $orientation = array_rand(self::$_orientations);
        $fisrtCell = array_rand($allPositions);
        
        $fisrtCellArray = str_split($allPositions[$fisrtCell]);
       
        $rowTitle = $fisrtCellArray[0];
        $colTitle = ($fisrtCellArray[1].(isset($fisrtCellArray[2]) ? $fisrtCellArray[2] : ''));
        
        if (self::$_orientations[$orientation] == 'vertical') {
            $change = 'rows';
            $arrayObject = $allRows;
       
        } else {
            $change = 'columns';
            $arrayObject = $allColumns;
        }

        $i = 1;
        $arrayObjectRand = array_rand($arrayObject);

        foreach ($arrayObject[$arrayObjectRand] as $key => $val) {
            $nextElement = $val;
            if ($i <= $shipSize) {
                if(in_array($nextElement, self::$shipsArray)) {
                    continue;
                } else {
                    self::$currentShipArray[] = $nextElement;
                    self::$shipsArray[] = $nextElement;
                }
                $i++;
            }
            
        }
        
        if (sizeof(self::$currentShipArray) != $shipSize) { 
            self::getNextShip($shipSize, $allPositions, $allRows, $allColumns);
        }
        
        return self::$currentShipArray;
    }
}

