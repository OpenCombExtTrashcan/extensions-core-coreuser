<?php
namespace oc\ext\coreuser\subscribe ;

use jc\mvc\controller\Relocater;

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
 * Enter description here ...
 * @author gaojun
 *
 */
class Remove extends Controller
{
	protected function init()
	{
		$this->model = Model::fromFragment('subscribe');
	}
	
	public function process()
	{
		
		$this->model->load(array(IdManager::fromSession()->currentId()->userId(),$this->aParams->get("uid")),array("uid","subscribeid"));
		
		if($this->model->delete())
		{
		    Relocater::locate("?c=coreuser.subscribe.index", "删除成功") ;
		}
	}
}

?>