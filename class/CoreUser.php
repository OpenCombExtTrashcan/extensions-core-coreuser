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
	    
    	    // 取得模型关系图的单件实例
            $aAssocMap = ModelAssociationMap::singleton() ;
    	    $aAssocMap->addOrm(
                	array(
                		'keys' => 'user' ,
                		'table' => 'user' ,
                	
                		'hasOne' => array(
                			array(
                				'prop' => 'info' ,
                				'fromk' => 'uid' ,
                				'tok' => 'uid' ,
                				'model' => 'userinfo'
                			),
                		) ,
                		'hasAndBelongsToMany' => array(
							array(
								'prop' => 'usersubscribe' ,
								'fromk' => 'uid' ,
								'tok' => 'uid' ,
								'bfromk' => 'uid' ,
								'btok' => 'subscribeid' ,	
								'bridge' => 'subscribe' ,
								'model' => 'user',
							) ,
						),
                	)
            ) ;
            
            $aAssocMap->addOrm(
            	array(
            		'keys' => 'uid' ,
            		'table' => 'userinfo' ,
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
		$this->application()->accessRouter()->addController('logout', "oc\\ext\\coreuser\\Logout") ;
		$this->application()->accessRouter()->addController('update', "oc\\ext\\coreuser\\Update") ;
		$this->application()->accessRouter()->addController('subscribe', "oc\\ext\\coreuser\\Subscribe") ;
		$this->application()->accessRouter()->addController('switch', "oc\\ext\\coreuser\\Switchuser") ;
	}
	
}

?>