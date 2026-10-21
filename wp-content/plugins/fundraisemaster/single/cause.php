<?php

	get_header();

	echo '<div class="chariti-header-transparent-substitute" ></div>';

	$post_meta = get_post_meta(get_the_ID(), 'gdlr-core-page-option', true);

	$cause_info_width = intval(frmaster_get_option('general', 'single-cause-info-width', '20'));
	$cause_info_left_class = 'frmaster-column-' . (60 - $cause_info_width);
	$cause_info_right_class = 'frmaster-column-' . $cause_info_width;

	echo '<div class="frmaster-cause-header clearfix" >';
	echo '<div class="frmaster-cuase-header-container frmaster-container" >';

	// left thumbnail
	$cause_thumbnail = get_post_thumbnail_id();
	if( !empty($cause_thumbnail) ){
		$cause_thumbnail_size = frmaster_get_option('general', 'single-cause-thumbnail-size', 'full');
		echo '<div class="frmaster-cause-thumbnail-wrap frmaster-item-pdlr ' . esc_attr($cause_info_left_class) . ' clearfix" >';
		echo '<div class="frmaster-cause-thumbnail chariti-media-image" >';
		echo frmaster_get_image($cause_thumbnail, $cause_thumbnail_size);

		if( !empty($post_meta['lightbox-video-url']) ){
			echo '<a ' . frmaster_get_lightbox_atts(array(
				'class' => 'frmaster-single-cause-video-lb',
				'url' => $post_meta['lightbox-video-url']
			)) . ' ><i class="fa fa-play" ></i></a>';
		}

		if( !empty($post_meta['lightbox-gallery']) ){

			$first = true;
			$lb_group = 'frmaster-single-cause-gallery';
			foreach($post_meta['lightbox-gallery'] as $gallery_image){
				$lightbox_atts = array(
					'url' => frmaster_get_image_url($gallery_image['id']), 
					'group' => $lb_group
				);

				if( $first ){
					$lightbox_atts['class'] = 'frmaster-single-cause-gallery-lb';
					echo '<a ' . frmaster_get_lightbox_atts($lightbox_atts) . ' >';
					echo '<i class="fa fa-file-image-o" ></i>';
					echo '</a>';

					$first = false;
				}else{
					echo '<a ' . frmaster_get_lightbox_atts($lightbox_atts) . ' ></a>';
				}
			}
		}

		echo '</div>'; // frmaster-cause-thumbnail

		if( !empty($post_meta['pdf-url']) ){
			echo '<a class="frmaster-cause-pdf-download" href="' . esc_url($post_meta['pdf-url']) . '" target="_blank" >';
			echo '<i class="fa fa-file-pdf-o" ></i>' . esc_html__('Download PDF', 'frmaster');
			echo '</a>';
		}
		echo '</div>'; // frmaster-cause-thumbnail-wrap
	}else{
		$cause_info_right_class .= ' frmaster-center';
	}
	
	// right cause info
	echo '<div class="frmaster-cause-info-wrap  frmaster-item-pdlr ' . esc_attr($cause_info_right_class) . '" >';
	echo '<div class="frmaster-cause-title-wrap" >';
	echo '<h1 class="frmaster-cause-title" >' . get_the_title() . '</h1>';
	if( !empty($post_meta['caption']) ){
		echo '<div class="frmaster-cause-caption" >' . frmaster_text_filter($post_meta['caption']) . '</div>';
	}
	echo '</div>'; // frmaster-cause-title-wrap

	$funding_goal = get_post_meta(get_the_ID(), 'frmaster-funding-goal', true);
	$donor_amount = get_post_meta(get_the_ID(), 'frmaster-donor-amount', true);
	$donated_amount = get_post_meta(get_the_ID(), 'frmaster-donated-amount', true);
	$donated_percent = ($funding_goal == 0)? 0: intval(($donated_amount*100) / $funding_goal);

	echo '<div class="frmaster-cause-info" >';

	if( !empty($funding_goal) ){
		echo '<div class="frmaster-cause-donated-bar-wrap clearfix" >';
		echo '<div class="frmaster-cause-donated-bar" ><span ' . gdlr_core_esc_style(array(
			'width' => $donated_percent . '%'
		)) . ' ></span></div>';
		echo '<div class="frmaster-cause-donated-bar-percent" >' . sprintf(esc_html__('%d%% Donated', 'frmaster'), $donated_percent) . '</div>';
		echo '<div class="frmaster-cause-goal" >' . sprintf(esc_html__('Goal : %s', 'frmaster'), frmaster_money_format($funding_goal)) . '</div>';
		echo '</div>'; // frmaster-cause-donated-bar-wrap
	}

	echo '<div class="frmaster-cause-donation-info clearfix" >';
	echo '<div class="frmaster-cause-donor-amount" >';
	echo '<div class="frmaster-head" >' . frmaster_text_filter(empty($donor_amount)? 0: $donor_amount) . '</div>';
	echo '<div class="frmaster-tail" >' . esc_html__('Donors', 'frmaster') . '</div>';
	echo '</div>'; // frmaster-cause-donor-amount
	echo '<div class="frmaster-cause-donated-amount" >';
	echo '<div class="frmaster-head" >' . frmaster_money_format($donated_amount) . '</div>';
	echo '<div class="frmaster-tail" >' . esc_html__('Donated', 'frmaster') . '</div>';
	echo '</div>'; // frmaster-cause-donated-amount
	echo '</div>'; // frmaster-cause-donation-info

	echo '<div class="frmaster-cause-info-bottom" >';
	echo frmaster_get_cause_social($post_meta);
	echo frmaster_get_donate_button();
	echo frmaster_get_follow_link();
	echo '</div>'; // frmaster-cause-info-bottom
	echo '</div>'; // frmaster-cause-info
	echo '</div>'; // frmaster-cause-info-wrap

	echo '</div>'; // frmaster-cause-header-container
	echo '</div>'; // frmaster-cause-header

	// content & page builder data
	echo '<div class="frmaster-cause-content-wrap" >';
	global $post;
	while( have_posts() ){ the_post();

		if( empty($tour_option['show-wordpress-editor-content']) || $tour_option['show-wordpress-editor-content'] == 'enable' ){
			ob_start();
			the_content();
			$content = ob_get_contents();
			ob_end_clean();

			if( !empty($content) ){
				echo '<div class="frmaster-container" >';
				echo '<div class="frmaster-page-content frmaster-item-pdlr" >';
				echo '<div class="frmaster-cause-content" >' . $content . '</div>';
				echo '</div>'; // frmaster-page-content
				echo '</div>'; // frmaster-container
			}
		}
	}

	if( !post_password_required() ){
		do_action('gdlr_core_print_page_builder');
	}

	// comments template
	if( comments_open() || get_comments_number() ){
		echo '<div class="frmaster-comment-wrapper">';
		echo '<div class="frmaster-comment-container frmaster-container">';
		comments_template();
		echo '</div>';
		echo '</div>';
	}	
	echo '</div>'; // frmaster-cause-content-wrap


	get_footer(); 

?>