<?php echo $this->element('layouts/lightbg_top'); ?>
<div class="title">Contact Us</div>
<img src="/img/productpresentation/flyfoenix_product_presentation_grayline.png" width="100%" height="2" /><br/>
<p>You can reach us at webmaster@flyfoenix.com or send an email with the form below.</p>

<form method="post" action="/users/contactus">
<div>
	<span class="six">Your Email&nbsp;&nbsp;</span><br />
	<input class="fieldwidth" style="width:250px" name="email" value="" type="text"  size="" />
</div>
<div>
	<span class="six">Message&nbsp;&nbsp;</span><br />
	<textarea class="fieldwidth" style="width:250px;height:150px" name="message" value="" type="text"  size="" ></textarea>
</div>
<br/>
<input class="btn" type="submit" value="Submit" />
</form>





<?php echo $this->element('layouts/lightbg_bottom'); ?>