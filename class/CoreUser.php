<?php
namespace oc\ext\coreuser ;

use jc\mvc\model\db\orm\ModelAssociationMap;

use oc\ext\Extension;

class CoreUser extends Extension
{
	public function load()
	{
		///////////////////////////////////////
		// 向系统的模型关系图中添加 数据表配置
		$aModelAssocMap = ModelAssociationMap::singleton() ;
		
		// user 表
		// $aModelAssocMap->addOrm() ;
		
		
		///////////////////////////////////////
		// 向系统添加控制器
		// $this->application()->accessRouter()->addController('xxxx', "full class name") ;
	}
	
}

?>