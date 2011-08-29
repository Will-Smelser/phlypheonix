<?php 

/**
 * $title The tile
 * $dir The absolute path to directory with images
 * $model The model name
 * $field The model field name
 */


echo "<div class='input text'>$title</div>\n";

echo "\n<select name='data[$model][$field]' >";

foreach(scandir($dir) as $file){
	if($file[0] != '.'){
		$rel = str_replace(WWW_ROOT,'',$dir  . $file);
		$rel = '/' . str_replace(DS, '/', $rel);
			
		echo "\n\t<option value='$rel'";
		if($rel == $this->data[$model][$field]) { echo ' selected="selected" '; }
		echo ">$file</option>";
	}
}

echo "\n</select>";

?>