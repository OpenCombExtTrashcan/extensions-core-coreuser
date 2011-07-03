<?php
namespace oc\ext\coreuser ;

use oc\base\FrontFrame;

use jc\auth\IdManager;

use jc\message\Message;

use oc\mvc\controller\Controller;

class Switchuser extends Controller
{
	protected function init()
	{
		// 网页框架
		$this->add(new FrontFrame()) ;
	}

	public function process()
	{
		$aIdMgr = IdManager::fromSession() ;
		
		$aIdMgr->setCurrentId($aIdMgr->id($this->aParams->get("uid"))) ;
		
		
		// 仅仅显示消息队列
		$this->renderMessageQueue() ;
	}

}

?>