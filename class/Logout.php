<?php
namespace oc\ext\coreuser ;

use oc\base\FrontFrame;
use jc\auth\IdManager;
use jc\message\Message;
use oc\mvc\controller\Controller;

class Logout extends Controller
{
	protected function init()
	{
		// 网页框架
		$this->add(new FrontFrame()) ;
	}

	public function process()
	{
		$aIdMgr = IdManager::fromSession() ;
		
		if( $aId=$aIdMgr->currentId() )
		{
			$aIdMgr->removeId( $aId->userId() ) ;
			
			$this->createMessage(Message::success,"%s 用户身份已经从系统中退出了。",$aId->username()) ;
		}
		
		if( $aId=$aIdMgr->currentId() )
		{
			$this->createMessage(Message::notice,"自动切换到 %s 的用户身份。",$aId->username()) ;
		}
		else 
		{
			$this->createMessage(Message::notice,"正在以游客的身份访问。") ;
		}
		
		// 仅仅显示消息队列
		$this->renderMessageQueue() ;
	}

}

?>