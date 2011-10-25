<?php
namespace oc\ext\coreuser ;

use jc\mvc\controller\Relocater;

use jc\mvc\view\View;

use jc\mvc\controller\WebpageFrame;

use jc\mvc\view\Webpage;

use oc\base\FrontFrame;
use jc\session\Session;
use jc\auth\IdManager;
use jc\auth\Id;
use jc\db\ExecuteException;
use oc\mvc\controller\Controller ;
use oc\mvc\model\db\Model;
use jc\mvc\model\db\orm\PrototypeAssociationMap;
use jc\verifier\Length;
use jc\mvc\view\widget\Text;
use jc\message\Message ;
use jc\mvc\view\DataExchanger ;

/**
 * 用户登录
 * Enter description here ...
 * @author gaojun
 *
 */
class Login extends Controller
{
	protected function init()
	{
		$this->createFormView() ;

		// 为视图创建、添加窗体，并为窗体添加校验器
		$this->viewLogin->addWidget( new Text("username","用户名",''), 'username' );
						    
		$this->viewLogin->addWidget( new Text("password","密码",'',Text::password), 'password' )
						    ->addVerifier( Length::flyweight(array(6,40)) ) ;

		$this->aUserModel = Model::fromFragment('user', array('info')) ;
		
	}
	
	public function process()
	{
	    //最新列表
	    $blogModel = Model::fromFragment('microblog:microblog', array('userto'=>array("info"),'forward'=>array('userto')), true);
	    $blogModel->criteria()->orders()->add("time",false) ;
	    $blogModel->criteria()->setLimit("3");
    	$blogModel->load();  
    	$this->viewLogin->setModel($blogModel);
	    
	    
		$aId = new Id($this->aUserModel,array(
				'id' => 'uid' ,
				'username' => 'username' ,
				'nickname' => 'info.nickname' ,
				'lastlogintime' => 'lastlogintime' ,
				'lastloginip' => 'lastloginip' ,
				'activetime' => 'activetime' ,
				'activeip' => 'activeip' ,
		)) ;
			
		
		//切换用户
		//登录
	    if( $this->viewLogin->isSubmit( $this->aParams ) )		 
		{do{
			// 加载 视图窗体的数据
			$this->viewLogin->loadWidgets( $this->aParams ) ;
			            	
			// 校验 视图窗体的数据
			if( !$this->viewLogin->verifyWidgets() )
			{
				break ;
			}
				
			if( !$this->aUserModel->load($this->aParams["username"],"username") )
			{
				$this->viewLogin->createMessage( Message::failed, "用户名不存在:%s。", $this->aParams["username"] ) ;
				break ;
			}

			if( $this->aUserModel['password'] != md5($this->aParams["password"]) )
			{
				$this->viewLogin->createMessage( Message::failed, "密码错误。" ) ;
				break ;
			}
            		
			// IdManager::fromSession()->clear() ;
			IdManager::fromSession()->addId($aId) ;
			
			$this->viewLogin->createMessage( Message::success, "登录成功。" ) ;
			$this->viewLogin->hideForm() ;
			
			if($this->aParams->has('from'))
			{
				Relocater::locate("/?c=".$this->aParams->get('from') , "成功",0);
			}else{
				Relocater::locate("/?c=microblog.index", "成功",0);
			}
			
		} while(0) ; }
		
	}
}

?>