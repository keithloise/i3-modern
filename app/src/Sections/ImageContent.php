<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\FieldList;

    class ImageContent extends Section
    {
        private static $singular_name = 'Image Content';

        private static $db = [

        ];

        private static $has_one = [
            'Image' => Image::class
        ];

        private static $owns = [
            'Image'
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $fields->addFieldToTab('Root.Main', UploadField::create('Image', 'Image content')
                ->setFolderName('Sections/ImageContent'));
        }
    }
}
