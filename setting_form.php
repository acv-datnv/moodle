<?php

require_once $CFG->libdir. '/formslib.php';

class setting_form extends moodleform {

    //convert name
    private function stripUnicode($str){
        if(!$str) return false;
        $unicode = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
        );
        foreach($unicode as $nonUnicode=>$uni) $str = preg_replace("/($uni)/i",$nonUnicode,$str);
        return $str;
    }

    //Add elements to form
    public function definition() {
        global $DB;
        $result = $DB->get_records('subject_subjects');

        $mform = $this->_form; // Don't forget the underscore!
        $data = $this->_customdata;

        $count = 0;
        foreach ($result as $rs) {
            $count++;
            $name = $this->stripUnicode($rs->name);
            $mform->addElement('text', 'txt'.$name, 'Subject '.$count);
            $mform->setType('txt'.$name, PARAM_NOTAGS);
            $mform->setDefault('txt'.$name, $rs->name);
        }

        $mform->addElement('hidden', 'txtBlockId', $data[0]);
        $mform->addElement('hidden', 'txtCourseId', $data[1]);

        $mform->addElement('button', 'add', get_string('setting_button_add', 'block_subject'));
        $this->add_action_buttons();
    }

    //Custom validation should be added here
    function validation($data, $files) {
        return array();
    }

}