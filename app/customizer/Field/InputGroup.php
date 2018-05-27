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
    private $type = 'text';
    private $args;

    public function __construct($s, $i, $l, $args = []) {
        $this->id = $i;
        $this->label = $l;
        $this->section = $s;
        $this->setSettingID();
        $this->setControlID();
        $this->args = $args;
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
                'customizer_icon_control'      => true,
                'customizer_title_control'     => true,
                'customizer_subtitle_control'  => true,
                'customizer_link_control'      => true,
                'customizer_text_control'      => true,
                'customizer_shortcode_control' => true,

            ]
        );
    }

}
