<?php
/**
 * Created by PhpStorm.
 * User: HoangAnh
 * Date: 7/6/2017
 * Time: 4:10 PM
 */
require_once("{$CFG->libdir}/formslib.php");

class setting_form extends moodleform {
    public function definition() {
        $mform = $this->_form;
        $data = $this->_customdata;

        $mform->addElement('hidden', 'num', 0);
        $mform->setType('num', PARAM_INT);
        $mform->addElement('html', '<h3>' . get_string('subject', 'block_subject') . '</h3>');
        $mform->addElement('html', '<div class="mll-form">');

        $num = 1;

        if (!empty($data['subjects']) && is_array($data['subjects'])){
            foreach ($data['subjects'] as $subject){
                $arrayform = array();

                $arrayform[] = $mform->createElement('text', 'Subject[' . $subject->id . '][name]', '', array('disabled' => 'disabled'));
                $mform->setType('Subject[' . $subject->id . '][name]', PARAM_TEXT);
                $mform->setDefault('Subject[' . $subject->id . '][name]', $subject->name);
                $arrayform[] = $mform->createElement('button', 'change', get_string('change', 'block_subject'), array('class' => 'change-btn'));
                $mform->addGroup($arrayform, 'slotsubjectarr', get_string('subject', 'block_subject') . ' ' . $num, '', false );
                $num++;
            }
        }

        for ($i = 1; $i <= $data['num']; $i++){
            $arrayform = array();
            $arrayform[] = $mform->createElement('text', 'Subject[-' . $i . '][name]', '');
            $mform->setType('Subject[-' . $i . '][name]', PARAM_TEXT);
            $mform->addGroup($arrayform, 'slotsubjectarr', get_string('subject', 'block_subject') . ' ' . $num, '', false);
            $num++;
        }

        $mform->addElement('button', 'addslot', get_string('addsubject', 'block_subject'), array('data-num' => $data['num']));
        $mform->addElement('submit', 'submitbutton', get_string('save', 'block_subject'));
        $mform->addElement('html', '</div>');
        $mform->disable_form_change_checker();
    }
}