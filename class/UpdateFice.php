<?php
namespace oc\ext\coreuser ;

use jc\auth\Id;

use jc\mvc\view\widget\File;

use oc\base\FrontFrame;
use jc\mvc\controller\Relocater;
use jc\verifier\NotEmpty;
use jc\auth\IdManager;
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

Class UpdateFice extends Controller
{
	protected function init()
	{
		$this->createFormView ();
		
		//当前登陆者信息
		$this->viewUpdateFice->setModel ( Model::fromFragment ( 'user', array ('info' ) ) );
		
		$this->faceupdate = new File ( 'faceupdate', '照片上传', CoreUser::getFaceFolder () );
		$this->viewUpdateFice->addWidget ( $this->faceupdate, 'info.face' )->dataVerifiers ()->add ( NotEmpty::singleton (), "照片" );
	}
	
	public function process()
	{
	
		//必须登录,不登录不让玩
		$this->requireLogined ( '请先登录' );
		
		$userList = IdManager::fromSession ();
		$this->viewUpdateFice->model ()->load ( $userList->currentId ()->userId (), "uid" );
		
		$sFacePath = CoreUser::getFaceFolder ()->path () . '/' . $this->viewUpdateFice->model ()->data ( 'info.face' );
		$this->viewUpdateFice->variables ()->set ( 'sFacePath', $sFacePath );
			
		$this->viewUpdateFice->exchangeData ( DataExchanger::MODEL_TO_WIDGET );
		
		if ($this->viewUpdateFice->isSubmit ( $this->aParams ))
		{
			do
			{
				$this->viewUpdateFice->loadWidgets ( $this->aParams );
				if (! $this->viewUpdateFice->verifyWidgets ())
				{
					$this->faceupdate->setValue ( null );
					break;
				}
				
				$this->viewUpdateFice->exchangeData ( DataExchanger::WIDGET_TO_MODEL );
				try
				{
					if ($this->viewUpdateFice->model ()->save ())
					{
						$this->viewUpdateFice->hideForm ();
						$this->messageQueue ()->create ( Message::success, "照片提交完成" );
						
						//刷新ID
						$aId = new Id($this->viewUpdateFice->model (),array(
							'id' => 'uid' ,
							'username' => 'username' ,
							'nickname' => 'info.nickname' ,
							'lastlogintime' => 'lastlogintime' ,
							'lastloginip' => 'lastloginip' ,
							'activetime' => 'activetime' ,
							'activeip' => 'activeip' ,
						)) ;
						IdManager::fromSession()->addId($aId) ;
						
						Relocater::locate("/?c=coreuser.updateFice", "成功",3);
					}
					else
					{
						$this->messageQueue ()->create ( Message::error, "照片提交失败" );
					}
				} catch ( Exception $e )
				{
//					$this->messageQueue ()->create ( Message::error, "照片提交失败" );
				}
			
			} while ( 0 );
		}
        
		
	}
}

?>