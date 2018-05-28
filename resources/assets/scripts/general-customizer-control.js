function media_upload(button_class) {
    'use strict';
    jQuery('body').on('click', button_class, function() {
        var button_id ='#'+jQuery(this).attr('id');
        var display_field = jQuery(this).parent().children('input:text');
        var _custom_media = true;

        wp.media.editor.send.attachment = function(props, attachment){

            if ( _custom_media  ) {
                if(typeof display_field !== 'undefined'){
                    switch(props.size){
                        case 'full':
                            display_field.val(attachment.sizes.full.url);
                            display_field.trigger('change');
                            break;
                        case 'medium':
                            display_field.val(attachment.sizes.medium.url);
                            display_field.trigger('change');
                            break;
                        case 'thumbnail':
                            display_field.val(attachment.sizes.thumbnail.url);
                            display_field.trigger('change');
                            break;
                        case 'customizer_team':
                            display_field.val(attachment.sizes.customizer_team.url);
                            display_field.trigger('change');
                            break;
                        case 'customizer_services':
                            display_field.val(attachment.sizes.customizer_services.url);
                            display_field.trigger('change');
                            break;
                        case 'customizer_customers':
                            display_field.val(attachment.sizes.customizer_customers.url);
                            display_field.trigger('change');
                            break;
                        default:
                            display_field.val(attachment.url);
                            display_field.trigger('change');
                    }
                }
                _custom_media = false;
            } else {
                return wp.media.editor.send.attachment( button_id, [props, attachment] );
            }
        };
        wp.media.editor.open(button_class);
        window.send_to_editor = function() {

        };
        return false;
    });
}

/********************************************
 *** Generate uniq id ***
 *********************************************/
function customizer_uniqid(prefix, more_entropy) {

    if (typeof prefix === 'undefined') {
        prefix = '';
    }

    var retId;
    var formatSeed = function(seed, reqWidth) {
        seed = parseInt(seed, 10)
            .toString(16); // to hex str
        if (reqWidth < seed.length) { // so long we split
            return seed.slice(seed.length - reqWidth);
        }
        if (reqWidth > seed.length) { // so short we pad
            return Array(1 + (reqWidth - seed.length))
                    .join('0') + seed;
        }
        return seed;
    };

    // BEGIN REDUNDANT
    if (!this.php_js) {
        this.php_js = {};
    }
    // END REDUNDANT
    if (!this.php_js.uniqidSeed) { // init seed with big random int
        this.php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
    }
    this.php_js.uniqidSeed++;

    retId = prefix; // start with prefix, add current milliseconds hex string
    retId += formatSeed(parseInt(new Date()
            .getTime() / 1000, 10), 8);
    retId += formatSeed(this.php_js.uniqidSeed, 5); // add seed hex string
    if (more_entropy) {
        // for more entropy we add a float lower to 10
        retId += (Math.random() * 10)
            .toFixed(8)
            .toString();
    }

    return retId;
}


/********************************************
 *** General Repeater ***
 *********************************************/
function customizer_refresh_general_control_values(){
    'use strict';
    jQuery('.customizer_general_control_repeater').each(function(){
        var values = [];
        var th = jQuery(this);
        th.find('.customizer_general_control_repeater_container').each(function(){
            var text = jQuery(this).find('.customizer_text_control').val();
            var link = jQuery(this).find('.customizer_link_control').val();
            var image_url = jQuery(this).find('.custom_media_url').val();
            var choice = jQuery(this).find('.customizer_image_choice').val();
            var title = jQuery(this).find('.customizer_title_control').val();
            var subtitle = jQuery(this).find('.customizer_subtitle_control').val();
            var id = jQuery(this).find('.customizer_box_id').val();
            if( !id ){
                id = 'customizer_' + customizer_uniqid();
                jQuery(this).find('.customizer_box_id').val(id);
            }
            var social_repeater = jQuery(this).find('.customizer_socials_repeater_colector').val();
            var shortcode = jQuery(this).find('.customizer_shortcode_control').val();

            if( text !== '' || image_url!== '' || title!=='' || subtitle!=='' ){
                values.push({
                    'text' :  escapeHtml(text),
                    'link' : link,
                    'image_url' : (choice === 'parallax_none' ? '' : image_url),
                    'choice' : choice,
                    'title' : escapeHtml(title),
                    'subtitle' : escapeHtml(subtitle),
                    'social_repeater' : escapeHtml(social_repeater),
                    'id' : id,
                    'shortcode' : escapeHtml(shortcode),
                });
            }

        });
        th.find('.customizer_repeater_colector').val(JSON.stringify(values));
        th.find('.customizer_repeater_colector').trigger('change');
    });
}



