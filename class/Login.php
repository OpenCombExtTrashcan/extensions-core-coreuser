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
		$this->defaultView->addWidget( new Text("user_loginId","用户名") );
						    
		$this->defaultView->addWidget( new Text("password","密码",Text::PASSWORD) )	// 密码文本窗体
					        ->dataVerifiers()
						    ->add( Length::flyweight(6,40) ) ; 						// 添加校验器:长度限制在 6-40 的范围内
		
        
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
			        $aFragment = $aAssocMap->fragment('user',
			            		array(
			            			'info' ,
			            		)
			        ) ;
        			$model = new Model($aFragment);
            		$model->load($this->aParams->get("user_loginId"),"user_loginId");
            		
            		if($model["user_passwd"] == $this->aParams->get("password"))
            		{
            			echo "正确";
            		}else{
            			echo "不正确";
            		}
            	}
		}
        
        
		$this->defaultView->render() ;
	}
}

?>