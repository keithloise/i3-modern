<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\GridField\GridField;
    use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
    use SilverStripe\Forms\HiddenField;
    use SilverStripe\Forms\ReadonlyField;
    use SilverStripe\Forms\TextField;
    use SilverStripe\ORM\DataObject;
    use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
    use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

    class FilterTag extends DataObject
    {
        private static $default_sort = 'Sort ASC';

        private static $db = [
            'Name'     => 'Varchar',
            'Archived' => 'Boolean',
            'Sort'     => 'Int'
        ];

        private static $has_one = [
            'Parent' => ResourcesPageHolder::class
        ];

        private static $has_many = [
            'TagItems' => FilterTagItem::class
        ];

        private static $summary_fields = [
            'Name',
            'Status',
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields(); // TODO: Change the autogenerated stub
            $fields->removeByName('ParentID');
            $fields->addFieldToTab('Root.Main', ReadonlyField::create('ParentRO', 'Parent', $this->Parent()->Title));
            $fields->addFieldToTab('Root.Main', TextField::create('Name', 'Tag name'));
            $gridConfig = GridFieldConfig_RecordEditor::create(999);
            if($this->TagItems()->Count())
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
                'TagItems',
                'Tag Items',
                $this->TagItems(),
                $gridConfig
            );

            $fields->removeByName("TagItems");
            $fields->addFieldToTab('Root.Main', $gridField);

            $fields->addFieldToTab('Root.Main', CheckboxField::create('Archived'));
            $fields->addFieldToTab('Root.Main', HiddenField::create('Sort'));

            return $fields;
        }

        public function getStatus()
        {
            if($this->Archived == 1) return _t('GridField.Archived', 'Archived');
            return _t('GridField.Live', 'Live');
        }

        public function getVisibleTagItems()
        {
            return $this->TagItems()->filter('Archived', false)->sort('Sort');
        }
    }
}
