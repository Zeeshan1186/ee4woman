<?php
	// Main Text
	$charitio_need_copyright = cs_get_option('hide_copyright');
	$charitio_copyright_text = cs_get_option( 'copyright_text' );
	if ( $charitio_copyright_text ) {
		$footer_class = '';
	} else {
		$footer_class = ' has-not-copyright text-center';
	}
?>
<div class="wpo-lower-footer <?php echo esc_attr( $footer_class ); ?>">
  <div class="container">
    <div class="row">
      <div class="separator"></div>
      <div class="col col-xs-12">
         <?php
			  if ( $charitio_copyright_text ) {
				  echo '<p class="copyright" >'. wp_kses( do_shortcode( $charitio_copyright_text ) , array( 'div' => array( 'class' => array(), ), 'a' => array('href' => array(),'title' => array()),'p' => array(),'ul' => array(),'li' => array(),) ) .'</p>';
			  } else {
				  echo '<p>&copy; Copyright '.current_time( 'Y' ).' | <a href="'.esc_url( get_home_url( '/' ) ).'">'.get_bloginfo( 'name' ).'</a> | All right reserved.</p>';
			  }
			  $charitio_secondary_text = cs_get_option( 'secondary_text' );
			  echo wp_kses( do_shortcode( $charitio_secondary_text ) , array( 'div' => array( 'class' => array(), ), 'a' => array('href' => array(),'title' => array()),'p' => array(),'ul' => array(),'li' => array(),) );
		  ?>
      </div>
    </div>
  </div>
</div>