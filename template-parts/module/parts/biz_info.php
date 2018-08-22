<?php
global $theme_opt;


echo '<div class="biz_info-block">';


	if( !empty($theme_opt['base']['tel_number']) ){
		echo '
		<div class="biz_info-phone text-left">TEL /  <a href="tel:'.$theme_opt['base']['tel_number'].'">'.$theme_opt['base']['tel_number'].'</a></div>
		';
	}

	if( !empty($theme_opt['base']['zip_code']) || !empty($theme_opt['base']['contact_address']) ){
		echo '<div class="biz_info-address text-left">';
			if( !empty($theme_opt['base']['zip_code']) ){
				echo '〒'. $theme_opt['base']['zip_code'].'<div class="br-block"></div>';
			}
			echo $theme_opt['base']['contact_address'];
		echo '</div>
		';
	};


	if( !empty($theme_opt['base']['biz_time']) ){
		echo '
		<dl class="biz_info-biztime">
			<dt class="inline-block">営業時間</dt>
			<dd class="inline-block">'.nl2br(esc_html($theme_opt['base']['biz_time'])).'</dd>
		</dl>
		';
	}

	if( !empty($theme_opt['base']['biz_holiday']) ){
		echo '
		<dl class="biz_info-holiday">
			<dt class="inline-block">定休日</dt>
			<dd class="inline-block">'.apply_filters( 'the_content', $theme_opt['base']['biz_holiday'] ).'</dd>
		</dl>
		';
	}

	if( !empty($theme_opt['base']['biz_parking']) ){
		echo '
		<dl class="biz_info-parking">
			<dt class="inline-block">駐車場</dt>
			<dd class="inline-block">'.$theme_opt['base']['biz_parking'].'</dd>
		</dl>
		';
	}


	if( !empty($theme_opt['base']['biz_message']) ){
		echo '
		<div class="biz_info-message">'.apply_filters( 'the_content', $theme_opt['base']['biz_message'] ).'</div>
		';
	}

echo '</div>';
?>