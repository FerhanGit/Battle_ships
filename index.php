<?php 
    ini_set('memory_limit','512M');
    ini_set('max_execution_time', 600); //600 seconds = 10 minutes
    session_start();

    if( isset($_GET['debug']) ) {
        error_reporting(E_ALL) ;
    }

    if(isset($_SERVER['REQUEST_URI'])) {
        $URI = explode('/', ($_SERVER['REQUEST_URI']));
    } else {
        $URI = isset($_SERVER['argv']) ? $_SERVER['argv'] : array();
        array_shift($URI);
    }    
    
    if ($URI[0] === '') {
        array_shift($URI);
    }
    
    if ($URI[0] === 'Battle_Ships') {
        array_shift($URI);
    }

    // chop off any GET parameters from the last entry in the array
    $URI[count($URI)-1] = preg_replace('/\?.+$/', '', $URI[count($URI)-1]);

    // fill in the URI array with blanks so we don't get any array index errors
    for ($i = 0; $i < 10; $i++) {
        if (isset($URI[$i]) === false) {
            $URI[$i] = '';
        }
        $URI[$i] = strtolower($URI[$i]);
    }


    spl_autoload_register(function($className) {
        // Define an array of directories in the order of their priority to iterate through.
        $dirs = array(
            'controllers',
            'models',
            'views',
        );

        foreach($dirs as $dir) {
            if (php_sapi_name() == "cli") {
               
                $dir = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . $dir;
            } 
            if (file_exists($dir . DIRECTORY_SEPARATOR .ucfirst($className) . '.class.php')) {
                require_once($dir . DIRECTORY_SEPARATOR .ucfirst($className) . '.class.php');
                return;
            }
        }
    });
   
   
    Application::run($URI);
    
?>
