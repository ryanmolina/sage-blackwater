<?php

namespace App\Customizer\Control;

class GeneralCustomizeControl extends \WP_Customize_Control {

    public $id;

    public $customizer_image_control = false;

    public $customizer_title_control = false;

    public $customizer_subtitle_control = false;

    public $customizer_text_control = false;

    public $customizer_link_control = false;

    public $customizer_shortcode_control = false;

    public $customizer_control_repeatable = false;

    public $customizer_control_sortable = false;

    public $customizer_title = 'Click me';

    public function __construct( $manager, $id, $title, $args = array()) {
        parent::__construct( $manager, $id, $args );
        $this->customizer_title = $title;
        if ( ! empty( $args['customizer_image_control'] ) ) {
            $this->customizer_image_control = $args['customizer_image_control'];
        }
        if ( ! empty( $args['customizer_title_control'] ) ) {
            $this->customizer_title_control = $args['customizer_title_control'];
        }
        if ( ! empty( $args['customizer_subtitle_control'] ) ) {
            $this->customizer_subtitle_control = $args['customizer_subtitle_control'];
        }
        if ( ! empty( $args['customizer_text_control'] ) ) {
            $this->customizer_text_control = $args['customizer_text_control'];
        }
        if ( ! empty( $args['customizer_link_control'] ) ) {
            $this->customizer_link_control = $args['customizer_link_control'];
        }
        if ( ! empty( $args['customizer_shortcode_control'] ) ) {
            $this->customizer_shortcode_control = $args['customizer_shortcode_control'];
        }
        if ( ! empty( $args['section'] ) ) {
            $this->id = $args['section'];
        }
    }

    /**
     * Render the content on the theme customizer page
     */
    public function render_content() {

        $this_default = json_decode( $this->setting->default );

        $values = $this->value();
        $json = json_decode( $values );
        if ( ! is_array( $json ) ) {
            $json = array( $values );
        } ?>

        <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
        <div class="customizer_general_control_repeater customizer_general_control_droppable">
            <?php
            if ( (count( $json ) == 1 && '' === $json[0] ) || empty( $json ) ) {
                if ( ! empty( $this_default ) ) {
                    $this->iterate_array( $this_default ); ?>
                    <input type="hidden" id="customizer_<?php echo $this->id; ?>_repeater_colector"<?php $this->link(); ?> class="customizer_repeater_colector" value="<?php  echo esc_textarea( json_encode( $this_default ) ); ?>" />
                    <?php
                } else {
                    $this->iterate_array(); ?>
                    <input type="hidden" id="customizer_<?php echo $this->id; ?>_repeater_colector" <?php $this->link(); ?> class="customizer_repeater_colector" />
                    <?php
                }
            } else {
                $this->iterate_array( $json ); ?>
                <input type="hidden" id="customizer_<?php echo $this->id; ?>_repeater_colector" <?php $this->link(); ?> class="customizer_repeater_colector" value="<?php echo esc_textarea( $this->value() ); ?>" />
                <?php
            } ?>
        </div>

        <button type="button"   class="button add_field customizer_general_control_new_field">
            <?php esc_html_e( 'Add new field' ); ?>
        </button>

        <?php
    }

    /**
     * Image input
     *
     * @param string $value Value of this input.
     * @param string $show Option to show or hide this.
     */
    private function image_control( $value = '', $show = '' ) {
        ?>
        <p class="customizer_image_control">
			<span class="customize-control-title">
				<?php esc_html_e( 'Image' )?>
			</span>
            <input type="text" class="widefat custom_media_url" value="<?php echo esc_attr( $value ); ?>">
            <input type="button" class="button button-primary custom_media_button_customizer" value="<?php esc_html_e( 'Upload Image' ); ?>" />
        </p>
        <?php
    }

    /**
     * Input control.
     *
     * @param array  $options Settings of this input.
     * @param string $value Value of this input.
     */
    private function input_control( $options, $value = '' ) {
        ?>
        <span class="customize-control-title"><?php echo $options['label']; ?></span>
        <?php
        if ( ! empty( $options['type'] ) && $options['type'] === 'textarea' ) {  ?>
            <textarea class="<?php echo esc_attr( $options['class'] ); ?>" placeholder="<?php echo $options['label']; ?>"><?php echo ( ! empty( $options['sanitize_callback'] ) ?  apply_filters( $options['sanitize_callback'] , $value ) : esc_attr( $value ) ); ?></textarea>
            <?php
        } else { ?>
            <input type="text" value="<?php echo ( ! empty( $options['sanitize_callback'] ) ?  apply_filters( $options['sanitize_callback'] , $value ) : esc_attr( $value ) ); ?>" class="<?php echo esc_attr( $options['class'] ); ?>" placeholder="<?php echo $options['label']; ?>"/>
            <?php
        }
    }



