/*
 * All Admin Related Scripts in this Charitio Theme
 * Author & Copyright:wpoceans
 * URL: http://themeforest.net/user/wpoceans
 */

(function($) {
"use strict";
  /*---------------------------------------------------------------*/
  /* =  Toggle Meta boxes based on post formats
  /*---------------------------------------------------------------*/
   function charitio_gutenberg_toggle_metaboxes() {

        $(document).on('change','.editor-post-format__content select',function(){

        $('.cs-element-standard-image, .cs-element-gallery-format, .cs-element-add-gallery, .video_post_format, .quote_post_format').hide();

          var format = $(this).children("option:selected").val();
          console.log( format );

          if (format == '0' || format == 'image') {
              $('').slideUp('fast');
              $('.cs-element-standard-image').slideDown('slow');
          }
          if (format == 'gallery') {
              $('').slideUp('fast');
              $('.cs-element-gallery-format, .cs-element-add-gallery').slideDown('slow');
          }
          if (format == 'video') {
              $('').slideUp('fast');
              $('#post_type_metabox .video_post_format').slideDown('slow');
          }
          if (format == 'quote') {
              $('').slideUp('fast');
              $('#post_type_metabox .quote_post_format').slideDown('slow');
          }
        });
  }
  function charitio_toggle_metaboxes() {

    var format = $("input[name='post_format']:checked").val();

    $('.cs-element-standard-image, .cs-element-gallery-format, .cs-element-add-gallery, .video_post_format, .quote_post_format').hide();

    // show which field is alreay filled out
    if($(".cs-element-add-gallery .cs-fieldset ul li").length) {
        $('.cs-element-gallery-format, .cs-element-add-gallery').show();
    }

    if(!$(".quote_post_format .cs-icon-preview.hidden").length) {
        $('#post_type_metabox .quote_post_format').show();
    }

    if($(".video_post_format .cs-fieldset > input").attr("value")) {
        $('#post_type_metabox .video_post_format').show();
    }

    if($(".audio_post_format .cs-fieldset > input").attr("value")) {
        $('#post_type_metabox .audio_post_format').show();
    }

    if (format == '0' || format == 'image') {
        $('').slideUp('fast');
        $('.cs-element-standard-image').slideDown('slow');
    }
    if (format == 'gallery') {
        $('').slideUp('fast');
        $('.cs-element-gallery-format, .cs-element-add-gallery').slideDown('slow');
    }
    if (format == 'video') {
        $('').slideUp('fast');
        $('#post_type_metabox .video_post_format').slideDown('slow');
    }
    if (format == 'quote') {
        $('').slideUp('fast');
        $('#post_type_metabox .quote_post_format').slideDown('slow');
    }

  }

  $(document).ready(function() {
      charitio_gutenberg_toggle_metaboxes();
      charitio_toggle_metaboxes();
    $('#post-formats-select input[type="radio"]').on('click', charitio_toggle_metaboxes);
  });

})(jQuery);