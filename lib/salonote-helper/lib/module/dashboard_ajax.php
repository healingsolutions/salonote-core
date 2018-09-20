<?php


add_action('wp_dashboard_setup', 'salonote_dashboard_widgets');
function salonote_dashboard_widgets() {
	wp_add_dashboard_widget('salonote_dashboard_options_widget', 'サロンノートNEWS', 'salonote_dashboard_widget_function');
}
function salonote_dashboard_widget_function() {
	
	include_once(ABSPATH . WPINC . '/feed.php');
	$rss = fetch_feed('https://salonote.com/feed/'); // RSSのURLを指定
	
	if (!is_wp_error( $rss ) ) :
		$maxitems = $rss->get_item_quantity(10); // 表示する記事の最大件数
		$rss_items = $rss->get_items(0, $maxitems); 
	endif;
	?>
	
	<ul>
	<?php
	if ( empty($maxitems) || $maxitems == 0): echo '<li>表示するものががありません</li>';
	else :
	date_default_timezone_set('Asia/Tokyo');
	foreach ( $rss_items as $item ) : ?>
	<li class="hentry">
	<a href="<?php echo $item->get_permalink(); ?>" rel="bookmark">
	<span class="entry-date published"><?php echo $item->get_date('Y年n月j日'); ?></span>
	<span class="entry-title"><?php echo $item->get_title(); ?></span>
	</a>
	</li>
	<?php endforeach; ?>
	<?php endif; ?>
	</ul>


	<?php
}


?>
