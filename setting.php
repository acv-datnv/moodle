<?php

require_once('../../config.php');
require_once(__DIR__.'/setting_form.php');

$PAGE->set_url('/mod/assign/index.php', array('id' => $id));
$PAGE->set_pagelayout('incourse');
$PAGE->set_heading(get_string('setting', 'block_subject'));
$PAGE->requires->css('/blocks/subject/style.css');
$PAGE->requires->jquery();
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/blocks/subject/script.js'),'true');
echo $OUTPUT->header();

$user = $USER->id;
$blockid = $_GET['blockid'];
$courseid = required_param('courseid', PARAM_INT);

$action = $CFG->wwwroot . '/blocks/subject/setting.php?blockid=' .$blockid. '&courseid=' .$_GET['courseid'];

$date = new DateTime();

$data = array($blockid,$courseid);

$mform = new setting_form($action, $data);
//Form processing and displaying is done here
if ($mform->is_cancelled()) {
    //Handle form cancel operation, if cancel button is present on form
//    $mform->display();
} else if ($fromform = $mform->get_data()) {
    //In this case you process validated data. $mform->get_data() returns data posted in form.

    $re = required_param('txtAdd', PARAM_TEXT);

    echo "<pre>";
    var_dump($fromform);
    echo "</pre>";

//    global $DB;
//    $obj = new stdClass();
//    $obj->name = $re;
//    $obj->course_id = $courseid;
//    $obj->created_at = $date->getTimestamp();
//    $obj->created_by = $user;
//    $obj->modified_at = $date->getTimestamp();
//    $obj->modified_by = $user;
//    $obj->del_flag = 0;
//
//    $result = $DB->insert_record('subject_subjects',$obj,true);
//    if($result){
//        echo 'Inserted';
//    } else{
//        echo 'Insert failed';
//    }
} else {
    // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
    // or on the first display of the form.

    //Set default data (if any)
    $mform->set_data($toform);
    //displays the form
    $mform->display();
}

echo $OUTPUT->footer();