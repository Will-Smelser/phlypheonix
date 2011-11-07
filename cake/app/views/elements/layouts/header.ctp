	<a id="logoFlyFoenix" href="/shop/main" style="cursor:pointer">
	<img src="/img/logos/logo_flyfoenix.png" alt="FlyFoenix.com - Best NCAA gear!" />
	</a>
    
    <p id="phone-number">(614) 859-0481</p>
    
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
	    		
	    		<li style='height:45px;cursor:auto;padding-left:20px'><i style='font-size:10px;'>Logged in as</i><br/><?php echo $myuser['User']['email']; ?></li>
	    		
	    		<li class="seperate"><hr/></li>
	    		
	    		<li><a href="/users/logout">Logout</a></li>
	    		<li><a href="/users/accountinfo">Account Info</a></li>
	    		
	    		<?php } else { ?>
	    		
	    		<li><a href="/users/landing">Login</a></li>
	    		
	    		
	    		<?php } ?>
	    		<li class="seperate"><hr/></li>
	    		<li><a href="/pages/about">About Us</a></li>
	    		<li><a href="/pages/privacy">Privacy</a></li>
	    		<li><a href="/pages/return">Return Policy</a></li>
	    		<li><a href="/pages/shipping">Shipping Policy</a></li>
	    		<li><a href="/pages/about">Terms &amp; Conditions</a></li>
	    	</ul>
	    </ul>
    </div>