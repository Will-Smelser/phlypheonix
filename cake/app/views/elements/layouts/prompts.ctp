<?php 

	$pdeletes = array();

	//key = prompts id
	//val = the prompt name
	foreach($cprompts as $key=>$p){
		$data = (isset($cpdata[$key])) ? $cpdata[$key] : array();
		//run the prompt
		echo $this->element('prompts/'.$p,
			array(
				'id'=>$key,
				'data'=>$data
			)
		);
		
		//delete the prompt
		array_push($pdeletes,"\n\t$.post('/prompts/deleteUserPrompt/$key');\n");
	}
?>

//delete prompts
$(document).ready(function(){

	<?php foreach($pdeletes as $str) {echo $str; }?>
	
});