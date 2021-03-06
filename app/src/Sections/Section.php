<?php

namespace {

    use TractorCow\Colorpicker\Color;
    use TractorCow\Colorpicker\Forms\ColorField;
    use SilverStripe\Core\ClassInfo;
    use SilverStripe\Forms\CheckboxField;
    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Forms\FieldList;
    use SilverStripe\Forms\HiddenField;
    use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
    use SilverStripe\Forms\ListboxField;
    use SilverStripe\Forms\Tab;
    use SilverStripe\Forms\TabSet;
    use SilverStripe\Forms\TextField;
    use SilverStripe\ORM\ArrayList;
    use SilverStripe\ORM\DataObject;
    use SilverStripe\View\ArrayData;
    use SwiftDevLabs\CodeEditorField\Forms\CodeEditorField;

    class Section extends DataObject
    {
        private static $default_sort = 'Sort';
        private static $singular_name = 'Content Section';

        private static $db = [
            'Name'    => 'Text',
            'Content' => 'HTMLText',
            'Type'    => 'Varchar',
            'Width'   => 'Varchar',
            'Container'  => 'Varchar',
            'Paddings'   => 'Text',
            'BgColor'    => Color::class,
            'CodeEditor' => 'HTMLText',
            'Archived'   => 'Boolean',
            'EnableNav'  => 'Boolean',
            'Sort'       => 'Int'
        ];

        private static $has_one = [
            'Page' => Page::class,
        ];

        private static $owns = [

        ];

        private static $summary_fields = [
            'Name',
            'Width',
            'DisplaySectionType' => 'Section Type',
            'Status'
        ];

        private function getSectionTypes()
        {
            $sectionTypes = array();
            $classes = ClassInfo::getValidSubClasses('Section');
            foreach ($classes as $type) {
                $instance = self::singleton($type);
                $sectionTypes[$instance->ClassName] = $instance->singular_name();
            }
            return $sectionTypes;
        }

        public function getDisplaySectionType()
        {
            return self::singleton($this->Type)->singular_name();
        }

        public function getDisplaySectionTypeTrim()
        {
            return str_replace(' ','', self::singleton($this->Type)->singular_name());
        }

        public function getReadablePaddings()
        {
            $output = new ArrayList();
            $paddings = json_decode($this->Paddings);
            if ($paddings) {
                foreach ($paddings as $padding) {
                    $output->push(
                        new ArrayData(array('Name' => $padding))
                    );
                }
            }
            return $output;
        }

        public function getCMSFields()
        {
            $fields = new FieldList();
            $fields->push(TabSet::create('Root', $mainTab = Tab::create('Main')));

            if ($this->Type) {
                $fields->addFieldToTab('Root.Main',
                    $rot =  TextField::create('ROType', 'Section type',
                        self::singleton($this->Type)->singular_name()));
                $rot->setDisabled(true);
            } else {
                $fields->addFieldToTab('Root.Main', DropdownField::create("Type", "Section type",
                    $this->getSectionTypes() , $this->ClassName));
            }

            $fields->addFieldToTab('Root.Main', TextField::create('Name', ' Section name'));

            if ($this->Type == 'Section') {
                $fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content'));
            }

            $instance = self::singleton($this->Type);
            $instance->ID = $this->ID;
            $instance->getSectionCMSFields($fields);

            $fields->addFieldToTab('Root.Main', CheckboxField::create('EnableNav', 'Add to scroll navigation'));
            $fields->addFieldToTab('Root.Settings', DropdownField::create('Width', 'Section width',
                SectionWidth::get()->filter('Archived', false)->map('Class', 'Name')));
            $fields->addFieldToTab('Root.Settings', DropdownField::create('Container', 'Section container',
                array(
                    'container p-0'       => 'Fix-width',
                    'container-fluid p-0' => 'Container fluid',
                    'container-small p-0' => 'Container small'
                )
            )->setDescription('<b>Fix-width</b> container (its max-width changes at each breakpoint)</br><b>Container fluid</b> for a full width container, spanning the entire width of the viewport.</br><b>Container small</b> (max-width fixed at 575px)'));
            $fields->addFieldToTab('Root.Settings', ListboxField::create('Paddings', 'Section Paddings',
                Padding::get()->map('Class', 'Name')));
            $fields->addFieldToTab('Root.Settings', ColorField::create('BgColor', ' Section background color'));
            $fields->addFieldToTab('Root.CodeEditor', CodeEditorField::create('CodeEditor'));
            $fields->addFieldToTab('Root.Main', CheckboxField::create('Archived'));
            $fields->addFieldToTab('Root.Main', HiddenField::create('Sort'));

            return $fields;
        }

        public function getSectionCMSFields(FieldList $fields)
        {
            return  $fields;
        }

        public function onBeforeWrite()
        {
            parent::onBeforeWrite(); // TODO: Change the autogenerated stub
            $this->ClassName = $this->Type;
            if($this->Name == ''){
                $this->Name = $this->Type;
            }
        }

        public function Show()
        {
            return $this->renderWith('Layout/Sections/' . $this->ClassName);
        }

        public function getStatus()
        {
            if($this->Archived == 1) return _t('GridField.Archived', 'Archived');
            return _t('GridField.Live', 'Live');
        }

    }
}
