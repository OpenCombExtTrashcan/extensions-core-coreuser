<?php
namespace oc\ext\coreuser ;

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
 * 用户登陆
 * Enter description here ...
 * @author gaojun
 *
 */
class Login extends Controller
{
	protected function init()
	{
		// 网页框架
		$this->add(new FrontFrame()) ;

		$this->createView("defaultView", "CoreUser.Login.html",'jc\\mvc\\view\\FormView') ;
		
		// 为视图创建、添加窗体，并为窗体添加校验器
		$this->defaultView->addWidget( new Text("username","用户名",'aarongao'), 'username' );
						    
		$this->defaultView->addWidget( new Text("password","密码",'6609889',Text::password), 'password' )
						    ->addVerifier( Length::flyweight(array(6,40)) ) ;
        
						    
		$this->aUserModel = Model::fromFragment('user', array('info')) ;
		
	}
	
	public function process()
	{
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
		//登陆
	    if( $this->defaultView->isSubmit( $this->aParams ) )		 
		{do{
			// 加载 视图窗体的数据
			$this->defaultView->loadWidgets( $this->aParams ) ;
			            	
			// 校验 视图窗体的数据
			if( !$this->defaultView->verifyWidgets() )
			{
				break ;
			}
				
			if( !$this->aUserModel->load($this->aParams["username"],"username") )
			{
				$this->defaultView->createMessage( Message::failed, "用户名不存在:%s。", $this->aParams["username"] ) ;
				break ;
			}

			if( $this->aUserModel['password'] != $this->aParams["password"] )
			{
				$this->defaultView->createMessage( Message::failed, "密码错误。" ) ;
				break ;
			}
            		
			// IdManager::fromSession()->clear() ;
			IdManager::fromSession()->addId($aId) ;
			
			$this->defaultView->createMessage( Message::success, "登录成功。" ) ;
			$this->defaultView->hideForm() ;
			
		} while(0) ; }

	}
}

?>