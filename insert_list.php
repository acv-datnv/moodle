<?php
/**
 * Created by PhpStorm.
 * User: HoangAnh
 * Date: 7/3/2017
 * Time: 2:53 PM
 */

require_once('../../config.php');
global $USER;
$result = $DB->get_records("subject_subjects", array('course_id' => $courseid)); // get all records in mdl_subject_subjects table
$userMark = $DB->get_records_sql("SELECT * FROM {subject_marks} WHERE user_id = $USER->id");

$records = array();
foreach ($result as $value){
    $obj = new stdClass();
    $name = $value->name;
    $obj->sub_id = $value->id;
    $obj->user_id = $USER->id;
    $obj->created_by = $USER->id;
    $obj->mark = $_POST["$name"];
    $obj->created_at = time();
    $obj->del_flag = 1;
    $records[] = $obj;
}

if (empty($userMark)){
    $mark_record = $DB->insert_records('subject_marks', $records);

}else{
    foreach ($result as $value){
        $mark_id = $DB->get_field_sql("SELECT `id` FROM {subject_marks} WHERE sub_id = $value->id AND user_id = $USER->id");

        $obj = null;
        $name = $value->name;
        $obj = new stdClass();
        $obj->id = $mark_id;
        $obj->mark = (int)$_POST["$name"];
        $mark_update = $DB->update_record('subject_marks', $obj);
    }
}



//echo '<pre>';
//print_r($_POST);
//print_r($result);
//echo $USER->id;
//echo '</pre>';




