import 'jquery';
import datepickerFactory from 'jquery-datepicker';

datepickerFactory(jQuery);

var file_frame;

jQuery('#upload_image_button').on('click', function(event){
  event.preventDefault();
  if ( file_frame ) {
      file_frame.open();
    return;
  }

  // Create the media frame.
  file_frame = wp.media.frames.file_frame = wp.media({
    title: jQuery( this ).data( 'File upload' ),
    button: {
      text: jQuery( this ).data( 'Upload' ),
    },
    multiple: false,  // Set to true to allow multiple files to be selected
  });

  // When an image is selected, run a callback.
  file_frame.on( 'select', function() {
    // We set multiple to false so only get one image from the uploader
    var attachment = file_frame.state().get('selection').first().toJSON();
    jQuery('#upload_image').attr('value', attachment.url);
    jQuery('#upload_image_preview').attr('src', attachment.url);
  });

  // Finally, open the modal
  file_frame.open();
});

jQuery(document).ready(function() {
  jQuery('.datepicker').datepicker();

  if(jQuery('#course_day_schedule-repeatable .repeatable-remove').length == 1) {
      jQuery('#course_day_schedule-repeatable .repeatable-remove').hide();
  }

  if(jQuery('#course_night_schedule-repeatable .repeatable-remove').length == 1) {
      jQuery('#course_night_schedule-repeatable .repeatable-remove').hide();
  }

  jQuery('.repeatable-add').click(function() {
      jQuery('.datepicker').datepicker('destroy');//Hacky solution for the problem when cloning jquery-ui-datepicker
      var field = jQuery(this).closest('td').find('.custom_repeatable li:last').clone(true);
      var fieldLocation = jQuery(this).closest('td').find('.custom_repeatable li:last');
      jQuery('input', field).val('')
              .attr({ 'name' : function(index, name) {
                      return name.replace(/(\d+)/, function(fullMatch, n) {
                          return Number(n) + 1; //Increment the name
                      });
                  }, 'id' : function(index, id) {
                      return id.replace(/(\d+)/, function(fullMatch, n) {
                          return Number(n) + 1; //Increment the id
                      });
              }});
      field.insertAfter(fieldLocation, jQuery(this).closest('td'))

      if(jQuery(this).closest('td').find('li').length >= 1) {
          jQuery(this).siblings('ul').find('a').show(); //Show Delete button
      }

      jQuery('.datepicker').datepicker(); //Re-initialize again
      return false;
  });
  jQuery('.repeatable-remove').click(function(){
      if(jQuery(this).parent().closest('ul').find('li').length == 2) {
          jQuery(this).parent().closest('ul').find('a').hide(); //Hide Delete button
      }
      jQuery(this).parent().remove();
      return false;
  });
});
