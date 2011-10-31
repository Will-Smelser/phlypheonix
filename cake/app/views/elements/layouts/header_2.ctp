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
	   
	    <ul class="nav-link" id="h-cart">
	    	<li>
	    		<span id="h-cart-img">
	    			<img src="/img/icons/cart.png" />
	    		</span>
	    		<span style="padding-left:0px;">Cart</span>
	    	</li>
	    </ul>
	    
	   <form method="post" action="/shop/main">
	   <ul class="nav-link" id="h-search-go">
	   	<li>
	   		<input id="h-go-btn" class="btn" type="submit" value="Go" />
	   	</li>
	   </ul>
	   
	   	<ul class="nav-link" id="h-sex" style="margin-right:0px;">
	    	<li>
	    		<span id="h-sex-icon" style="padding-right:5px;">
	    			&nbsp;
	    			<img src="/img/icons/male.png" />
	    		</span>
	    		<span class="down-arrow">
	    			<img src="/img/icons/down_arrow.png" />
	    		</span>
	    	</li>
	    	<ul class="n-offset-left">
		    	<li style="padding-left:0px;">
		    		<label for="n-male">
			    	<input id="n-male" type="radio" name="sex" value="M" />
			    	<p>
			    		<img src="/img/icons/male.png" />
			    		&nbsp;Male
		    		</p>
		    		</label>
		    	</li>
		    	<li style="padding-left:0px;">
		    		<label for="n-female">
			    	<input id="n-female" type="radio" name="sex" value="F" />
			    	<p>
			    		<img src="/img/icons/female.png" />
			    		&nbsp;Female
		    		</p>
		    		</label>
		    	</li>
		    </ul>
	    </ul>
	   
	   
	    <ul class="nav-link" id="h-search" style="margin-right:0px;">
	    	<li><span style="padding-right:5px;">Select School</span>
	    		<span  class="down-arrow">
	    		<img src="/img/icons/down_arrow.png" />
	    		</span>
	    	</li>
	    	<ul class="n-offset-left">
		    	<li>
		    		<label for="school-1">
		    		<input name="school-id" id="school-1" type="radio" value="1" />
		    		<p>Ohio State University</p>
		    		</label>
		    		<p>
			    		<img src="/img/icons/male.png" />
		    		</p>
		    		<p>
			    		<img src="/img/icons/female.png" />
		    		</p>
		    	</li>
		    	<li>
		    		<label for="school-2">
		    		<input name="school-id" id="school-2" type="radio" value="2" />
		    		<p>Ohio University</p>
		    		</label>
		    		<p>
			    		<img src="/img/icons/male.png" />
		    		</p>
		    		<p>
			    		<img src="/img/icons/female.png" />
		    		</p>
		    	</li>
		    </ul>
	    </ul>
	    </form>
    </div>