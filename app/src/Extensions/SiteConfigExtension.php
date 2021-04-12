<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\File;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use SilverStripe\ORM\DataExtension;

    class SiteConfigExtension extends DataExtension
    {
        private static $db = [

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
                ->setFolderName('Logo'));

            //Section
            $configWidth = GridFieldConfig_RecordEditor::create('999');
            $editorWidth = GridField::create('SectionWidth', 'Width', SectionWidth::get(), $configWidth);
            $fields->addFieldToTab('Root.Sections', $editorWidth);

            //Animation
            $configAnimation = GridFieldConfig_RecordEditor::create('999');
            $editorAnimation = GridField::create('Animation', 'Animation', Animation::get(), $configAnimation);
            $fields->addFieldToTab('Root.Section', $editorAnimation);

            //Footer
            $configFooter = GridFieldConfig_RecordEditor::create('999');
            $editorFooter = GridField::create('Footer', 'Footer', Footer::get(), $configFooter);
            $fields->addFieldToTab('Root.Footer', $editorFooter);
        }
    }
}
