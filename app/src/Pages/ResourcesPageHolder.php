<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

    class ResourcesPageHolder extends Page
    {
        private static $icon_class = 'font-icon-p-book';

        private static $default_child = ResourcesPage::class;

        private static $allowed_children = [
            ResourcesPage::class
        ];

        private static $has_many = [
            'Tags' => FilterTag::class
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields(); // TODO: Change the autogenerated stub
            $gridConfig = GridFieldConfig_RecordEditor::create(999);
            if($this->Tags()->Count())
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
                'Tags',
                'Tags',
                $this->Tags(),
                $gridConfig
            );

            $fields->removeByName("Tags");
            $fields->addFieldToTab('Root.Tags', $gridField);
            return $fields;
        }

        public function getVisibleTags()
        {
            return $this->Tags()->filter('Archived', false)->sort('Sort');
        }
    }
}