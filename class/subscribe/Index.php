<?php
namespace oc\ext\coreuser\subscribe ;

use jc\mvc\view\widget\Paginator;

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
		$this->createView("Index", "Subscribe.html",true) ;
		
		$this->viewIndex->addWidget(new Paginator("paginator",$this->aParams))->setPerPageCount(10);
		
		$this->viewIndex->setModel( Model::fromFragment('subscribe',array("user"=>array("info")),true) ) ;
	}
	
	public function process()
	{
        $this->viewIndex->model()->load(IdManager::fromSession()->currentId()->userId(),"uid") ;
        
        $model = Model::fromFragment('coreuser:subscribe');
        $model -> load(IdManager::fromSession()->currentId()->userId(),"uid");
        $this->viewIndex->model()->setData("gz",$model->totalCount());
        
        $model = Model::fromFragment('coreuser:subscribe');
        $model -> load(IdManager::fromSession()->currentId()->userId(),"subscribeid");
        $this->viewIndex->model()->setData("fs",$model->totalCount());
        
        $model = Model::fromFragment('microblog:microblog');
        $model -> load(IdManager::fromSession()->currentId()->userId(),"uid");
        $this->viewIndex->model()->setData("wb",$model->totalCount());
        
	}
}

?>