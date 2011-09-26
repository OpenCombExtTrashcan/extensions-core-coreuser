<?php
namespace oc\ext\coreuser;

use jc\mvc\model\IModel;
use jc\mvc\view\IView;
use jc\mvc\view\widget\Widget;
use jc\lang\Exception;

class FaceWidget extends Widget {
	
	public function __construct($sId, $sTitle = null, IModel $aModel , IView $aView = null) {
		
		$this->setModel($aModel);
		
		parent::__construct ( $sId, 'coreuser:FaceWidget.html', $sTitle, $aView );
	}
	
	/**
	 * @return IModel 
	 */
	public function model()
	{
		return $this->aModel;
	}
	
	/**
	 * 
	 * @param IModel $aModel 
	 */
	public function setModel(IModel $aModel)
	{
		$this->aModel = $aModel;
	}
	
	/**
	 * 取得头像地址
	 * @throws Exception 如果模型中没有需要的列
	 */
	public function face()
	{
		//检查需要的列是否存在,目前支持头像地址(face), 以后支持更多
		if(!$this->aModel->hasData('info.face'))
		{
			$sFaceUrl = '/platform/ui/images/viewimg/xshd01.jpg';
		}else
		{
			$sFaceUrl = CoreUser::getFaceFolder()->path() . '/' . $this->aModel->data('info.face');
		}
		return $sFaceUrl;
	}
	
	/**
	 * 数据来源
	 * @var IModel 
	 */
	private $aModel;
}

?>