<select id="dirlist">
<?php 

/**
 * $dir The directory to recursively scan
 * $replace The directory string as you like to perform the replace
 */


function scan($dir,$replace){
	$contents = scandir($dir);
	
	foreach($contents as $file){
		if(is_dir($dir . DS . $file) && $file[0] != '.'){
			$temp = str_replace($replace, '',$dir . DS . $file . DS);
			$temp2 = str_replace(DS , '*', $temp);
			echo "<option value='$temp2'>$temp</option>";
			scan($dir . DS . $file,$replace);
		}
	}
}
scan($dir,$replace);
?>

</select>

<div id="load-content"></div>

<script language='javascript'>
var controller = '<?php echo $controller; ?>';
var action = '<?php echo $action ?>'; 

$('#dirlist').change(function(){
	$('#load-content').load('/'+controller+'/'+action+'/'+$('#dirlist').val());
});

$(document).ready(function(){
	$('#load-content').load('/'+controller+'/'+action+'/'+$('#dirlist').val());
});

</script>