    /**
     * Iterate through repeater's content
     *
     * @param array $array Repeater's content.
     */
    private function iterate_array( $array = array() ) {
        $it = 0;
        if ( ! empty( $array ) ) {
            foreach ( $array as $i ) {  ?>
                <div class="customizer_general_control_repeater_container customizer_draggable">
                    <div class="customizer-customize-control-title">
                        <?php esc_html_e( $this->customizer_title, 'alps' )?>
                    </div>
                    <div class="customizer-box-content-hidden">
                        <?php
                        $choice = $image_url = $icon_value = $title = $subtitle = $text = $link = $shortcode = $repeater = '';

                        if ( ! empty( $i->image_url ) ) {
                            $image_url = $i->image_url;
                        }

                        if ( ! empty( $i->title ) ) {
                            $title = $i->title;
                        }

                        if ( ! empty( $i->subtitle ) ) {
                            $subtitle = $i->subtitle;
                        }

                        if ( ! empty( $i->text ) ) {
                            $text = $i->text;
                        }

                        if ( ! empty( $i->link ) ) {
                            $link = $i->link;
                        }

                        if ( ! empty( $i->shortcode ) ) {
                            $shortcode = $i->shortcode;
                        }


                        if ( $this->customizer_image_control == true ) {
                            $this->image_control( $image_url, $choice );
                        }

                        if ( $this->customizer_title_control == true ) {
                            $this->input_control(array(
                                'label' => __( 'Title' ),
                                'class' => 'customizer_title_control',
                            ), $title);
                        }

                        if ( $this->customizer_subtitle_control == true ) {
                            $this->input_control(array(
                                'label' => __( 'Subtitle' ),
                                'class' => 'customizer_subtitle_control',
                            ), $subtitle);
                        }

                        if ( $this->customizer_text_control == true ) {
                            $this->input_control(array(
                                'label' => __( 'Text' ),
                                'class' => 'customizer_text_control',
                                'type'  => 'textarea',
                            ), $text);
                        }

                        if ( $this->customizer_link_control ) {
                            $this->input_control(array(
                                'label' => __( 'Link' ),
                                'class' => 'customizer_link_control',
                                'sanitize_callback' => 'esc_url',
                            ), $link);
                        }

                        if ( $this->customizer_shortcode_control == true ) {
                            $this->input_control(array(
                                'label' => __( 'Link Name' ),
                                'class' => 'customizer_shortcode_control',
                            ), $shortcode);
                        }

                        ?>
                        <input type="hidden" class="customizer_box_id" value="<?php if ( ! empty( $i->id ) ) { echo esc_attr( $i->id );} ?>">
                        <button type="button" class="customizer_general_control_remove_field button" <?php if ( $it == 0 ) { echo 'style="display:none;"';} ?>><?php esc_html_e( 'Delete field' ); ?></button>
                    </div>
                </div>

                <?php
                $it++;
            }
        } else { ?>
            <div class="customizer_general_control_repeater_container">
                <div class="customizer-customize-control-title">Click Me</div>
                <div class="customizer-box-content-hidden">
                    <?php

                    if ( $this->customizer_image_control == true ) {
                        $this->image_control( '','customizer_icon' );
                    }

                    if ( $this->customizer_title_control == true ) {
                        $this->input_control( array(
                            'label' => __( 'Title', 'alps' ),
                            'class' => 'customizer_title_control',
                        ) );
                    }

                    if ( $this->customizer_subtitle_control == true ) {
                        $this->input_control( array(
                            'label' => __( 'Subtitle', 'alps' ),
                            'class' => 'customizer_subtitle_control',
                        ) );
                    }

                    if ( $this->customizer_text_control == true ) {
                        $this->input_control( array(
                            'label' => __( 'Text', 'alps' ),
                            'class' => 'customizer_text_control',
                            'type'  => 'textarea',
                        ) );
                    }

                    if ( $this->customizer_link_control == true ) {
                        $this->input_control( array(
                            'label' => __( 'Link', 'alps' ),
                            'class' => 'customizer_link_control',
                        ) );
                    }

                    if ( $this->customizer_shortcode_control == true ) {
                        $this->input_control( array(
                            'label' => __( 'Shortcode', 'alps' ),
                            'class' => 'customizer_shortcode_control',
                        ) );
                    }

                    ?>
                    <input type="hidden" class="customizer_box_id">
                    <button type="button" class="customizer_general_control_remove_field button"
                            style="display:none;"><?php esc_html_e( 'Delete field', 'alps' ); ?></button>
                </div>
            </div>
            <?php
        }// End if().
    }

    /**
     * Enqueue required scripts and styles.
     */
    public function enqueue() {
        wp_enqueue_script('sage/general-customizer-control.js', get_template_directory_uri() . '/assets/scripts/general-customizer-control.js', ['jquery', 'jquery-ui-draggable'], null, true);
        wp_enqueue_style('sage/general-customizer-control.css', get_template_directory_uri() . '/assets/styles/general-customizer-control.css', null);
        wp_enqueue_script('mediaelement');
    }


}
