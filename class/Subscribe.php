<?php
namespace oc\ext\coreuser ;

use oc\base\FrontFrame;

use jc\db\ExecuteException;
use jc\mvc\controller\Controller ;
use jc\mvc\model\db\Model;
use jc\mvc\model\db\orm\ModelAssociationMap;
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
 * 用户订阅
 * Enter description here ...
 * @author gaojun
 *
 */
class Subscribe extends Controller
{
	protected function init()
	{
		// 网页框架
		$this->add(new FrontFrame()) ;
		
		$this->createView("defaultView", "CoreUser.Subscribe.html",true) ;
	}
	
	public function process()
	{
        $this->defaultView->setModel( Model::fromFragment('user',array("usersubscribe")) ) ;
        
        if( $this->defaultView->model()->load("1") )
        {
            //$this->defaultView->model()->setData('uid',1) ;
	        //$this->defaultView->model()->child('usersubscribe')->createChild()->setData('uid',2) ;
	        
        	if( !$this->defaultView->model()->child('usersubscribe')->findChildBy("30",'username') )
        	{
		        $this->defaultView->model()->child('usersubscribe')->loadChild("5",'username') ;
				$this->defaultView->model()->save() ;
        	} 
        }
	}
}

?>