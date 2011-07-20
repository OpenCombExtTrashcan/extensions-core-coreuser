<?php
namespace oc\ext\coreuser ;

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
 * 用户注册
 * Enter description here ...
 * @author gaojun
 *
 */
class Register extends Controller
{
	protected function init()
	{
		
		
		
		$this->createFormView() ;
		
		
		// 为视图创建、添加窗体，并为窗体添加校验器
		$this->viewRegister->addWidget( new Text("username","用户名"), 'username' );

		$this->viewRegister->addWidget( new Text("password","密码",Text::password), 'password' )
						    ->addVerifier( Length::flyweight(array(6,40)) ) ;

		$this->viewRegister->addWidget( new Text("email","邮件"), 'info.email' )
						    ->addVerifier( Email::singleton(), "用户名必须是email格式" ) ;

		$this->viewRegister->addWidget( new Text("username","姓名"), 'info.nickname' )
						    ->addVerifier( Length::flyweight(array(6,40)) ) ;

		$this->viewRegister->addWidget ( new RadioGroup('sex'), 'info.sex' )
					->createRadio('女','2')
					->createRadio('男','1')
					->createRadio('保密','0',true) ;

		$this->viewRegister->addWidget( new Text("birthday","生日"), 'birthday' );
						
		$this->viewRegister->addWidget ( new Select ( 'city', '选择城市'), 'city' )
								->addOption ( "请选择", null, true)
								->addOption ( "大连", "dl" )
								->addOption ( "营口", "yk" )
						->addVerifier( NotEmpty::singleton (), "请选择城市" ) ;

        $this->viewRegister->setModel( Model::fromFragment('user',array('info')) ) ;
	}
	
	public function process()
	{
	    if( $this->viewRegister->isSubmit( $this->aParams ) )		 
		{
            // 加载 视图窗体的数据
            $this->viewRegister->loadWidgets( $this->aParams ) ;
            
            // 校验 视图窗体的数据
            if( $this->viewRegister->verifyWidgets() )
            {
            	$this->viewRegister->exchangeData(DataExchanger::WIDGET_TO_MODEL) ;
            		
            	// 注册时间
            	$this->viewRegister->model()->setData('registerTime',time()) ;
            		
            	try {
            		$this->viewRegister->model()->save() ;
            		$this->viewRegister->createMessage( Message::success, "注册成功！" ) ;
            		
            		$this->viewRegister->hideForm() ;
            			
            	} catch (ExecuteException $e) {
            			
            		if($e->isDuplicate())
            		{
            			$this->viewRegister->createMessage(
            					Message::error
            					, "用户名：%s 已经存在"
            					, $this->viewRegister->model()->data('username')
            			) ;
            		}
            		else
            		{
            			throw $e ;
            		}
            	}
           	}
		}
	}
}

?>