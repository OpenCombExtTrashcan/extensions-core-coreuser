<?php
namespace oc\ext\coreuser ;

use oc\base\FrontFrame;
use jc\session\Session;
use jc\auth\IdManager;
use jc\auth\Id;
use jc\db\ExecuteException;
use jc\mvc\controller\Controller ;
use jc\mvc\model\db\Model;
use jc\mvc\model\db\orm\ModelAssociationMap;
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

		$this->createView("defaultView", "Login.html",'jc\\mvc\\view\\FormView') ;
		
		// 为视图创建、添加窗体，并为窗体添加校验器
		$this->defaultView->addWidget( new Text("username","用户名",'aarongao'), 'username' );
						    
		$this->defaultView->addWidget( new Text("password","密码",'6609889',Text::password), 'password' )
						    ->addVerifier( Length::flyweight(6,40) ) ;
        
						    
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
			
		/**
		//  不能在 controller/model 以及view以外的任何地方 向浏览器输出任何内容 
		//  随着框架的完善，直接使用echo输出的内容会被丢弃。以下代码需要转移到视图中
		//
		echo "当前登陆用户：<a href=\"?c=register\">注册</a> <a href=\"?c=update\">修改</a> <a href=\"?c=logout\">退出</a><br/>";
		$userList = IdManager::fromSession();
		foreach($userList->iterator() as $u){
			echo $u->username()."<a href=\"?c=switch&uid=".$u->userId()."\">切换</a><br/>";
		}
		*/
		
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