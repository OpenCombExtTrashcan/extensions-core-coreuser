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

		$this->viewRegister->addWidget ( new RadioGroup('sex',""), 'info.sex' )
					->createRadio(null,'女','2')
					->createRadio(null,'男','1',true);

		$this->viewRegister->addWidget ( new Select ( 'city', '选择城市'), 'city' )
								->addOption ( "请选择", null, true)
								->addOption ( "上海", "上海" )
								->addOption ( "北京", "北京" )
								->addOption ( "深圳", "深圳" )
								->addOption ( "广州", "广州" )
								->addOption ( "天津", "天津" )
								->addOption ( "杭州", "杭州" )
								->addOption ( "南京", "南京" )
								->addOption ( "武汉", "武汉" )
								->addOption ( "成都", "成都" )
								->addOption ( "沈阳", "沈阳" )
								->addOption ( "大连", "大连" )
								->addOption ( "长沙", "长沙" )
								->addOption ( "济南", "济南" )
								->addOption ( "青岛", "青岛" )
								->addOption ( "苏州", "苏州" )
								->addOption ( "福州", "福州" )
								->addOption ( "无锡", "无锡" )
								->addOption ( "哈尔滨", "哈尔滨" )
								->addOption ( "宁波", "宁波" )
								->addOption ( "重庆", "重庆" )
								->addOption ( "大庆", "大庆" )
								->addOption ( "厦门", "厦门" )
								->addOption ( "西安", "西安" )
								->addOption ( "长春", "长春" )
								->addOption ( "珠海", "珠海" )
								->addOption ( "郑州", "郑州" )
								->addOption ( "海口", "海口" )
								->addOption ( "昆明", "昆明" )
								->addOption ( "太原", "太原" )
								->addOption ( "石家庄", "石家庄" )
								->addOption ( "温州", "温州" )
								->addOption ( "合肥", "合肥" )
								->addOption ( "乌鲁木齐", "乌鲁木齐" )
								->addOption ( "南宁", "南宁" )
								->addOption ( "南通", "南通" )
								->addOption ( "合肥", "合肥" )
								->addOption ( "兰州", "兰州" )
								->addOption ( "呼和浩特", "呼和浩特" )
								->addOption ( "贵阳", "贵阳" )
								->addOption ( "烟台", "烟台" )
								->addOption ( "秦皇岛", "秦皇岛" )
								->addOption ( "包头", "包头" )
								->addOption ( "唐山", "唐山" )
								->addOption ( "银川", "银川" )
								->addOption ( "汕头", "汕头" )
								->addOption ( "连云港", "连云港" )
								->addOption ( "威海", "威海" )
								->addOption ( "西宁", "西宁" )
								->addOption ( "湛江", "湛江" )
								->addOption ( "北海", "北海" )
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
            		
            		$this->viewRegister->model()->setData('success',"1") ;
            			
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