<?php 
//$st_url = 'http://flyfoenix.com/users/referred/' . $myuser['User']['id'];
$st_url = "http://www.flyfoenix.com/users/referred/{$myuser['User']['id']}/{$product['Product']['id']}";
$st_img = "http://www.flyfoenix.com{$shareImage}";
?>
<div id="sharethis">
      <span st_image='<?php echo $st_img; ?>' st_url='<?php echo $st_url; ?>'  class='st_twitter_large' ></span>
      <span st_image='<?php echo $st_img; ?>' st_url='<?php echo $st_url; ?>'  class='st_facebook_large' ></span>
      <span st_image='<?php echo $st_img; ?>' st_url='<?php echo $st_url; ?>'  class='st_yahoo_large' ></span>
      <span st_image='<?php echo $st_img; ?>' st_url='<?php echo $st_url; ?>'  class='st_gbuzz_large' ></span>
      <span st_image='<?php echo $st_img; ?>' st_url='<?php echo $st_url; ?>'  class='st_email_large' ></span>
      <span st_image='<?php echo $st_img; ?>' st_url='<?php echo $st_url; ?>'  class='st_sharethis_large' ></span>
    </div>