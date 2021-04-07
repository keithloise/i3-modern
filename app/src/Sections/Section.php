<?php

namespace {

    use SilverStripe\ORM\DataObject;

    class Section extends DataObject
    {
        private static $default_sort = 'Sort';
        private static $singular_name = 'Content Section';

        private static $db = [
            'Name'    => 'Text',
            'Type'    => 'Varchar',
            'Archive' => 'Boolean',
            'Sort'    => 'Int'
        ];

        private static $has_one = [
            'Page' => Page::class,
        ];

        private static $owns = [

        ];

        private static $summary_fields = [
            'Name',
            'Status'
        ];

        private function getSectionTypes()
        {

        }
    }
}
