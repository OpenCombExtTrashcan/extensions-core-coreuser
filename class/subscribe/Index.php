<?php
namespace oc\ext\coreuser\subscribe ;

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
class Index extends Controller
{
	protected function init()
	{
		$this->createView("viewIndex", "CoreUser.Subscribe.html",true) ;
		
		$this->viewIndex->setModel( Model::fromFragment('subscribe',array("user"),true) ) ;
	}
	
	public function process()
	{
        $this->viewIndex->model()->load(IdManager::fromSession()->currentId()->userId(),"uid") ;
	}
}

?>