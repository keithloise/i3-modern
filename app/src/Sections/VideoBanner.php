<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\File;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

    class VideoBanner extends Section
    {
        private static $singular_name = 'Video Banner';

        private static $db = [
            'Content'         => 'HTMLText',
            'ContentPosition' => 'Varchar'
        ];

        private static $has_one = [
            'Video' => File::class
        ];

        private static $owns = [
            'Video'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', UploadField::create('Video', 'Banner video')
                ->setFolderName('Sections/Section_VideoBanner/Videos'));
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ContentPosition', 'Content position',
                array(
                    'left-content'   => 'Left',
                    'center-content' => 'Center',
                    'right-content'  => 'Right'
                )
            ));
        }
    }
}
