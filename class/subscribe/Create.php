<?php
namespace oc\ext\coreuser\subscribe ;

use jc\mvc\controller\Relocater;

use jc\auth\IdManager;

use oc\base\FrontFrame;

use jc\db\ExecuteException;
use oc\mvc\controller\Controller ;
use oc\mvc\model\db\Model;
use jc\mvc\model\db\orm\PrototypeAssociationMap;
use jc\verifier\Email;
use jc\verifier\Length;
use jc\verifier\NotEmpty;
use jc\mvc\view\widget\Text;
use jc\mvc\view\widget\Select;
use jc\mvc\view\widget\CheckBtn;
use jc\mvc\view\widget\RadioGroup;
use jc\message\Message ;
use jc\mvc\view\DataExchanger ;

/**
 * 用户订阅
 * Enter description here ...
 * @author gaojun
 *
 */
class Create extends Controller
{
	protected function init()
	{
		// 网页框架
		$this->add(new FrontFrame()) ;
		
		$this->createView("defaultView", "CoreUser.Subscribe.html",true) ;
	}
	
	public function process()
	{
		//buildChild
        $this->defaultView->setModel( Model::fromFragment('subscribe') ) ;
        
        if( !$this->defaultView->model()->load(array(IdManager::fromSession()->currentId()->userId(),$this->aParams->get("uid")),array("uid","subscribeid")) )
        {
        	$this->defaultView->model()->setData('uid',IdManager::fromSession()->currentId()->userId()) ;
        	$this->defaultView->model()->setData('subscribeid',$this->aParams->get("uid")) ;
			$this->defaultView->model()->save() ;
        	Relocater::locate("/?c=coreuser.alluser", "关注成功") ;
        }else{
        	Relocater::locate("/?c=coreuser.alluser", "已经关注") ;
        }
	}
}

?>