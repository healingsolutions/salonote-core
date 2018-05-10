<div class="sns-buttons-unit">
	<ul>
	<?php
	$url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

	echo '<li class="sns-block-line"><a href="http://line.me/R/msg/text/?'.$url.' '.wp_title('',false).'" target="_blank">LINE</a></li>';
	echo '<li class="sns-block-google"><a href="https://plus.google.com/share?url='.$url.'" target="_blank">Google+</a></li>';
	echo '<li class="sns-block-twitter"><a href="https://twitter.com/intent/tweet?text='.$url.' '.wp_title('',false).'" target="_blank">Twitter</a></li>';
	echo '<li class="sns-block-facebook"><a href="https://www.facebook.com/sharer/sharer.php?u='.$url.'" target="_blank">Facebook</a></li>';

	?>
	</ul>
</div>
