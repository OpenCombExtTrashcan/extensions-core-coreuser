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
 * 用户登陆
 * Enter description here ...
 * @author gaojun
 *
 */
class Login extends Controller
{
	protected function init()
	{

		$this->createView("defaultView", "Login.html",'jc\\mvc\\view\\FormView') ;
		
		// 为视图创建、添加窗体，并为窗体添加校验器
		$this->defaultView->addWidget( new Text("username","用户名"), 'username' );
						    
		$this->defaultView->addWidget( new Text("password","密码",Text::password), 'password' )
						    ->addVerifier( Length::flyweight(6,40) ) ;
        
	}
	
	public function process()
	{
	
	    if( $this->defaultView->isSubmit( $this->aParams ) )		 
		{
			// 加载 视图窗体的数据
			$this->defaultView->loadWidgets( $this->aParams ) ;
			            	
			// 校验 视图窗体的数据
			if( $this->defaultView->verifyWidgets() )
			{
				$aAssocMap = ModelAssociationMap::singleton() ;
				
				$model = new Model( $aAssocMap->fragment('user', array('info') ));
				
				if( $model->load($this->aParams->get("username"),"username") )
				{
					echo "<pre>";print_r($model["username"]);echo "</pre>";
				}else{
					
				}

				
			}
		}
        
        
		$this->defaultView->render() ;
	}
}

?>