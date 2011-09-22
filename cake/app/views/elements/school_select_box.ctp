<?php
	/**
	 * $schools
	 */
	//debug($schools);
	foreach($schools as $entry) {
		if(!preg_match('/swatch/i',$entry['School']['long']) && preg_match('/[a-z]+/i',$entry['School']['name'])){
        	echo "\t\t\t<option value='{$entry['School']['id']}' >{$entry['School']['long']}</option>\n";
		}
	}
?>