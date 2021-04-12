<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use SilverStripe\ORM\DataObject;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

    class AnimatedSlideshow extends DataObject
    {
        private static $singular_name = 'Animated Slideshow';

        private static $has_many = [
            'SlideshowImages' => SlideshowImage::class
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $gridConfig = GridFieldConfig_RecordEditor::create(999);
            if($this->SlideshowImages()->Count())
            {
                $gridConfig->addComponent(new GridFieldOrderableRows());
            }
            $gridConfig->addComponent(new GridFieldEditableColumns());
            $gridColumns = $gridConfig->getComponentByType(GridFieldEditableColumns::class);
            $gridColumns->setDisplayFields([
                'Archived' => [
                    'title' => 'Archive',
                    'callback' => function($record, $column, $grid) {
                        return CheckboxField::create($column);
                    }]
            ]);

            $gridField = GridField::create(
                'SlideshowImages',
                'Images',
                $this->SlideshowImages(),
                $gridConfig
            );

            $fields->removeByName("SlideshowImages");
            $fields->addFieldToTab('Root.Main', $gridField);
        }

        public function getVisibleSlideshowItems()
        {
            return $this->SlideshowImages()->filter('Archived', false)->sort('Sort');
        }
    }
}
