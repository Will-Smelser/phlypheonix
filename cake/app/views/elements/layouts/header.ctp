	<a href="/shop/main">
	<img id="logoFlyFoenix" src="/img/logos/logo_flyfoenix.png" alt="FlyFoenix.com - Best NCAA gear!" />
	</a>
    <span id="caption" class="four"></span>
    <div id="navigate">
    <?php if($loggedin){ ?>
    <span class="five">Welcome &nbsp; <?php echo $myuser['User']['email']; ?></span>
    <span class="five"><a class="nav" href="/users/logout">Log Out</a></span>
    <span class="five"><a class="nav" href="/users/accountinfo">Account Info</a></span>
    <?php } else { ?>
    <span class="five"><a class="nav" href="/users/landing">Login</a></span>
    <?php } ?>
    <span class="five"><a class="nav" href="/users/contactus">Contact</a></span>
    </div>