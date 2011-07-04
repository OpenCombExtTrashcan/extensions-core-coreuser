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
                		'keys' => 'uid' ,
                		'table' => 'user' ,
                	
                		'hasOne' => array(
                			array(
                				'prop' => 'info' ,
                				'fromk' => 'uid' ,
                				'tok' => 'uid' ,
                				'model' => 'userinfo'
                			),
                			array(
                				'prop' => 'info2' ,
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
								'bfromk' => 'subscribeid' ,
								'btok' => 'uid' ,	
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
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Register",'register','') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Login",'login','') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Logout",'logout','') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Update",'update') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Subscribe",'subscribe') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Subscribe",'addsubscribe') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Switchuser",'switch') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\AllUser",'alluser') ;
		
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\MessageAndQueuePrototype",'all_message_types') ;
	}
	
}

?>