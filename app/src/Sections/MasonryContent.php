<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

    class MasonryContent extends Section
    {
        private static $singular_name = 'Masonry Content';

        private static $db = [
        ];

        private static $has_many = [
            'MasonryItems' => MasonryItem::class
        ];

        public function getSectionCMSFields(FieldList $fields)
        {
            $gridConfig = GridFieldConfig_RecordEditor::create(999);
            if($this->MasonryItems()->Count())
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
                'MasonryItems',
                'Masonry Items',
                $this->MasonryItems(),
                $gridConfig
            );

            $fields->removeByName("MasonryItems");
            $fields->addFieldToTab('Root.Main', $gridField);
        }

        public function getVisibleMasonryItems()
        {
            return $this->MasonryItems()->filter('Archived', false)->sort('Sort');
        }
    }
}
