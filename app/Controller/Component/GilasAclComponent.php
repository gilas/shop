<?php
class GilasAclComponent extends Component{
    public $components = array('Auth','Acl');
    
    public static $auth = null;
    
    public function initialize(Controller $controller) {
        self::$auth = $this->Auth;
    }
    
    public static function hasPermission($url){
        $url += array('base' => false);
        $url = Router::url($url);
        $request =new CakeRequest($url);
        $url = Router::parse($url);
        $request->addParams($url);
        return self::$auth->isAuthorized(null, $request);
    }
 }
?>