<?php

namespace {

    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\HiddenField;
    use SilverStripe\Forms\TextField;
    use SilverStripe\ORM\DataObject;

    class Padding extends DataObject
    {
        private static $default_sort = 'Sort ASC';

        private static $db = [
            'Name'     => 'Varchar',
            'Class'    => 'Varchar',
            'Archived' => 'Boolean',
            'Sort'     => 'Int',
        ];

        private static $summary_fields = [
            'Name',
            'Class',
            'Status'
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields(); // TODO: Change the autogenerated stub
            $fields->addFieldToTab('Root.Main', TextField::create('Name', 'Padding name'));
            $fields->addFieldToTab('Root.Main', TextField::create('Class', 'Class name')
                ->setDescription('E.g. pl-lg-5 (padding left - responsive breakpoint(Large) - size). Please see&nbsp;<a href="https://getbootstrap.com/docs/4.0/utilities/spacing/" target="_blank" rel="noreferrer nofollow">Bootstrap spacing</a>&nbsp;for more references.'));
            $fields->addFieldToTab('Root.Main', CheckboxField::create('Archived'));
            $fields->addFieldToTab('Root.Main', HiddenField::create('Sort'));

            return $fields;
        }

        public function getStatus()
        {
            if($this->Archived == 1) return _t('GridField.Archived', 'Archived');
            return _t('GridField.Live', 'Live');
        }
    }
}
