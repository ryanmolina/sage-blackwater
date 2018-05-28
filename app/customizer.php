<?php

use IBX\Customizer\Fields\Image;
use IBX\Customizer\Fields\Text;
use IBX\Customizer\Fields\Upload;
use IBX\Customizer\Fields\Textarea;
use IBX\Customizer\Interfaces\ICustomizer;
use IBX\Customizer\Section;

use App\Customizer\Field\InputGroup;

class ThemeCustomizer implements ICustomizer
{
    public static function register($wp_customize)
    {
        ThemeCustomizer::header_section($wp_customize);
        ThemeCustomizer::front_page_section($wp_customize);
        ThemeCustomizer::footer_section($wp_customize);
    }

    private static function header_section($wp_customize)
    {
        $section = new Section($wp_customize);
        $section->setID('theme_header');
        $section->setPrio('1');
        $section->setTitle('Theme: Header Options');
        $section->setDesc('Modify header options');
        $section->addField(new Image($section, 'image', 'Image'));
        $section->addField(new Text($section, 'address', 'Address'));
        $section->addField(new Text($section, 'phone', 'Phone Number'));

        $input_group = new InputGroup($section, 'social-icons', 'Social Icons');
        $input_group->setLinkControl();
        $input_group->setImageControl();

        $section->addField($input_group);
        $section->display();
    }

    private static function front_page_section($wp_customize)
    {
        $section = new Section($wp_customize);
        $section->setID('theme_front_page');
        $section->setPrio('2');
        $section->setTitle('Theme: Front-Page Options');
        $section->setDesc('Modify Front-Page Options');
        $section->addField(new Text($section, 'intro-header', 'Intro Header'));
        $section->addField(new Textarea($section, 'intro-text', 'Intro Text'));
        $input_group = new InputGroup($section, 'carousel-items', 'Carousel Items');
        $input_group->setImageControl();

        $section->addField($input_group);
        $section->display();
    }

    private static function footer_section($wp_customize)
    {
        $section = new Section($wp_customize);
        $section->setID('theme_footer');
        $section->setPrio('3');
        $section->setTitle('Theme: Footer Options');
        $section->setDesc('Modify Footer Options');

        $input_group = new InputGroup($section, 'social-icons', 'Social Icons');
        $input_group->setLinkControl();
        $input_group->setImageControl();
        $section->addField($input_group);
        $section->display();
    }

    public static function header_output()
    {

    }

    public static function live_preview()
    {

    }
}

add_action('customize_register', ['ThemeCustomizer', 'register']);
