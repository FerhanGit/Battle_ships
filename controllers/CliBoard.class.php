<?php 
class CliBoard
{
 
    /**
     * Loads the layout file and passes some params to it
     * @param array $result
     * @param mixed
     */
    public static function run($result = null)
    {
        $currentParams = array();
        
        if(file_exists('CliBoard.txt')) {
            $currentParams = json_decode(file_get_contents("CliBoard.txt"), 1);
            unlink('CliBoard.txt');
        }
        unset($currentParams['loadViews']);
        $currentParams = array_merge($result, isset($currentParams) ? $currentParams : array());

        if(!isset($currentParams['shipsArray'])) {
            $currentParams['shipsArray'] = $result['shipsArray'];
        } 
        $currentParams = array_merge($currentParams, WebBoardModel::getInstance()->getBoardLabels()); 
          
        file_put_contents("CliBoard.txt", json_encode($currentParams));               
    
        ViewModel::LoadLayout('layoutCli', $currentParams);
    }
    
    
    /**
     * Shoot action - 
     * @param string $shootValue
     * @return array - Params that will be passed to the layout and view files if any
     */
    public static function shoot($params = array())
    {
        $currentParams = array();
        
        if(file_exists('CliBoard.txt')) {
            $currentParams = json_decode(file_get_contents("CliBoard.txt"), 1);
            unlink('CliBoard.txt');
        }
        if(!isset($currentParams['currentShootsArray']) || !is_array($currentParams['currentShootsArray'])) {
            $currentParams['currentShootsArray'] = array();
        }
        
        $currentParams = array_merge(isset($currentParams) ? $currentParams : array());
        
        if(isset($params['shootValue']))
        if(!in_array(strtoupper($params['shootValue']), $currentParams['currentShootsArray'])) {
            $currentParams['currentShootsArray'][] = strtoupper($params['shootValue']);
            if(isset($currentParams['shipsArray']) && in_array(strtoupper($params['shootValue']), $currentParams['shipsArray'])) {
               $currentParams['hitsOnTarget'][] = strtoupper($params['shootValue']);
            }
            
            file_put_contents("CliBoard.txt", json_encode($currentParams));
        }
        
         
        if(isset($currentParams['shipsArray']) && isset($currentParams['hitsOnTarget']) 
            && count($currentParams['hitsOnTarget']) == count($currentParams['shipsArray'])) {
            if(file_exists('CliBoard.txt')) {
                unlink('CliBoard.txt');
            } 
            ViewModel::LoadView('successCli', $currentParams);
        } 
        
        return $currentParams;
       
    }
    
}
