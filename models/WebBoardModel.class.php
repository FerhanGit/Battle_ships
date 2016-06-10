<?php 
class WebBoardModel extends BaseBoardModel
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
    
    
}
