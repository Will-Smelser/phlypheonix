<table>
	<tr><th>Session</th><th>Referer Id</th><th>User Id</th><th>School</th><th>Url</th><th>date</th><th>time</th><th>Cart</th></tr>
<?php 

foreach($data as $entry){
	$r = $entry['trackings'];
	$unix = strtotime($r['created']);
	$date = date('m/d/Y',$unix);
	$time = date('g:i:s a',$unix);
	
	$link = "<a href='/{$r['url']}' target='_blank'>{$r['url']}</a>";
	
	$userid = (!empty($r['user_id'])) ? $r['user_id'] : ' - ';
	$refer = (!empty($r['referer_id'])) ? $r['referer_id'] : ' - ';
	
	echo "<tr>
			<td>{$r['session']}</td>
			<td>{$refer}</td>
			<td>{$userid}</td>
			<td>{$r['school']}</td>
			<td>$link</td>
			<td>$date</td>
			<td>$time</td>
			<td>{$r['cart']}</td>
	</tr>
	";
}

?>

</table>