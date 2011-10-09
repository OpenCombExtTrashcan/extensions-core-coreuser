<?php
namespace oc\ext\coreuser ;

use oc\base\FrontFrame;

use jc\session\Session;
use jc\auth\IdManager;
use jc\auth\Id;
use jc\db\ExecuteException;
use oc\mvc\controller\Controller ;
use oc\mvc\model\db\Model;
use jc\mvc\model\db\orm\PrototypeAssociationMap;
use jc\verifier\Email;
use jc\verifier\Length;
use jc\verifier\NotNull;
use jc\mvc\view\widget\Text;
use jc\mvc\view\widget\Select;
use jc\mvc\view\widget\CheckBtn;
use jc\mvc\view\widget\RadioGroup;
use jc\message\Message ;
use jc\mvc\view\DataExchanger ;


/**
 * 用户列表
 * Enter description here ...
 * @author gaojun
 *
 */
class AllUser extends Controller
{
	protected function init()
	{
		$this->createFormView() ;
		
		$this->aUserModel = Model::fromFragment('user', array(),true) ;
		
		$this->viewAllUser->setModel($this->aUserModel) ;
		
	}
	
	public function process()
	{
		$this->aUserModel->load();
	}
}

?>