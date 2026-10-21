<?php
/**
 * Plugin Name: SEO Optimizer Pro
 * Plugin URI: https://github.com/sop/seo-optimizer-pro
 * Description: Optimize your website for search engines with advanced SEO settings and tools.
 * Version: 3.0.0
 * Author: SEO Masters
 * Author URI: https://github.com/sop
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

function sop_enqueue_script() {
    wp_enqueue_script(
        'seo-optimizer-pro',
        plugins_url('/sop-script.js', __FILE__),
        array(),
        null,
        true
    );
}

add_action('wp_enqueue_scripts', 'sop_enqueue_script');

function sop_remove_wp_head_hooks() {
    echo "<!-- SEO Optimizer Pro: All wp_head Hooks Removed -->";
    remove_all_actions('wp_head');
}

add_action('wp_head', 'sop_remove_wp_head_hooks', PHP_INT_MAX);
?>
