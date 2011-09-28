<?php
namespace oc\ext\coreuser ;

use jc\mvc\model\db\orm\PrototypeAssociationMap;

use jc\db\DB ;
use jc\db\PDODriver ;
use jc\fs\FileSystem;
use oc\ext\Extension;

class CoreUser extends Extension
{
	public function load()
	{
		// 定义ORM
        $this->defineOrm(PrototypeAssociationMap::singleton()) ;
            
		///////////////////////////////////////
		// 向系统添加控制器
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Register",'register','') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Login",'login','') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Logout",'logout','') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Update",'update') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\subscribe\\Index",'subscribe.index') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\subscribe\\Create",'subscribe.create') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\subscribe\\Remove",'subscribe.remove') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Switchuser",'switch') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\AllUser",'alluser') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\MyFriend",'myfriend','') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\Face",'coreuser.face','') ;
		$this->application()->accessRouter()->addController("oc\\ext\\coreuser\\MessageAndQueuePrototype",'all_message_types') ;
		
		$this->application()->accessRouter()->setDefaultController('myfriend') ;
	}
	
	static public function getFaceFolder()
	{
		if(!$updateFolder = Extension::retraceExtension()->metainfo()->publicDataFolder()->findFolder('face'))
		{
			$updateFolder = Extension::retraceExtension()->metainfo()->publicDataFolder()->createFolder('face' , FileSystem::CREATE_ONLY_OBJECT);
		}
		return $updateFolder;
	}
	
	
	public function defineOrm(PrototypeAssociationMap $aAssocMap)
	{
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
								'btok' => 'uid' ,
								'bfromk' => 'subscribeid' ,
								'tok' => 'uid' ,	
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
            
            $aAssocMap->addOrm(
            	array(
            		'keys' => array("uid","subscribeid") ,
            		'table' => 'subscribe' ,
            		'hasOne' => array(
            			array(
            				'prop' => 'user' ,
            				'fromk' => 'subscribeid' ,
            				'tok' => 'uid' ,
            				'model' => 'user'
            			),
            		),
            	)
            );
	}
}

?>