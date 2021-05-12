<?php

namespace {

    use SilverStripe\AssetAdmin\Forms\UploadField;
    use SilverStripe\Assets\Image;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\Forms\ListboxField;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\View\ArrayData;

    class ImageWithText extends Section
    {
        private static $singular_name = 'Image with text';

        private static $db = [
            'Content' => 'HTMLText',
            'ContentPosition' => 'Varchar',
            'ContentContainer'=> 'Varchar',
            'ContentPaddings' => 'Varchar'
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
                    'container-fluid' => 'Container fluid',
                    'container'       => 'Fix-width',
                    'container-small' => 'Container small'
                )
            )->setDescription('<b>Fix-width</b> container (its max-width changes at each breakpoint)</br><b>Container fluid</b> for a full width container, spanning the entire width of the viewport.</br><b>Container small</b> (max-width fixed at 575px)'));
            $fields->addFieldToTab('Root.Main', ListboxField::create('ContentPaddings', 'Content Paddings',
                Padding::get()->map('Class', 'Name')));
        }

        public function getReadableContentPaddings()
        {
            $output = new ArrayList();
            $paddings = json_decode($this->ContentPaddings);
            if ($paddings) {
                foreach ($paddings as $padding) {
                    $output->push(
                        new ArrayData(array('Name' => $padding))
                    );
                }
            }
            return $output;
        }
    }
}
