<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

    class ImageBanner extends Section
    {
        private static $singular_name = 'Image Banner';

        private static $db = [
            'Content'         => 'HTMLText',
            'ContentPosition' => 'Varchar',
            'BannerHeight'    => 'Varchar',
            'ShowScrollIcon'  => 'Boolean',
        ];

        private static $has_one = [
            'Banner' => Image::class
        ];

        private static $owns = [
            'Banner'
        ];

        private static $defaults = [
            'BannerHeight' => 'large'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', UploadField::create('Banner', 'Banner image')
                ->setFolderName('Sections/Image_Banner/Images'));
            $fields->addFieldToTab('Root.Main', DropdownField::create('BannerHeight', 'Banner height',
                array(
                    'bh-small' => 'Small',
                    'bh-medium'=> 'Medium',
                    'bh-large' => 'Large'
                )
            ));
            $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
            $fields->addFieldToTab('Root.Main', DropdownField::create('ContentPosition', 'Content position',
                array(
                    'cp-left'   => 'Left',
                    'cp-center' => 'Center',
                    'cp-right'  => 'Right'
                )
            ));
            $fields->addFieldToTab('Root.Main', CheckboxField::create('ScrollIcon', 'Show scroll icon'));
        }
    }
}
