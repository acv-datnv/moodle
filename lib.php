<?php
/**
 * Created by PhpStorm.
 * User: HoangAnh
 * Date: 6/29/2017
 * Time: 9:02 AM
 */

function get_all_subjects($courseid) {
    global $DB;
    return $DB->get_records('subject_subjects', array('course_id' => $courseid));
}

function get_mark_by_user_and_subject($userid, $subjectid) {
    global $DB;
    $subjectmark = $DB->get_record('subject_marks', array('user_id' => $userid,'sub_id' => $subjectid));
    return $subjectmark ? $subjectmark->mark : 0;
}

function get_subjects_with_mark($courseid, $userid) {
    $subjects = get_all_subjects($courseid);
    if ($subjects) {
        foreach ($subjects as &$subject) {
            $subject->mark = get_mark_by_user_and_subject($userid, $subject->id);
        }
    }
    return $subjects;
}

function get_id_by_user_and_subject($userid, $subjectid){
    global $DB;
    $mark_id = $DB->get_record('subject_marks', array('user_id' => $userid, 'sub_id' => $subjectid));
    return $mark_id ? $mark_id->id : false;
}

function insert_mark($subject, $userid, $data){
    global $DB;
    $name = $subject->name;
    $obj = new stdClass();
    $obj->sub_id = $subject->id;
    $obj->user_id = $userid;
    $obj->mark = $data->$name;
    $obj->created_at = time();
    $obj->created_by = $userid;
    $obj->del_flag = 1;
    $DB->insert_record('subject_marks', $obj);
}

function update_data($subject, $userid, $data){
    global $DB;
    $mark_id = get_id_by_user_and_subject($userid, $subject->id);
    $name = $subject->name;
    $obj = new stdClass();
    $obj->id = $mark_id;
    $obj->mark = $data->$name;
    $obj->updated_at = time();
    $obj->modified_by = $userid;
    $DB->update_record('subject_marks', $obj);
}

