<?php
namespace oc\ext\coreuser ;

use jc\session\Session;
use jc\auth\IdManager;
use jc\auth\Id;
use jc\db\ExecuteException;
use jc\mvc\controller\Controller ;
use jc\mvc\model\db\Model;
use jc\mvc\model\db\orm\ModelAssociationMap;
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

		$this->createView("defaultView", "AllUser.html") ;
		
		$this->aUserModel = Model::fromFragment('user', array('info'),true) ;
	}
	
	public function process()
	{
		$this->aUserModel->load();
		foreach($this->aUserModel->dataIterator() as $u){
			echo "<pre>";print_r($u);echo "</pre>";
		}
		
	}
}

?>