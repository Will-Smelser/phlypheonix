<?php 

/**
 * $schools
 */

?>
<div id="list-schools" style="display:none">
	<ul>
	<?php $i = 0; ?>
	<?php foreach($schools as $s) {
		if(preg_match('/[a-z]/i',$s['School']['name'][0])){
		    $class = ($i%2 == 0) ? 'even' : 'odd'; ?>
			<li class="<?php echo $class; ?>"><a href="/users/add_school/<?php echo $s['School']['id']; ?>" onclick="javascript:return false;" >
				<?php echo $s['School']['long']; ?>	
				</a>
			</li>
	<?php 
			$i++;
		}
	}
	?>
	</ul>
</div>