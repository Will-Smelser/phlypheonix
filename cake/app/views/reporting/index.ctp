<?php 

$colmns = array('referer_id','user_id','facebook_id','email','name','session','first_time','last_time','total_time','count');

$sortDir2 = (strtolower($sortDir) == 'asc') ? 'DESC' : 'ASC';
$linkEnd = "/$sortOn/$sortDir/$filterType/$inputs";

//used for the values
$parts = explode('|',$inputs);
$from = $to = 'mm/dd/yy';
$cfrom = $cto = 0;
if(count($parts) > 1 && $filterType == 'date'){
	$from = date('m/d/y',$parts[0]);
	$to = date('m/d/y',$parts[1]);
}else if(count($parts) > 1){
	$cfrom = $parts[0];
	$cto = $parts[1];
}

?>
<h2>Filters</h2>
<form action="/<? echo $this->params['url']['url']; ?>" method="post">
	<input type="radio" name="filter" value="none" <?php echo ($filterType=='none') ? 'checked' : ''; ?> > None<br/>
	<input style="margin-top:7px;" type="radio" name="filter" value="date" <?php echo ($filterType=='date') ? 'checked' : ''; ?> > 
		Date - from<input style="width:120px;padding:1px;" name="date-from" type="text" value="<?php echo $from; ?>"> 
		to<input style="width:120px;padding:1px;" name="date-to" type="text" value="<?php echo $to; ?>"/><br/>
	<input style="margin-top:7px;" type="radio" name="filter" value="facebook" <?php echo ($filterType=='facebook') ? 'checked' : ''; ?>> 
		Facebook 
		<select name="f-equate">
			<option value="=" <?php if($inputs == '=') echo 'selected'?>>=</option>
			<option value="<>" <?php if($inputs == '<>') echo 'selected'?>>&lt; &gt;</option>
		</select>
		NULL
		<br/>
	<input style="margin-top:7px;" type="radio" name="filter" value="referer" <?php echo ($filterType=='referer') ? 'checked' : ''; ?>> 
		Referer
		<select name="r-equate">
			<option value="=" <?php if($inputs == '=') echo 'selected'?>>=</option>
			<option value="<>" <?php if($inputs == '<>') echo 'selected'?>>&lt; &gt;</option>
		</select>
		NULL
		<br/>
	<input style="margin-top:7px;"	 type="radio" name="filter" value="count"  <?php echo ($filterType=='count') ? 'checked' : ''; ?>> 
		Page Count - 
		from<input style="width:120px;padding:1px;" name="c-from" type="text" value="<?php echo $cfrom;?>"> 
		to<input style="width:120px;padding:1px;" name="c-to" type="text" value="<?php echo $cto; ?>"/><br/>
		
	<input type="submit" value="Submit" />
</form>

<h2>Basic Data</h2>
<table>
	<tr>
	<?php foreach($colmns as $c){
		$link = "<a href='/reporting/index/$page/$c/$sortDir2'>";
		$sort = ($sortOn == $c) ? "{$link}$sortDir</a>" : '';
		echo "<th><a href='/reporting/index/$page/$c'>$c</a>$sort</th>";
	}?>
	</tr>
	<?php 
	
	foreach($result as $entry){
		
		$uid = (isset($entry['trackings_base_data']['user_id'])) ? $entry['trackings_base_data2']['user_id'] : null;
		$fbid = (isset($entry['trackings_base_data']['facebook_id'])) ? $entry['trackings_base_data2']['facebook_id'] : ' - ';
		$ssid = $entry['trackings_base_data']['session'];
		$email = (isset($entry['trackings_base_data']['email'])) ? $entry['trackings_base_data2']['email'] : ' - ';
		
		$user = (!empty($uid)) ? 
			"<a href=\"/reporting/timeline/$uid/{$ssid}\">$uid</a>" : ' - ';
		
		$ssid = "<a href='/reporting/timeline/0/$ssid'>$ssid</a>";
		echo "
		<tr>
			<td>{$entry['trackings_base_data2']['referer_id']}</td>
			<td>{$user}</td>
			<td>{$fbid}</td>
			<td>{$email}</td>
			<td>{$entry['trackings_base_data2']['name']}</td>
			<td>{$ssid}</td>
			<td>{$entry['trackings_base_data']['first_time']}</td>
			<td>{$entry['trackings_base_data']['last_time']}</td>
			<td>{$entry['trackings_base_data']['total_time']}</td>
			<td>{$entry['trackings_base_data']['count']}</td>
		</tr>
		";
	}
	
	?>
</table>
<p style="text-align: center">
<a style="<?php echo ($page == 0) ? 'text-decoration:line-through' : ''?>"
	href="/reporting/index/0<?php echo $linkEnd; ?>"><< First Page</a>&nbsp;&nbsp;
<a style="<?php echo ($page == 0) ? 'text-decoration:line-through' : ''?>" 
	href="/reporting/index/<?php echo ($page == 0) ? 0 : ($page++);echo $linkEnd ?>">< Previous Page</a>&nbsp;&nbsp;

&nbsp;&nbsp;

<a style="<?php echo ($page == $pages-1) ? 'text-decoration:line-through' : ''?>" 
	href="/reporting/index/<?php echo ($page == $pages-1) ? $page : ($page+1);echo $linkEnd ?>">Next Page ></a>&nbsp;&nbsp;
<a style="<?php echo ($page == $pages-1) ? 'text-decoration:line-through' : ''?>" 
	href="/reporting/index/<?php echo ($pages-1).$linkEnd; ?>">Last Page >></a>
<?php 

?>
</p>