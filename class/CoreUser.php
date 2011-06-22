<?php
namespace oc\ext\coreuser ;

use jc\mvc\model\db\orm\ModelAssociationMap;

use jc\db\DB ;
use jc\db\PDODriver ;

use oc\ext\Extension;

class CoreUser extends Extension
{
	public function load()
	{
	    
	    // 数据库设定
        DB::singleton()->setDriver( new PDODriver("mysql:host=192.168.1.1;dbname=oc",'root','1') ) ;
        
    	    // 取得模型关系图的单件实例
            $aAssocMap = ModelAssociationMap::singleton() ;
    	    $aAssocMap->addOrm(
                	array(
                		'name' => 'user' ,
                		'table' => 'users' ,
                	
                		'hasOne' => array(
                			array(
                				'prop' => 'info' ,
                				'fromk' => 'uid' ,
                				'tok' => 'uid' ,
                				'model' => 'userinfo'
                			),
                		) ,
                	)
            ) ;
            
            $aAssocMap->addOrm(
            	array(
            		'name' => 'userinfo' ,
            		'keys' => 'uid' ,
            		'table' => 'userinfos' ,
            		'belongsTo' => array(
            			array(
            				'prop' => 'user' ,
            				'fromk' => 'uid' ,
            				'tok' => 'uid' ,
            				'model' => 'user'
            			),
            		),
            	)
            );
		
		
		///////////////////////////////////////
		// 向系统添加控制器
		$this->application()->accessRouter()->addController('register', "oc\\ext\\coreuser\\Register") ;
		$this->application()->accessRouter()->addController('login', "oc\\ext\\coreuser\\Login") ;
		$this->application()->accessRouter()->addController('edit', "oc\\ext\\coreuser\\Edit") ;
	}
	
}

?>