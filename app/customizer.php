<?php

use IBX\Customizer\Fields\Image;
use IBX\Customizer\Fields\Text;
use IBX\Customizer\Fields\Upload;
use IBX\Customizer\Interfaces\ICustomizer;
use IBX\Customizer\Section;

use App\Customizer\Field\InputGroup;

class ThemeCustomizer implements ICustomizer
{
    public static function register($wp_customize)
    {
        $section = new Section($wp_customize);
        $section->setID('theme_header');
        $section->setPrio('1');
        $section->setTitle('Theme: Header Options');
        $section->setDesc('Modify header options');
        $section->addField(new Upload($section, 'upload', 'Upload'));
        $section->addField(new Text($section, 'address', 'Address'));
        $section->addField(new Text($section, 'phone', 'Phone Number'));
        $section->addField(new InputGroup(
                $section,
                'repeatable',
                'Repeatable'
        ));
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
