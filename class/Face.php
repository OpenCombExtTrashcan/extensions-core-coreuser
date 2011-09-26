<?php
namespace oc\ext\coreuser;

use oc\ext\Extension;
use oc\base\FrontFrame;
use jc\auth\IdManager;
use jc\db\ExecuteException;
use oc\mvc\controller\Controller;
use oc\mvc\model\db\Model;
use jc\mvc\view\widget\File;
use jc\message\Message;
use jc\mvc\view\DataExchanger;
use jc\verifier\NotEmpty;
use jc\lang\Exception;

/**
 * 上传用户头像
 * Enter description here ...
 * @author kongyuan
 *
 */
class Face extends Controller
{
	protected function init()
	{
		$aIdMgr = IdManager::fromSession ();
		
		$this->createFormView ( 'Face' );
		//当前登陆者信息
		$this->viewFace->setModel ( Model::fromFragment ( 'user', array ('info' ) ) );
		
		$this->faceupdate = new File ( 'faceupdate', '照片上传', CoreUser::getFaceFolder () );
		$this->viewFace->addWidget ( $this->faceupdate, 'info.face' )->dataVerifiers ()->add ( NotEmpty::singleton (), "照片" );
	}
	
	public function process()
	{
		//必须登录,不登录不让玩
		$this->requireLogined ( '请先登录' );
		
		$userList = IdManager::fromSession ();
		$this->viewFace->model ()->load ( $userList->currentId ()->userId (), "uid" );
		
		$sFacePath = CoreUser::getFaceFolder ()->path () . '/' . $this->viewFace->model ()->data ( 'info.face' );
		$this->viewFace->variables ()->set ( 'sFacePath', $sFacePath );
			
		
			$this->viewFace->exchangeData ( DataExchanger::MODEL_TO_WIDGET );
		
		if ($this->viewFace->isSubmit ( $this->aParams ))
		{
			do
			{
				$this->viewFace->loadWidgets ( $this->aParams );
				if (! $this->viewFace->verifyWidgets ())
				{
					$this->faceupdate->setValue ( null );
					break;
				}
				
				$this->viewFace->exchangeData ( DataExchanger::WIDGET_TO_MODEL );
				try
				{
					if ($this->viewFace->model ()->save ())
					{
						$this->viewFace->hideForm ();
						$this->messageQueue ()->create ( Message::success, "照片提交完成" );
					}
					else
					{
						$this->messageQueue ()->create ( Message::error, "照片提交失败" );
					}
				} catch ( Exception $e )
				{
					$this->messageQueue ()->create ( Message::error, "照片提交失败" );
				}
			
			} while ( 0 );
		}
	}
}

?>