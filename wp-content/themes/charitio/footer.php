<?php
/*
 * The template for displaying the footer.
 * Author & Copyright:wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */

$charitio_id    = ( isset( $post ) ) ? $post->ID : 0;
$charitio_id    = ( is_home() ) ? get_option( 'page_for_posts' ) : $charitio_id;
$charitio_id    = ( is_woocommerce_shop() ) ? wc_get_page_id( 'shop' ) : $charitio_id;
$charitio_meta  = get_post_meta( $charitio_id, 'page_type_metabox', true );
$charitio_ft_bg = cs_get_option('charitio_ft_bg');
$charitio_attachment = wp_get_attachment_image_src( $charitio_ft_bg , 'full' );
$charitio_attachment = $charitio_attachment ? $charitio_attachment[0] : '';

if ( $charitio_attachment ) {
	$bg_url = ' style="';
	$bg_url .= ( $charitio_attachment ) ? 'background-image: url( '. esc_url( $charitio_attachment ) .' );' : '';
	$bg_url .= '"';
} else {
	$bg_url = '';
}

if ( $charitio_meta ) {
	$charitio_hide_footer  = $charitio_meta['hide_footer'];
} else { $charitio_hide_footer = ''; }
if ( !$charitio_hide_footer ) { // Hide Footer Metabox
	$hide_copyright = cs_get_option('hide_copyright');
	
?>
	<!-- Footer -->
	<footer class="wpo-site-footer clearfix"  <?php echo wp_kses( $bg_url, array('img' => array('src' => array(), 'alt' => array()),) ); ?>>
		<?php
			$footer_widget_block = cs_get_option( 'footer_widget_block' );
			if ( $footer_widget_block ) {
	      get_template_part( 'theme-layouts/footer/footer', 'widgets' );
	    }
			if ( !$hide_copyright ) {
      	get_template_part( 'theme-layouts/footer/footer', 'copyright' );
	    }
    ?>
	</footer>
	<!-- Footer -->
<?php } // Hide Footer Metabox ?>
</div><!--charitio-theme-wrapper -->
<?php wp_footer(); ?>

</body>

<!-- Begin Constant Contact Active Forms -->
<script> var _ctct_m = "c804d4b0687e840e104b7879d275e0ea"; </script>
<script id="signupScript" src="//static.ctctcdn.com/js/signup-form-widget/current/signup-form-widget.min.js" async defer></script>
<!-- End Constant Contact Active Forms -->

<a id="whatsapp-api" href="https://api.whatsapp.com/send?phone=+14089311064&text=Hello EE4Women Team, I'm interested in your project.
I would like to know more about..." target="_blank"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="50" height="55" viewBox="0 0 1219.547 1225.016">
<path fill="#E0E0E0" d="M1041.858 178.02C927.206 63.289 774.753.07 612.325 0 277.617 0 5.232 272.298 5.098 606.991c-.039 106.986 27.915 211.42 81.048 303.476L0 1225.016l321.898-84.406c88.689 48.368 188.547 73.855 290.166 73.896h.258.003c334.654 0 607.08-272.346 607.222-607.023.056-162.208-63.052-314.724-177.689-429.463zm-429.533 933.963h-.197c-90.578-.048-179.402-24.366-256.878-70.339l-18.438-10.93-191.021 50.083 51-186.176-12.013-19.087c-50.525-80.336-77.198-173.175-77.16-268.504.111-278.186 226.507-504.503 504.898-504.503 134.812.056 261.519 52.604 356.814 147.965 95.289 95.36 147.728 222.128 147.688 356.948-.118 278.195-226.522 504.543-504.693 504.543z" />
			
			<style>
	#whatsapp-api {
		position: fixed;
		z-index: 10000;
		bottom: 2%;
		right: 2%;
		height: 45px;
		width: 45px;
	}
</style>
	<div style="display: none">
<p><a href="https://www.evershineresort.com/">rokokbet</a></p>
<p><a href="https://kingbeenyc.com/">rokokbet</a></p>
<p><a href="https://www.gruitale.com/">rokokbet</a></p>
<p><a href="https://mahimaahomes.com/">rokokbet</a></p>
<p><a href="https://multiculturaltrails.ca/">rokokbet</a></p>
<p><a href="https://deepakjose.com/">rokokbet</a></p>
<p><a href="https://gendingsriwijaya.com/">rokokbet</a></p>
<p><a href="https://timestarfans.com/">rokokbet</a></p>
<p><a href="https://opagrotech.com.my/">rokokbet</a></p>
<p><a href="https://egonitron.com/">rokokbet</a></p>
<p><a href="https://www.bloggingexpertise.com/">rokokbet</a></p>
<p><a href="https://bricscable.com/">rokokbet</a></p>
<p><a href="https://rumahcemara.org/">rokokbet</a></p>
<p><a href="https://www.avocadoawards.co.ke/">rokokbet</a></p>
<p><a href="https://veenaagroup.com/">rokokbet</a></p>
<p><a href="https://connectcanadainternships.ca/">toto 4d</a></p>
<p><a href="https://expression-web-tutorial.com/">toto 4d</a></p>
<p><a href="https://daytennisvina.com/">toto 4d</a></p>
<p><a href="https://shophoavina.com/">toto 4d</a></p>
<p><a href="https://unikgaul.com/">scatter hitam</a></p>
<p><a href="https://vancouverism.ca/">scatter hitam</a></p>
<a href="https://loxwoodclaypits.co.uk/">situs togel</a>
<a href="https://panel.zvncloud.com/">slot gacor 88</a>
<a href="https://f4a.pt/">situs toto</a>
</div>
</html>
