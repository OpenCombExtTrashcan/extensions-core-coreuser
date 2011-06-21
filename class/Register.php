<?php
namespace oc\ext\coreuser ;

use jc\mvc\controller\Controller ;
use jc\mvc\model\db\Model;
use jc\mvc\model\db\orm\ModelAssociationMap;

use jc\verifier\Email;
use jc\verifier\Length;
use jc\mvc\view\widget\Text;
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

		$this->createView("defaultView", "Welcome.template.html",'jc\\mvc\\view\\FormView') ;
		
		// 为视图创建、添加窗体，并为窗体添加校验器
		$this->defaultView->addWidget( new Text("username","用户名") )					// 普通文本窗体
					        ->dataVerifiers()
						    ->add( Length::flyweight(6,40) ) 						// 添加校验器:长度限制在 6-40 的范围内
						    ->add( Email::singleton(), "用户名必须是email格式" ) ;		// 添加校验器:必须是 email 格式，并设置一段提示消息，替代框架默认的提示消息
						
		$this->defaultView->addWidget( new Text("password","密码",Text::PASSWORD) )	// 密码文本窗体
					        ->dataVerifiers()
						    ->add( Length::flyweight(6,40) ) ; 						// 添加校验器:长度限制在 6-40 的范围内
		    
		
        $aAssocMap = ModelAssociationMap::singleton() ;
        $aFragment = $aAssocMap->fragment('user',
            		array(
            			'info' ,
            		)
        ) ;
        $this->defaultView->setModel(new Model($aFragment)) ;
        
        $this->defaultView->dataExchanger()->link('username','info.user_name') ;
        $this->defaultView->dataExchanger()->link('password','user_passwd ') ;
	}
	
	public function process()
	{
	    if( $this->defaultView->isSubmit( $this->aParams ) )		 
		{
            
            
            
            if( $this->defaultView->isSubmit( $this->aParams ) )		 
            {
            	
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
            		
            	
                	if( !$this->defaultView->model()->save() )
                    {
                    	echo "无法保存模型." ;
                    	exit() ;
                    }
            	}
            	
            }
		}
        
        
		$this->defaultView->render() ;
	}
}

?>