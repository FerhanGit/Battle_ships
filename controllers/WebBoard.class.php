<?php 
class WebBoard
{
    /**
     * Loads the layout file and passes some params to it
     * @param array $result
     * @param mixed
     */
    public static function run($result = null)
    {
        ViewModel::LoadLayout('layout', $result);
    }
    
    /**
     * Shoot action - 
     * @param array $params
     * @return array - Params that will be passed to the layout and view files if any
     */
    public static function shoot($params = array())
    {
        return array_merge(
            WebBoardModel::getInstance()->getBoardLabels(), 
            $params, 
            array('loadViews' => array('board', 'form')));
    }
    
     
        
    /**
     * Show action - shows ships positions. 
     * Available only for authenticated users 
     * 
     * @param array $params
     * @return array - Params that will be passed to the layout and view files if any
     */
    public static function show($params = array())
    {
        if($this->_getAuth()) {
            return array_merge(
                WebBoardModel::getInstance()->getBoardLabels(), 
                $params, 
                array('loadViews' => array('show', 'form')));
        }
    }
    
    
    /**
     * Authenticates user to allow some actions
     * 
     * @return boolean
     */
    private function _getAuth()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Sorry this action is not allowed for you';
            return false;
        } else {
            
            if ($_SERVER['PHP_AUTH_USER'] == 'testUser' && $_SERVER['PHP_AUTH_PW'] == 'testPassword') {
                return true;
            }
            
            return false;
            
        }
    }
    
    
}
