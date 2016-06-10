<?php 
class ViewModel
{
    static $_instance = null;
        
    const LAYOUT_DIR = "views";
    const VIEWS_DIR = "views";
    
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
     * Loads view file
     * @param type $viewName
     * @param type $viewParams
     * @return type
     */
    public static function LoadView($viewName, $viewParams = array())
    {
        if (php_sapi_name() == "cli") {
            $dir = __DIR__ .  DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . self::VIEWS_DIR;
        } else {
            $dir = self::VIEWS_DIR;
        }

        if (file_exists($dir . DIRECTORY_SEPARATOR . strtolower($viewName) . '.php')) {
            require_once($dir . DIRECTORY_SEPARATOR . strtolower($viewName) . '.php');
            return;
        }
    }
    
    
    /**
     * Loads layout file
     * @param type $layoutName
     * @param type $layoutParams
     * @return type
     */
    public static function LoadLayout($layoutName, $layoutParams = array())
    {
        if (php_sapi_name() == "cli") {
            $dir = __DIR__ .  DIRECTORY_SEPARATOR . '..' .  DIRECTORY_SEPARATOR . self::LAYOUT_DIR;
        } else {
            $dir = self::LAYOUT_DIR;
        }

        if (file_exists($dir . DIRECTORY_SEPARATOR . strtolower($layoutName) . '.php')) {
            require_once($dir . DIRECTORY_SEPARATOR . strtolower($layoutName) . '.php');
            return;
        }
    }
    
}
