<?php
namespace oc\ext\coreuser ;

use oc\base\FrontFrame;

use jc\verifier\NotEmpty;

use jc\auth\IdManager;

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
		// 网页框架
		$this->add(new FrontFrame()) ;
		
		
		$aIdMgr = IdManager::fromSession() ;

		$this->createView("defaultView", "CoreUser.Update.html",'jc\\mvc\\view\\FormView') ;

								
		//当前登陆者信息
        $aAssocMap = ModelAssociationMap::singleton() ;
		$aFragment = $aAssocMap->fragment('user',
		       array(
		            'info' ,
		       )
		) ;
		$this->defaultView->setModel( Model::fromFragment('user',array('info')) ) ;
            		
            		
		// 为视图创建、添加窗体，并为窗体添加校验器
		$this->defaultView->addWidget( new Text("password","密码","",Text::password), 'password' );
						    
		$this->defaultView->addWidget( new Text("email","邮件"), 'info.email' )
						    ->addVerifier( Email::singleton(), "用户名必须是email格式" ) ;

		$this->defaultView->addWidget ( new RadioGroup('sex'), 'info.sex')
					->createRadio('女','2')
					->createRadio('男','1',true);

		$this->defaultView->addWidget( new Text("birthday","生日"), 'info.birthday' );
						
		$this->defaultView->addWidget ( new Select ( 'city', '选择城市', 1 ), 'info.city' )
								->addOption ( "请选择", null, true)
								->addOption ( "大连", "dl" )
								->addOption ( "营口", "yk" )
								->addVerifier( NotEmpty::singleton (), "请选择城市" ) ;
								
	}
	
	public function process()
	{
		$userList = IdManager::fromSession();
        $this->defaultView->model()->load($userList->currentId()->userId(),"uid");
        
        $this->defaultView->exchangeData(DataExchanger::MODEL_TO_WIDGET) ;
        
        
        
	    if( $this->defaultView->isSubmit( $this->aParams ) )		 
		{
//            $this->defaultView->widget('username')->setValue() ;
//            $this->defaultView->widget('username')->setValueFromValue() ;
		        
		        $this->defaultView->model()->setData('registerTime',strtotime("now")) ;
        
            	// 加载 视图窗体的数据
            	$this->defaultView->loadWidgets( $this->aParams ) ;
            	
            	// 校验 视图窗体的数据
            	if( $this->defaultView->verifyWidgets() )
            	{
            		
            		$this->defaultView->exchangeData(DataExchanger::WIDGET_TO_MODEL) ;
            		if($this->defaultView->model()->uid)
            		{
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
            	
		}
		
	}
}

?>