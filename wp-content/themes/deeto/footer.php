<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package deeto
 */

?>
		<footer id="colophon" class="site-footer">
			<div class="footer-inner">
				<?php if (has_nav_menu('menu-2')) : ?>
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-2',
							'menu_id'        => 'footer-menu',
							'container_class' => 'footer-menu-container'
						)
					);
					?>
				<?php endif; ?>
			</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
