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
class Update extends Controller
{
	protected function init()
	{
		
		$aIdMgr = IdManager::fromSession() ;

		$this->createFormView() ;

								
		//当前登陆者信息
        $aAssocMap = PrototypeAssociationMap::singleton() ;
		$aFragment = $aAssocMap->fragment('user',
		       array(
		            'info' ,
		       )
		) ;
		$this->viewUpdate->setModel( Model::fromFragment('user',array('info')) ) ;
            		
            		
		// 为视图创建、添加窗体，并为窗体添加校验器
		$this->viewUpdate->addWidget( new Text("password","密码","",Text::password), 'password' );
						    
		$this->viewUpdate->addWidget( new Text("email","邮件"), 'info.email' )
						    ->addVerifier( Email::singleton(), "用户名必须是email格式" ) ;

		$this->viewUpdate->addWidget ( new RadioGroup('sex'), 'info.sex')
					->createRadio('女','2')
					->createRadio('男','1',true);

		$this->viewUpdate->addWidget( new Text("birthday","生日"), 'info.birthday' );
						
		$this->viewUpdate->addWidget ( new Select ( 'city', '选择城市'), 'info.city' )
								->addOption ( "请选择", null, true)
								->addOption ( "大连", "dl" )
								->addOption ( "营口", "yk" )
								->addVerifier( NotEmpty::singleton (), "请选择城市" ) ;
								
	}
	
	public function process()
	{
		$userList = IdManager::fromSession();
        $this->viewUpdate->model()->load($userList->currentId()->userId(),"uid");
        
        $this->viewUpdate->exchangeData(DataExchanger::MODEL_TO_WIDGET) ;
        
        
        
	    if( $this->viewUpdate->isSubmit( $this->aParams ) )		 
		{
//            $this->viewUpdate->widget('username')->setValue() ;
//            $this->viewUpdate->widget('username')->setValueFromValue() ;
		        
		        $this->viewUpdate->model()->setData('registerTime',strtotime("now")) ;
        
            	// 加载 视图窗体的数据
            	$this->viewUpdate->loadWidgets( $this->aParams ) ;
            	
            	// 校验 视图窗体的数据
            	if( $this->viewUpdate->verifyWidgets() )
            	{
            		
            		$this->viewUpdate->exchangeData(DataExchanger::WIDGET_TO_MODEL) ;
            		if($this->viewUpdate->model()->uid)
            		{
	            		try {
	            			$this->viewUpdate->model()->save();
	            		} catch (ExecuteException $e) {
	            			
	            			if($e->isDuplicate())
	            			{
	            				$this->viewUpdate->messageQueue()->add(
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