<?php 
class Application implements Board
{
    static $_instance = null;
        
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    
    private function __construct()
    {
    }
    
    
    /**
     * Parse the request and serve the result output
     * @param array $URI
     * @return mixed
     */
    public function run($URI = null)
    {
        $result = self::getInstance()->_parseRequest($URI);
        
        WebBoardModel::getInstance()->placeShip('BattleShip');
        WebBoardModel::getInstance()->placeShip('BattleShip');
        WebBoardModel::getInstance()->placeShip('Destroyer');
 
       
        if (php_sapi_name() == "cli") { 
            $result['shipsArray'] = BaseBoardModel::$shipsArray;
            $result['allPositions'] = BaseBoardModel::$allPositions;
            return CliBoard::run($result);
            // In cli-mode
        } else {
            $_SESSION['battleShips']['shipsArray'] = BaseBoardModel::$shipsArray;
            $_SESSION['battleShips']['allPositions'] = BaseBoardModel::$allPositions;
            
            return WebBoard::run($result);
            // Not in cli-mode
        }

    }
    
    
    /**
     * Converts any given request into Controller::method($params) call 
     * 
     * @param array $URI
     * @return array $result
     */
    private function _parseRequest($URI = null)
    {
        $result = array();
        
        if ($URI[0] !== '' && $URI[1] !== '') {
            $className = ucfirst($URI[0]);
            $methodName = $URI[1];
            $params = array_slice($URI, 1);
            if (php_sapi_name() == "cli") {
                $params = array('controller' => $className, 'method' => $methodName);
                if (isset($URI[2]) && !empty($URI[2])) {
                    $params['shootValue'] = $URI[2];
                }
            }
            $_SESSION['battleShips']['getParams'] = $params;
           
            $result = $className::$methodName($params);
          
        }
       
        return $result;
    }
    
    
    
    public function __destruct()
    {
        if (php_sapi_name() == "cli") {
            if(file_exists('CliBoard.txt')) {
            unlink('CliBoard.txt');
        } elseif (isset($_SESSION['battleShips'])) {
               // unset($_SESSION['battleShips']);
            }
        }
    }
}
