<?php
namespace oc\ext\coreuser ;

use jc\message\Message;

use oc\base\FrontFrame;
use oc\mvc\controller\Controller;

class MessageAndQueuePrototype extends Controller
{
	protected function init()
	{
		
		
	}

	public function process()
	{
		$this->createMessage(Message::forbid,"操作被禁止时的消息。") ;
		$this->createMessage(Message::success,"操作成功时的消息。") ;
		$this->createMessage(Message::failed,"操作失败时的消息。") ;
		$this->createMessage(Message::error,"操作错误时的消息。") ;
		$this->createMessage(Message::warning,"警告消息。") ;
		$this->createMessage(Message::notice,"普通消息。") ;
		
		// 仅仅显示消息队列
		$this->renderMessageQueue() ;
	}
	

}

?>