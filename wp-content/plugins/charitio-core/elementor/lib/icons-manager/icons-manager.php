<?php
namespace Elementor;

defined( 'ABSPATH' ) || die();

class Charitio_Icons_Manager {

    public static function init() {
        add_filter( 'elementor/icons_manager/additional_tabs', [ __CLASS__, 'add_charitio_icons_tab' ] );
    }

    public static function add_charitio_icons_tab( $tabs ) {
        $tabs['charitio-icons'] = [
            'name' => 'charitio-icons',
            'label' => __( 'Charitio Icons', 'charitio-elementor-addons' ),
            'url' => CHARITIO_PLUGIN_URL . 'elementor/assets/css/flaticon.css',
            'enqueue' => [ CHARITIO_PLUGIN_URL . 'elementor/assets/css/flaticon.css' ],
            'prefix' => 'flaticon-',
            'displayPrefix' => 'fi',
            'labelIcon' => 'flaticon-vegetable',
            'ver' => '1.0.0',
            'fetchJson' => CHARITIO_PLUGIN_URL . 'elementor/assets/js/charitio-icons.js?v=1.0.0',
            'native' => false,
        ];
        return $tabs;
    }

    /**
     * Get a list of charitio icons
     *
     * @return array
     */
    public static function get_charitio_icons() {
        return [
            'flaticon-salary' => 'salary',
            'flaticon-vegetable'  => 'vegetable',
            'flaticon-water-tap' => 'water-tap',
            'flaticon-medicine' => 'medicine',
            'flaticon-graduation-cap' => 'graduation-cap',
            'flaticon-wallet-filled-money-tool' => 'wallet-filled-money-tool',
            'flaticon-right-quotes-symbol' => 'right-quotes-symbol',
            'flaticon-left-arrow' => 'left-arrow',
            'flaticon-right-arrow' => 'right-arrow',
            'flaticon-elephant' => 'elephant',
            'flaticon-tiger' => 'tiger',
            'flaticon-whale' => 'whale',
            'flaticon-target' => 'target',
            'flaticon-search' => 'search',
            'flaticon-chat-comment-oval-speech-bubble-with-text-lines' => 'chat-comment-oval-speech-bubble-with-text-lines',
            'flaticon-placeholder' => 'placeholder',
            'flaticon-phone-call' => 'phone-call',
            'flaticon-email' => 'email',
            'flaticon-facebook-app-symbol' => 'facebook-app-symbol',
            'flaticon-twitter' => 'twitter',
            'flaticon-linkedin' => 'linkedin',
            'flaticon-instagram' => 'instagram',
            'flaticon-dolphin' => 'dolphin',
            'flaticon-fish' => 'fish',
            'flaticon-play-button' => 'play-button',
            'flaticon-checked' => 'checked',
            'flaticon-next' => 'next',
            'flaticon-left-arrow-1' => 'left-arrow-1',
            'flaticon-forest' => 'forest',
            'flaticon-ecology' => 'ecology',
            'flaticon-eco-light' => 'eco-light',
            'flaticon-mail' => 'mail',
            'flaticon-location' => 'flaticon-location',
            'flaticon-google-plus' => 'google-plus',
            'flaticon-user' => 'user',
            'flaticon-comment-white-oval-bubble' => 'comment-white-oval-bubble',
            'flaticon-calendar' => 'calendar',
            'flaticon-left-arrow-2' => 'left-arrow-2',
            'flaticon-right-arrow-1' => 'right-arrow-1',
            'flaticon-play' => 'play',
            'flaticon-right-quote-sign' => 'right-quote-sign',
            'flaticon-left-quote' => 'left-quote',
        ];
    }
}

Charitio_Icons_Manager::init();