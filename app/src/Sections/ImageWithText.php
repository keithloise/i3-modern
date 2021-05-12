<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

    class ImageWithText extends Section
    {
        private static $singular_name = 'Image with text';

        private static $db = [
            'Content' => 'HTMLText',
            'ContentPosition' => 'Varchar',
            'ContentContainer'=> 'Varchar'
        ];

        private static $has_one = [
            'Image' => Image::class
        ];

        private static $owns = [
            'Image'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', UploadField::create('Image')
                ->setFolderName('Sections/ImageWithText'));
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ContentPosition', 'Content position',
                array(
                    'cp-top'    => 'Top',
                    'cp-right'  => 'Right',
                    'cp-bottom' => 'Bottom',
                    'cp-left'   => 'Left',
                )
            ));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ContentContainer', 'Content container',
                array(
                    'container-fluid p-0' => 'Container fluid',
                    'container p-0'       => 'Fix-width',
                    'container-small p-0' => 'Container small'
                )
            )->setDescription('<b>Fix-width</b> container (its max-width changes at each breakpoint)</br><b>Container fluid</b> for a full width container, spanning the entire width of the viewport.</br><b>Container small</b> (max-width fixed at 575px)'));
        }
    }
}
