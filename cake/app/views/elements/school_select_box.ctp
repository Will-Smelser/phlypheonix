<?php
	/**
	 * $schools
	 * $selected
	 */
	//debug($schools);
	foreach($schools as $entry) {
		$select = ($entry['School']['id'] == $selected) ? 'selected' : '';
		if(!preg_match('/swatch/i',$entry['School']['long']) && preg_match('/[a-z]+/i',$entry['School']['name'])){
        	echo "\t\t\t<option value='{$entry['School']['id']}' $select>{$entry['School']['long']}</option>\n";
		}
	}
?>