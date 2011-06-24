<?php
namespace oc\ext\coreuser ;

use jc\auth\IdManager;

use jc\message\Message;

use jc\mvc\controller\Controller;

class Switchuser extends Controller
{
	protected function init()
	{}

	public function process()
	{
		$aIdMgr = IdManager::fromSession() ;
		
		$aIdMgr->setCurrentId($aIdMgr->id($this->aParams->get("uid"))) ;
		
		
		// 仅仅显示消息队列
		$this->renderMessageQueue() ;
	}

}

?>