	
	<img id="logoFlyFoenix" src="/img/logos/logo_flyfoenix.png" alt="FlyFoenix.com - Best NCAA gear!" />
    <span id="caption" class="four">Unique Collegiate Fashion.&nbsp;&nbsp;Quick Shopping.&nbsp;&nbsp;Great Fit & Feel.&nbsp;&nbsp;High Style.&nbsp;&nbsp;Lower Prices.</span>
    <div id="navigate">
    <?php if($loggedin){ ?>
    <span class="five">Welcome &nbsp; <?php echo $myuser['User']['email']; ?></span>
    <span class="five"><a class="nav" href="/users/logout">Log Out</a></span>
    <span class="five"><a class="nav" href="#">Account Info</a></span>
    <?php } ?>
    <span class="five"><a class="nav" href="#">Contact</a></span>
    </div>