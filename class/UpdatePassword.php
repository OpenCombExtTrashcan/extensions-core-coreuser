<?php
namespace oc\ext\coreuser ;

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

/**
 * 用户更新
 * Enter description here ...
 * @author gaojun
 *
 */
Class UpdatePassword extends Controller
{
	protected function init()
	{
		
		$aIdMgr = IdManager::fromSession() ;

		$this->createFormView() ;

								
		//当前登录者信息
        $aAssocMap = PrototypeAssociationMap::singleton() ;
		$aFragment = $aAssocMap->fragment('user',
		       array(
		            'info' ,
		       )
		) ;
		$this->viewUpdatePassword->setModel( Model::fromFragment('user',array('info')) ) ;
            		
            		
		// 为视图创建、添加窗体，并为窗体添加校验器
		$this->viewUpdatePassword->addWidget( new Text("password","密码","",Text::password), 'password' );
						    
	}
	
	public function process()
	{
		$userList = IdManager::fromSession();
        $this->viewUpdatePassword->model()->load($userList->currentId()->userId(),"uid");
        
        $this->viewUpdatePassword->exchangeData(DataExchanger::MODEL_TO_WIDGET) ;
        
        
        
	    if( $this->viewUpdatePassword->isSubmit( $this->aParams ) )		 
		{
//            $this->viewUpdatePassword->widget('username')->setValue() ;
//            $this->viewUpdatePassword->widget('username')->setValueFromValue() ;
		        
		        $this->viewUpdatePassword->model()->setData('registerTime',strtotime("now")) ;
        
            	// 加载 视图窗体的数据
            	$this->viewUpdatePassword->loadWidgets( $this->aParams ) ;
            	
            	// 校验 视图窗体的数据
            	if( $this->viewUpdatePassword->verifyWidgets() )
            	{
            		
            		$this->viewUpdatePassword->exchangeData(DataExchanger::WIDGET_TO_MODEL) ;
            	    $this->viewUpdatePassword->model()->setData('password',md5($this->aParams->get("password"))) ;
            		if($this->viewUpdatePassword->model()->uid)
            		{
	            		try {
	            			$this->viewUpdatePassword->model()->save();
	            			
	            			Relocater::locate("/?c=coreuser.updatePassword", "成功",3);
	            		} catch (ExecuteException $e) {
	            			
	            			if($e->isDuplicate())
	            			{
	            				$this->viewUpdatePassword->messageQueue()->add(
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