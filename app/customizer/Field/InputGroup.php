<?php

namespace App\Customizer\Field;

use IBX\Customizer\Interfaces\IField;
use IBX\Customizer\BaseField;

use App\Customizer\Control\GeneralCustomizeControl;

class InputGroup extends BaseField implements IField {
    public $id;
    public $section;
    public $setting_id;
    public $control_id;
    public $description = '';
    private $label;
    private $type = 'input-group';

    public $customizer_image_control = false;
    public $customizer_title_control = false;
    public $customizer_subtitle_control = false;
    public $customizer_text_control = false;
    public $customizer_link_control = false;
    public $customizer_shortcode_control = false;

    public function __construct($s, $i, $l, $args = []) {
        $this->id = $i;
        $this->label = $l;
        $this->section = $s;
        $this->setSettingID();
        $this->setControlID();
        $this->args = $args;
    }

    public function setImageControl() {
        $this->customizer_image_control = true;
    }

    public function setTextControl() {
        $this->customizer_text_control = true;
    }

    public function setTitleControl() {
        $this->customizer_title_control = true;
    }

    public function setLinkControl() {
        $this->customizer_link_control = true;
    }

    public function setShortcodeControl() {
        $this->customizer_shortcode_control = true;
    }

    public function setSubtitleControl() {
        $this->customizer_shortcode_control = true;
    }

    public function getControl() {

        if($this->section->devMode()) {
            $this->showVars();
        }


        return new GeneralCustomizeControl(
            $this->section->getWPCustomize(),
            $this->getControlID(),
            'Input Group',
            [
                'label'                        => $this->label,
                'section'                      => $this->section->getSectionID(),
                'settings'                     => $this->getSettingID(),
                'customizer_title_control'     => $this->customizer_title_control,
                'customizer_subtitle_control'  => $this->customizer_subtitle_control,
                'customizer_link_control'      => $this->customizer_link_control,
                'customizer_text_control'      => $this->customizer_text_control,
                'customizer_shortcode_control' => $this->customizer_shortcode_control,
                'customizer_image_control'     => $this->customizer_image_control
            ]
        );
    }

}
