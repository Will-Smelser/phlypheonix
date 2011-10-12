<?php 

/**
 * $schools
 * $userSchools
 * $sex
 * $link
 */

?>
<div id="list-schools" style="display:none">
	<ul>
	<?php 
		$ids = array(); //track the users favorite schools
		$i = 0;
		if(!empty($userSchools)){
			foreach($userSchools as $s){
				if(preg_match('/[a-z]/i',$s['name'][0])){
					$class = ($i%2 == 0) ? 'even' : 'odd';
					array_push($ids, $s['id']);
					?>
					<li class="<?php echo $class; ?> heart">
						<a href="<?php echo $link.$s['id']; ?>/<?php echo $sex; ?>" >
						
						<?php echo $s['long']; ?>	
						</a>
					</li>
					<?php 
					$i++;
				}
			}
		 	?>
		 	
	 	<?php
		}
		foreach($schools as $s) {
			if(preg_match('/[a-z]/i',$s['School']['name'][0])){
				$class = ($i%2 == 0) ? 'even' : 'odd';
				if(!in_array($s['School']['id'],$ids)){
					?>
					<li class="<?php echo $class; ?>">
						<a href="<?php echo $link.$s['School']['id']; ?>/<?php echo $sex ?>" >
						
						<?php echo $s['School']['long']; ?>	
						</a>
					</li>
					<?php 
					$i++;
				}
			}
		} 
		?>
	</ul>
</div>