jQuery(document).ready(function(){
    'use strict';
    jQuery('#customize-theme-controls').on('click','.customizer-customize-control-title',function(){
        jQuery(this).next().slideToggle('medium', function() {
            if (jQuery(this).is(':visible')){
                jQuery(this).css('display','block');
            }
        });
    });

    jQuery('#customize-theme-controls').on('change', '.icp',function(){
        customizer_refresh_general_control_values();
        return false;
    });

    jQuery('#customize-theme-controls').on('change','.customizer_image_choice',function() {
        if(jQuery(this).val() === 'parallax_image'){
            jQuery(this).parent().parent().find('.customizer_general_control_icon').hide();
            jQuery(this).parent().parent().find('.customizer_image_control').show();
        }
        if(jQuery(this).val() === 'parallax_icon'){
            jQuery(this).parent().parent().find('.customizer_general_control_icon').show();
            jQuery(this).parent().parent().find('.customizer_image_control').hide();
        }
        if(jQuery(this).val() === 'parallax_none'){
            jQuery(this).parent().parent().find('.customizer_general_control_icon').hide();
            jQuery(this).parent().parent().find('.customizer_image_control').hide();
        }

        customizer_refresh_general_control_values();
        return false;
    });
    media_upload('.custom_media_button_customizer');
    jQuery('.custom_media_url').live('change',function(){
        customizer_refresh_general_control_values();
        return false;
    });

    /**
     * This adds a new box to repeater
     *
     */
    jQuery('#customize-theme-controls').on('click', '.customizer_general_control_new_field', function() {
        var th = jQuery(this).parent();
        var id = 'customizer_' + customizer_uniqid();
        if( typeof th !== 'undefined' ) {
            /* Clone the first box*/
            var field = th.find('.customizer_general_control_repeater_container:first').clone();

            if( typeof field !== 'undefined' ){
                /*Set the default value for choice between image and icon to icon*/
                field.find('.customizer_image_choice').val('customizer_icon');

                /*Show icon selector*/
                field.find('.customizer_general_control_icon').show();

                /*Hide image selector*/
                if(field.find('.customizer_general_control_icon').length > 0){
                    field.find('.customizer_image_control').hide();
                }

                /*Show delete box button because it's not the first box*/
                field.find('.customizer_general_control_remove_field').show();


                field.find('.input-group-addon span').attr('class','');

                /*Remove all repeater fields except first one*/
                field.find('.customizer-social-repeater').find('.customizer-social-repeater-container').not(':first').remove();
                field.find('.customizer_social_repeater_link').val('');
                field.find('.customizer_socials_repeater_colector').val('');


                /*Remove value from text field*/
                field.find('.customizer_text_control').val('');

                /*Remove value from link field*/
                field.find('.customizer_link_control').val('');

                /*Set box id*/
                field.find('.customizer_box_id').val(id);

                /*Remove value from media field*/
                field.find('.custom_media_url').val('');

                /*Remove value from title field*/
                field.find('.customizer_title_control').val('');

                /*Remove value from subtitle field*/
                field.find('.customizer_subtitle_control').val('');

                /*Remove value from shortcode field*/
                field.find('.customizer_shortcode_control').val('');

                /*Append new box*/
                th.find('.customizer_general_control_repeater_container:first').parent().append(field);

                /*Refresh values*/
                customizer_refresh_general_control_values();
            }

        }
        return false;
    });



    jQuery('#customize-theme-controls').on('click', '.customizer_general_control_remove_field',function(){
        if( typeof	jQuery(this).parent() !== 'undefined'){
            jQuery(this).parent().parent().remove();
            customizer_refresh_general_control_values();
        }
        return false;
    });


    jQuery('#customize-theme-controls').on('keyup', '.customizer_title_control',function(){
        customizer_refresh_general_control_values();
    });

    jQuery('#customize-theme-controls').on('keyup', '.customizer_subtitle_control',function(){
        customizer_refresh_general_control_values();
    });

    jQuery('#customize-theme-controls').on('keyup', '.customizer_shortcode_control',function(){
        customizer_refresh_general_control_values();
    });

    jQuery('#customize-theme-controls').on('keyup', '.customizer_text_control',function(){
        customizer_refresh_general_control_values();
    });

    jQuery('#customize-theme-controls').on('keyup', '.customizer_link_control',function(){
        customizer_refresh_general_control_values();
    });

    /*Drag and drop to change icons order*/

    jQuery('.customizer_general_control_droppable').sortable({
        update: function() {
            customizer_refresh_general_control_values();
        },
    });

});

var entityMap = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    '\'': '&#39;',
    '/': '&#x2F;',
};

function escapeHtml(string) {
    'use strict';
    string = String(string).replace(/['\r\n']/g, '<br />');
    string = String(string).replace(/\\/g,'&#92;');
    return String(string).replace(/[&<>"'/]/g, function (s) {
        return entityMap[s];
    });

}
