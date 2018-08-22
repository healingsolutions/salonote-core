<?php

/***********************************************
 * カレンダーを表示しよう
 ***********************************************/
function shortcode_my_calendar($params = array()) {
 
        // ショートコードのパラメータを取得
    extract(shortcode_atts(array(
        'ym' => null
    ), $params));
 
        // 現在の年月日を取得
        $current_y = date_i18n('Y');
        $current_m = date_i18n('m');
        $current_d = date_i18n('d');
 
        // ショートコードで年月が指定していなければ、現在の年月を設定
        $calendar_ym = ( $params['ym'] ) ? $params['ym'] : $current_y . '-' . $current_m;
 
        // 該当月のイベントを取得し配列に格納
        $args = array(
                'post_status' => 'publish',
                'posts_per_page' => -1, // 全件取得
                'meta_query' => array(
                        array(
                                'key' => 'event_date',
                                'value' => $calendar_ym,
                                'compare' => 'LIKE'
                        )
                )
        );
        $event_posts = get_posts( $args );
        $events = array();
        if ( $event_posts ) {
                foreach ( $event_posts as $post ) {
                        $event_date = esc_html( get_post_meta( $post -> ID, 'event_date', true ) );
                        $event_link = get_permalink( $post -> ID );
                        $events[$event_date][] = "<a href='{$event_link}'>●</a>";
                }
        }
 
        // 表示年月の日数を取得
        $calendar_t = date_i18n('t', strtotime($calendar_ym.'-01'));
 
        // 祝日の取得
        $holidays = get_holidays ($calendar_ym, $calendar_t);
 
        // カレンダー表示 ?>
<h3><?php echo $calendar_ym ?></h3>
<table class="calendar">
        <tr>
                <th class="w0">日</th>
                <th class="w1">月</th>
                <th class="w2">火</th>
                <th class="w3">水</th>
                <th class="w4">木</th>
                <th class="w5">金</th>
                <th class="w6">土</th>
        </tr>
        <tr>
                <?php
        $dayArr = array('日', '月', '火', '水', '木', '金', '土');
        $index = 0;
        for ( $i = 1; $i <= $calendar_t; $i++ ):
                $calendar_day = date_i18n('w', strtotime($calendar_ym . '-' . $i));
                $calendar_date = ( $i < 10 ) ? '0' . $i : $i;
 
                // 1日が日曜日ではない場合の空白セル
                if ( $i == 1 && $calendar_day != 0 ):
                        for ( $index = 0; $index < $calendar_day; $index++ ):
                        ?>
                <td class="<?php echo 'w' . $index ?>"> </td>
                <?php
                        endfor;
                endif;
 
                // 祝日かどうか
                $hol = ( in_array( $calendar_ym . '-' .  $calendar_date, $holidays ) ) ? ' hol' : '';
 
                // 日付表示 ?>
                <td class="<?php echo 'w' . $calendar_day .$hol ?>"><span class="date"><?php echo $i ?></span><?
                        // 該当日付のイベントがあればリンクを表示
                        if ( isset($events[$calendar_ym . '-' .  $calendar_date]) && count( $events[$calendar_ym . '-' .  $calendar_date] ) > 0 ) {
                                foreach ( $events[$calendar_ym . '-' .  $calendar_date] as $event ) {
                                        echo $event;
                                }
                        } ?></td>
                <?php
 
                // 土曜日なら行末
                if ( $calendar_day == 6 ): ?>
        </tr>
        <tr>
                <?php
                endif;
 
                $index++;
 
                // 最終日の後の空白
                if ( $i == $calendar_t && $index < 42 ):
                        for ( $index; $index < 42; $index++ ):
                                if ( $calendar_day == 6 ) {
                                        $calendar_day = 0; ?>
        </tr>
        <tr>
                <?php
                                } elseif ( $calendar_day < 6 ) {
                                        $calendar_day++;
                                } ?>
                <td class="<?php echo 'w' . $calendar_day ?>"> </td>
                <?php
                        endfor;
                endif;
        endfor;
        ?>
        </tr>
</table>
<?php
}
add_shortcode('my-calendar', 'shortcode_my_calendar');

?>