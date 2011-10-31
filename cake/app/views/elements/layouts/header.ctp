	<a href="/shop/main">
	<img id="logoFlyFoenix" src="/img/logos/logo_flyfoenix.png" alt="FlyFoenix.com - Best NCAA gear!" />
	</a>
    
    <div id="navigate">
	    <ul class="nav-link" id="h-links">
	    
	    	<li>
	    		<span style="padding-right:0px;">Links</span>
	    		<span class="down-arrow">
	    			<img src="/img/icons/down_arrow.png" />
	    		</span>
	    	</li>
	    	<ul>
	    		<?php if($loggedin){ ?>
	    		
	    		<li style='height:45px;cursor:auto;'><p><i style='font-size:10px;'>Logged in as</i><br/><?php echo $myuser['User']['email']; ?></p></li>
	    		
	    		<li class="seperate"><hr/></li>
	    		
	    		<li><p><a href="/users/logout">Logout</a></p></li>
	    		<li><p><a href="/users/accountinfo">Account Info</a></p></li>
	    		
	    		<?php } else { ?>
	    		
	    		<li><p><a href="/users/landing">Login</a></p></li>
	    		
	    		
	    		<?php } ?>
	    		<li class="seperate"><hr/></li>
	    		<li><p><a href="/pages/about">About Us</a></p></li>
	    		<li><p><a href="/pages/privacy">Privacy</a></p></li>
	    		<li><p><a href="/pages/return">Return Policy</a></p></li>
	    		<li><p><a href="/pages/shipping">Shipping Policy</a></p></li>
	    		<li><p><a href="/pages/about">Terms &amp; Conditions</a></p></li>
	    	</ul>
	    </ul>
    </div>