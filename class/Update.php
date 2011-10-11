<?php
namespace oc\ext\coreuser ;

use jc\mvc\view\widget\Group;

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
Class Update extends Controller
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
		$this->viewUpdate->setModel( Model::fromFragment('user',array('info')) ) ;
            		
            		
		// 为视图创建、添加窗体，并为窗体添加校验器
		$this->viewUpdate->addWidget( new Text("nickname","昵称"), 'info.nickname' );
		$this->viewUpdate->addWidget( new Text("blogname","博客名"), 'info.blogname' );
		$this->viewUpdate->addWidget( new Text("truename","真实姓名"), 'info.truename' );
		$this->viewUpdate->addWidget ( new RadioGroup('identity'), 'info.identity')
    		->createRadio(null,'教师','3')
    		->createRadio(null,'家长','2')
    		->createRadio(null,'学生','1',true);
					
		$this->viewUpdate->addWidget( new Text("school","学校"), 'info.school' );
		$this->viewUpdate->addWidget ( new Select ( 'grade', '所在年级'), 'info.grade' )
    		->addOption ( "请选择", null, true)
    		->addOption ( "一年级", "1" )
    		->addOption ( "二年级", "2" )
    		->addOption ( "三年级", "3" )
    		->addOption ( "四年级", "4" )
    		->addOption ( "五年级", "5" )
    		->addOption ( "六年级", "6" )
    		->addVerifier( NotEmpty::singleton (), "请选择年级" ) ;
		$this->viewUpdate->addWidget ( new Select ( 'class', '班级名字'), 'info.class' )
    		->addOption ( "请选择", null, true)
    		->addOption ( "1班", "1" )
    		->addOption ( "2班", "2" )
    		->addOption ( "3班", "3" )
    		->addOption ( "4班", "4" )
    		->addOption ( "5班", "5" )
    		->addOption ( "6班", "6" )
    		->addOption ( "7班", "7" )
    		->addOption ( "8班", "8" )
    		->addOption ( "9班", "9" )
    		->addOption ( "10班", "10" )
    		->addOption ( "11班", "11" )
    		->addOption ( "12班", "12" )
    		->addOption ( "13班", "13" )
    		->addOption ( "14班", "14" )
    		->addOption ( "15班", "15" )
    		->addVerifier( NotEmpty::singleton (), "请选择班级" ) ;
					
		$this->viewUpdate->addWidget( new Text("entrance","入学时间"), 'info.entrance' );
		$this->viewUpdate->addWidget( new Text("parentphone","家长联系电话"), 'info.parentphone' );
					
					
		$aGroup = new Group('like');
		
		$aCheckBox1 = new CheckBtn("myinterests1","读书","1",CheckBtn::checkbox);
		$aCheckBox2 = new CheckBtn("myinterests2","运动","1",CheckBtn::checkbox);
		$aCheckBox3 = new CheckBtn("myinterests3","收藏","1",CheckBtn::checkbox);
		$aCheckBox4 = new CheckBtn("myinterests4","听音乐","1",CheckBtn::checkbox);
		$aCheckBox5 = new CheckBtn("myinterests5","计算机/互联网","1",CheckBtn::checkbox);
		$aCheckBox6 = new CheckBtn("myinterests6","购物","1",CheckBtn::checkbox);
		$aCheckBox7 = new CheckBtn("myinterests7","美食","1",CheckBtn::checkbox);
		$aCheckBox8 = new CheckBtn("myinterests8","时尚","1",CheckBtn::checkbox);
		$aCheckBox9 = new CheckBtn("myinterests9","美术","1",CheckBtn::checkbox);
		$aCheckBox10 = new CheckBtn("myinterests10","网络游戏/电脑游戏","1",CheckBtn::checkbox);
		$aCheckBox11 = new CheckBtn("myinterests11","厨艺","1",CheckBtn::checkbox);
		$aCheckBox12 = new CheckBtn("myinterests12","舞蹈","1",CheckBtn::checkbox);
		$aCheckBox13 = new CheckBtn("myinterests13","武术","1",CheckBtn::checkbox);
		$aCheckBox14 = new CheckBtn("myinterests14","园艺","1",CheckBtn::checkbox);
		$aCheckBox15 = new CheckBtn("myinterests15","汽车","1",CheckBtn::checkbox);
		$aCheckBox16 = new CheckBtn("myinterests16","志愿者活动","1",CheckBtn::checkbox);
		$aCheckBox17 = new CheckBtn("myinterests17","读报","1",CheckBtn::checkbox);
		$aCheckBox18 = new CheckBtn("myinterests18","写作","1",CheckBtn::checkbox);
		$aCheckBox19 = new CheckBtn("myinterests19","政治","1",CheckBtn::checkbox);
		$aCheckBox20 = new CheckBtn("myinterests20","戏剧","1",CheckBtn::checkbox);
		
		
		$this->viewUpdate->addWidget( $aCheckBox1 );
		$this->viewUpdate->addWidget( $aCheckBox2 );
		$this->viewUpdate->addWidget( $aCheckBox3 );
		$this->viewUpdate->addWidget( $aCheckBox4 );
		$this->viewUpdate->addWidget( $aCheckBox5 );
		$this->viewUpdate->addWidget( $aCheckBox6 );
		$this->viewUpdate->addWidget( $aCheckBox7 );
		$this->viewUpdate->addWidget( $aCheckBox8 );
		$this->viewUpdate->addWidget( $aCheckBox9 );
		$this->viewUpdate->addWidget( $aCheckBox10 );
		$this->viewUpdate->addWidget( $aCheckBox11 );
		$this->viewUpdate->addWidget( $aCheckBox12 );
		$this->viewUpdate->addWidget( $aCheckBox13 );
		$this->viewUpdate->addWidget( $aCheckBox14 );
		$this->viewUpdate->addWidget( $aCheckBox15 );
		$this->viewUpdate->addWidget( $aCheckBox16 );
		$this->viewUpdate->addWidget( $aCheckBox17 );
		$this->viewUpdate->addWidget( $aCheckBox18 );
		$this->viewUpdate->addWidget( $aCheckBox19 );
		$this->viewUpdate->addWidget( $aCheckBox20 );
		
		$aGroup->addWidget( $aCheckBox1 );
		$aGroup->addWidget( $aCheckBox2 );
		$aGroup->addWidget( $aCheckBox3 );
		$aGroup->addWidget( $aCheckBox4 );
		$aGroup->addWidget( $aCheckBox5 );
		$aGroup->addWidget( $aCheckBox6 );
		$aGroup->addWidget( $aCheckBox7 );
		$aGroup->addWidget( $aCheckBox8 );
		$aGroup->addWidget( $aCheckBox9 );
		$aGroup->addWidget( $aCheckBox10 );
		$aGroup->addWidget( $aCheckBox11 );
		$aGroup->addWidget( $aCheckBox12 );
		$aGroup->addWidget( $aCheckBox13 );
		$aGroup->addWidget( $aCheckBox14 );
		$aGroup->addWidget( $aCheckBox15 );
		$aGroup->addWidget( $aCheckBox16 );
		$aGroup->addWidget( $aCheckBox17 );
		$aGroup->addWidget( $aCheckBox18 );
		$aGroup->addWidget( $aCheckBox19 );
		$aGroup->addWidget( $aCheckBox20 );
		
		$this->viewUpdate->addWidget( $aGroup , 'info.myinterests' );
		
		
		
		$this->viewUpdate->addWidget( new Text("mypersonality","我的性格"), 'info.mypersonality' );
		$this->viewUpdate->addWidget( new Text("favoritebooks","最喜欢的书籍"), 'info.favoritebooks' );
		$this->viewUpdate->addWidget( new Text("favoritequote","最喜欢的名言"), 'info.favoritequote' );
		$this->viewUpdate->addWidget( new Text("favoritemovie","最喜欢的电影"), 'info.favoritemovie' );
					
		$this->viewUpdate->addWidget( new Text("email","邮件"), 'info.email' )
						    ->addVerifier( Email::singleton(), "用户名必须是email格式" ) ;

		$this->viewUpdate->addWidget ( new RadioGroup('sex'), 'info.sex')
					->createRadio(null,'女','2')
					->createRadio(null,'男','1',true);

		$this->viewUpdate->addWidget( new Text("birthday","生日"), 'info.birthday' );
						
		$this->viewUpdate->addWidget ( new Select ( 'city', '选择城市'), 'info.city' )
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
								
		$this->viewUpdate->addWidget( new Text("info","介绍",'',TEXT::multiple), 'info.info' );
	}
	
	public function process()
	{
	    
        $this->requireLogined();
        
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
	            			
	            			Relocater::locate("/?c=coreuser.update", "成功",3);
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