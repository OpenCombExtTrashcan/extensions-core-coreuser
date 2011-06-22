<?php
namespace oc\ext\coreuser ;

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
 * 用户更新
 * Enter description here ...
 * @author gaojun
 *
 */
class Update extends Controller
{
	protected function init()
	{

		$this->createView("defaultView", "Update.html",'jc\\mvc\\view\\FormView') ;

		//当前登陆者信息
        $aAssocMap = ModelAssociationMap::singleton() ;
		$aFragment = $aAssocMap->fragment('user',
		       array(
		            'info' ,
		       )
		) ;
		$model = new Model($aFragment);
        $model->load("aarongao","user_loginId");
        
		// 为视图创建、添加窗体，并为窗体添加校验器
		$this->defaultView->addWidget( new Text("user_email","邮件") )					// 普通文本窗体
					        ->dataVerifiers()
						    ->add( Email::singleton(), "用户名必须是email格式" ) ;		// 添加校验器:必须是 email 格式，并设置一段提示消息，替代框架默认的提示消息
						    
		$this->defaultView->addWidget( new Text("username","姓名") )					// 普通文本窗体
					        ->dataVerifiers()
						    ->add( Length::flyweight(6,40) ) ;		// 添加校验器:必须是 email 格式，并设置一段提示消息，替代框架默认的提示消息
						    
		$this->defaultView->addWidget( new Text("password","密码",Text::PASSWORD) )	// 密码文本窗体
					        ->dataVerifiers()
						    ->add( Length::flyweight(6,40) ) ; 						// 添加校验器:长度限制在 6-40 的范围内
		
		$radio1 = new CheckBtn('user_sex_male' , '男' ,  CheckBtn::RADIO , '1');
		$this->defaultView->addWidget ( $radio1 );
		
		$radio2 = new CheckBtn('user_sex_female' , '女' , CheckBtn::RADIO , '2');
		$this->defaultView->addWidget ( $radio2 );
		
		$group = new RadioGroup('user_sex' , 'testGroup');
		$this->defaultView->addWidget ( $group );
		$group->addWidget($radio1);
		$group->addWidget($radio2);
		$group->setChecked('user_sex_male');
		
		$this->defaultView->addWidget( new Text("user_birthday","生日") );
		
		$select = new Select ( 'user_city', '选择城市', 1 );
		$select->addOption ( null, "请选择" ,true);
		$select->addOption ( "dl", "大连");
		$select->addOption ( "yk", "营口");
		$this->defaultView->addWidget ( $select )->dataVerifiers ()->add ( NotNull::singleton (), "请选择城市" );
		
        
	}
	
	public function process()
	{
	    if( $this->defaultView->isSubmit( $this->aParams ) )		 
		{
//            $this->defaultView->widget('username')->setValue() ;
//            $this->defaultView->widget('username')->setValueFromValue() ;
		        $this->defaultView->setModel(new Model($aFragment)) ;
		        
		        $this->defaultView->dataExchanger()->link('password','user_passwd') ;
		        $this->defaultView->dataExchanger()->link('user_loginId','user_loginId') ;
		        
		        $this->defaultView->dataExchanger()->link('username','info.user_name') ;
		        $this->defaultView->dataExchanger()->link('user_email','info.user_email') ;
		        $this->defaultView->dataExchanger()->link('user_sex','info.user_sex') ;
		        $this->defaultView->dataExchanger()->link('user_birthday','info.user_birthday') ;
		        $this->defaultView->dataExchanger()->link('user_city','info.user_city') ;
		        
		        $this->defaultView->model()->setData('user_register_time',strtotime("now")) ;
        
            	// 加载 视图窗体的数据
            	$this->defaultView->loadWidgets( $this->aParams ) ;
            	
            	// 校验 视图窗体的数据
            	if( $this->defaultView->verifyWidgets() )
            	{
            		// 生成一条消息发送到 视图 的消息队列
            		// 控制器、视图，和视图窗体 都拥有自己的消息队列，它们都可以在视图的 UI模板 中分别显示出来
            		$this->defaultView->messageQueue()->add(
            			new Message( Message::success, "用户名密码输入正确，这只是一个例子，没有做什么实质性的事情 ... ..." )
            		) ;
            		
            		$this->defaultView->exchangeData(DataExchanger::WIDGET_TO_MODEL) ;
            		
            		try {
            			$this->defaultView->model()->save();
            		} catch (ExecuteException $e) {
            			
            			if($e->isDuplicate())
            			{
            				$this->defaultView->messageQueue()->add(
		            			new Message( Message::error, "用户重复" )
		            		) ;
            			}
            			else
            			{
            				throw $e ;
            			}
            			exit;
            			
            		}
            	}
            	
		}
		
        
		$this->defaultView->render() ;
	}
}

?>