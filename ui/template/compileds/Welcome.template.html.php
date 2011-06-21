
<?php 
$__ui_msgqueue = eval("if(!isset(\$__uivar_theView)){ \$__uivar_theView=&\$aVariables->getRef('theView') ;};
return \$__uivar_theView;") ;
if( $__ui_msgqueue instanceof \jc\message\IMessageQueueHolder )
{ $__ui_msgqueue = $__ui_msgqueue->messageQueue() ; }
\jc\lang\Assert::type( '\\jc\\message\\IMessageQueue',$__ui_msgqueue);
if( $__ui_msgqueue->count() ){ 
$this->display('MsgQueue.template.html',array('aMsgQueue'=>$__ui_msgqueue),$aDevice) ;
} ?>



<form action="/?c=register" method="post">
	<div>
		
		<?php $_aWidget = $aVariables->get('theView')->widget("username") ;
if($_aWidget){
	$_aWidget->display($this,null,$aDevice) ;
}else{
	echo '缺少 widget (id:'."username".')' ;
} ?>

		
		
		<?php 
$__ui_msgqueue = eval("if(!isset(\$__uivar_theView)){ \$__uivar_theView=&\$aVariables->getRef('theView') ;};
return \$__uivar_theView->widget('username');") ;
if( $__ui_msgqueue instanceof \jc\message\IMessageQueueHolder )
{ $__ui_msgqueue = $__ui_msgqueue->messageQueue() ; }
\jc\lang\Assert::type( '\\jc\\message\\IMessageQueue',$__ui_msgqueue);
if( $__ui_msgqueue->count() ){ 
$this->display('MsgQueue.template.html',array('aMsgQueue'=>$__ui_msgqueue),$aDevice) ;
} ?>

	</div>
	
	<div>
		
		<?php $_aWidget = $aVariables->get('theView')->widget("password") ;
if($_aWidget){
	$_aWidget->display($this,null,$aDevice) ;
}else{
	echo '缺少 widget (id:'."password".')' ;
} ?>


		
		<?php 
$__ui_msgqueue = eval("if(!isset(\$__uivar_theView)){ \$__uivar_theView=&\$aVariables->getRef('theView') ;};
return \$__uivar_theView->widget('password');") ;
if( $__ui_msgqueue instanceof \jc\message\IMessageQueueHolder )
{ $__ui_msgqueue = $__ui_msgqueue->messageQueue() ; }
\jc\lang\Assert::type( '\\jc\\message\\IMessageQueue',$__ui_msgqueue);
if( $__ui_msgqueue->count() ){ 
$this->display('MsgQueue.template.html',array('aMsgQueue'=>$__ui_msgqueue),$aDevice) ;
} ?>

	</div>
	
	<input type="submit" value="submit" />
	
<input type="hidden" name="<?php echo $aVariables->get('theView')->htmlFormSignature()?>" value="1" /></form>