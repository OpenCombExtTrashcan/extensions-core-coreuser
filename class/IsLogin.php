<?php
namespace oc\ext\coreuser ;

use jc\mvc\controller\Relocater;

use jc\mvc\view\View;

use jc\mvc\controller\WebpageFrame;

use jc\mvc\view\Webpage;

use oc\base\FrontFrame;
use jc\session\Session;
use jc\auth\IdManager;
use jc\auth\Id;
use jc\db\ExecuteException;
use oc\mvc\controller\Controller ;
use oc\mvc\model\db\Model;
use jc\mvc\model\db\orm\PrototypeAssociationMap;
use jc\verifier\Length;
use jc\mvc\view\widget\Text;
use jc\message\Message ;
use jc\mvc\view\DataExchanger ;

/**
 * 用户登录
 * Enter description here ...
 * @author gaojun
 *
 */
class IsLogin extends Controller
{
	protected function init()
	{
		
	}
	
	public function process()
	{
        if(IdManager::fromSession()->currentId())
        {
            echo IdManager::fromSession()->currentId()->userId();
        }else{
            echo "0";
        }
        
        exit;
	}
}

?>