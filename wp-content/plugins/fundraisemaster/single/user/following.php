<?php
	echo '<div class="frmaster-user-content-inner frmaster-user-content-inner-follow" >';
	frmaster_get_user_breadcrumb();

	// follow block
	frmaster_user_content_block_start();
	echo '<table class="frmaster-follow-table frmaster-table" >';

	frmaster_get_table_head(array(
		esc_html__('Cause Name', 'frmaster'),
		esc_html__('Action', 'frmaster'),
	));

	$follow_ids = get_user_meta($current_user->ID, 'frmaster-follow', true);
	$follow_ids = empty($follow_ids)? array(): $follow_ids;
	if( !empty($_POST['remove-from-follow']) ){
		$follow_ids = array_diff($follow_ids, array($_POST['remove-from-follow']));
		update_user_meta($current_user->ID, 'frmaster-follow', $follow_ids);
	}
	
	foreach( $follow_ids as $follow_id ){
		$content  = '<div class="frmaster-follow-item" >';
		$thumbnail_id = get_post_thumbnail_id($follow_id);
		if( !empty($thumbnail_id) ){
			$content .= '<div class="frmaster-follow-thumbnail frmaster-media-image" >' . frmaster_get_image($thumbnail_id, 'thumbnail') . '</div>';
		}

		$content .= '<div class="frmaster-follow-item-content">';
		$content .= '<a class="frmaster-follow-item-title" href="' . get_permalink($follow_id) . '" target="_blank" >';
		$content .= get_the_title($follow_id);
		$content .= '</a>';

		$funding_goal = get_post_meta($follow_id, 'frmaster-funding-goal', true);
		$donated_amount = get_post_meta($follow_id, 'frmaster-donated-amount', true);
		$donated_percent = ($funding_goal == 0)? 0: intval(($donated_amount*100) / $funding_goal);
		$content .= '<div class="frmaster-follow-item-info" >';
		$content .= sprintf(esc_html__('%d%% Fundraised', 'frmaster'), $donated_percent);
		$content .= '</div>'; // frmaster-follow-item-info

		$content .= '</div>'; // frmaster-follow-item-content
		$content .= '</div>'; // frmaster-follow-item

		$remove_btn  = '<form class="frmaster-follow-remove-item" method="POST" action="" onClick="this.submit();" >';
		$remove_btn .= '<i class="fa fa-trash-o" ></i>' . esc_html__('Remove', 'frmaster');
		$remove_btn .= '<input type="hidden" name="remove-from-follow" value="' . esc_attr($follow_id) . '" />';
		$remove_btn .= '</form>';

		frmaster_get_table_content(array($content, $remove_btn));
	}

	echo '</table>';
	frmaster_user_content_block_end();

	echo '</div>'; // frmaster-user-content-inner