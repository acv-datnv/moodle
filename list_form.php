<?php
require_once("{$CFG->libdir}/formslib.php");
require_once 'HTML/QuickForm.php';

class list_form extends moodleform {
    //Add elements to form
    public function definition()
    {
        $mform = $this->_form; // Don't forget the underscore!
        $data = $this->_customdata;
        if (isset($data['subjects']) && !empty($data['subjects']) && is_array($data['subjects'])) {
            foreach ($data['subjects'] as $subject) {
                $mform->addElement('text', $subject->name, ucfirst($subject->name));
                $mform->setType($subject->name, PARAM_INT);
                $mform->setDefault($subject->name, $subject->mark);
                $mform->addRule($subject->name, get_string('error_validate', 'block_subject') , 'rangelength', array(0, 10), true);
                $mform->addRule($subject->name, get_string('error_validate', 'block_subject') , 'required', null, true);
                $mform->addRule($subject->name, get_string('error_validate', 'block_subject') , 'numeric', null, true);
            }
        }
        $this->add_action_buttons();
    }
}