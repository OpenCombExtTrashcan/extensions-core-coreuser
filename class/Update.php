<?php
namespace oc\ext\coreuser ;

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
		$aIdMgr = IdManager::fromSession() ;

		$this->createView("defaultView", "Update.html",'jc\\mvc\\view\\FormView') ;

								
		//当前登陆者信息
        $aAssocMap = ModelAssociationMap::singleton() ;
		$aFragment = $aAssocMap->fragment('user',
		       array(
		            'info' ,
		       )
		) ;
		$this->defaultView->setModel( Model::fromFragment('user',array('info')) ) ;
        $this->defaultView->model()->load("1","uid");
            		
            		
		// 为视图创建、添加窗体，并为窗体添加校验器
		$this->defaultView->addWidget( new Text("password","密码",$this->defaultView->model()->password,Text::password), 'password' );
						    
		$this->defaultView->addWidget( new Text("email","邮件",$this->defaultView->model()->email), 'info.email' )
						    ->addVerifier( Email::singleton(), "用户名必须是email格式" ) ;

		$this->defaultView->addWidget ( new RadioGroup('sex'), 'info.sex')
					->createRadio('女','2')
					->createRadio('男','1')
					->createRadio('保密','0',true) ;

		$this->defaultView->addWidget( new Text("birthday","生日",$this->defaultView->model()->birthday), 'birthday' );
						
		$this->defaultView->addWidget ( new Select ( 'city', '选择城市', 1 ), 'city' )
								->addOption ( "请选择", null, true)
								->addOption ( "大连", "dl" )
								->addOption ( "营口", "yk" )
								->addVerifier( NotEmpty::singleton (), "请选择城市" ) ;
		
								
	}
	
	public function process()
	{
	    if( $this->defaultView->isSubmit( $this->aParams ) )		 
		{
//            $this->defaultView->widget('username')->setValue() ;
//            $this->defaultView->widget('username')->setValueFromValue() ;
		        $this->defaultView->setModel(Model::fromFragment('user',array('info'))) ;
		        
		        $this->defaultView->dataExchanger()->link('password','password') ;
		        
		        $this->defaultView->dataExchanger()->link('email','info.email') ;
		        $this->defaultView->dataExchanger()->link('sex','info.sex') ;
		        $this->defaultView->dataExchanger()->link('birthday','info.birthday') ;
		        $this->defaultView->dataExchanger()->link('city','info.city') ;
		        
		        $this->defaultView->model()->setData('registerTime',strtotime("now")) ;
        
            	// 加载 视图窗体的数据
            	$this->defaultView->loadWidgets( $this->aParams ) ;
            	
            	// 校验 视图窗体的数据
            	if( $this->defaultView->verifyWidgets() )
            	{
            		
            		$this->defaultView->exchangeData(DataExchanger::WIDGET_TO_MODEL) ;
            		
            		echo "<pre>";print_r($this->defaultView->model()->username);echo "</pre>";exit;
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
		
        
		$this->defaultView->render() ;
	}
}

?>