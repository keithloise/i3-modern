<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\File;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use SilverStripe\ORM\DataExtension;
    use TractorCow\SliderField\SliderField;

    class SiteConfigExtension extends DataExtension
    {
        private static $db = [
            'LogoSize' => 'Int',
            'LogoPos'  => 'Varchar'
        ];

        private static $has_one = [
            'Logo' => File::class
        ];

        private static $owns = [
            'Logo'
        ];

        public function updateCMSFields(FieldList $fields)
        {
            $fields->findOrMakeTab(
                'Root.Logos/Icons',
                _t(__CLASS__ . '.LogosIconsTab', 'Logos/Icons')
            );

            $fields->addFieldToTab('Root.Logos/Icons', UploadField::create('Logo')
                ->setFolderName('SiteLogo'));
            $fields->addFieldToTab('Root.Logos/Icons', SliderField::create('LogoSize', 'Logo size', 100, 300));
            $fields->addFieldToTab('Root.Logos/Icons', DropdownField::create('LogoPos', 'Logo position',
                array(
                    'lp-left'  => 'Left',
                    'lp-center'=> 'Center',
                    'lp-right' => 'Right'
                )
            ));

            //Section
            $configWidth = GridFieldConfig_RecordEditor::create('999');
            $editorWidth = GridField::create('SectionWidth', 'Width', SectionWidth::get(), $configWidth);
            $fields->addFieldToTab('Root.Sections', $editorWidth);

            //Padding
            $configPadding = GridFieldConfig_RecordEditor::create('999');
            $editorPadding = GridField::create('Padding', 'Padding', Padding::get(), $configPadding);
            $fields->addFieldToTab('Root.Sections', $editorPadding);

            //Animation
            $configAnimation = GridFieldConfig_RecordEditor::create('999');
            $editorAnimation = GridField::create('Animation', 'Animation', Animation::get(), $configAnimation);
            $fields->addFieldToTab('Root.Sections', $editorAnimation);

            //Footer
            $configFooter = GridFieldConfig_RecordEditor::create('999');
            $editorFooter = GridField::create('Footer', 'Footer', Footer::get(), $configFooter);
            $fields->addFieldToTab('Root.Footer', $editorFooter);
        }
    }
}
