<?php

function block_subject_get_all_subjects($courseid, $fields = '*') {
    global $DB;
    return $DB->get_records('subject_subjects', array('course_id' => $courseid), null, $fields);
}

function block_subject_get_mark_by_user_and_subject($userid, $subjectid) {
    global $DB;
    $subjectmark = $DB->get_record('subject_marks', array('user_id' => $userid,'sub_id' => $subjectid));
    return $subjectmark ? $subjectmark->mark : 0;
}

function block_subject_get_subjects_with_mark($courseid, $userid) {
    $subjects = block_subject_get_all_subjects($courseid);
    if ($subjects) {
        foreach ($subjects as &$subject) {
            $subject->mark = block_subject_get_mark_by_user_and_subject($userid, $subject->id);
        }
    }
    return $subjects;
}

function block_subject_get_recordid_by_user_and_subject($userid, $subjectid){
    global $DB;
    $mark_id = $DB->get_record('subject_marks', array('user_id' => $userid, 'sub_id' => $subjectid));
    return $mark_id ? $mark_id->id : false;
}

function block_subject_get_all_userids(){
    global $DB;
    return $DB->get_records_sql('SELECT DISTINCT `user_id` FROM {subject_marks}');
}

function block_subject_insert_mark_to_database($subject, $userid, $data){
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

function block_subject_update_mark_to_database($subject, $userid, $data){
    global $DB;
    $mark_id = block_subject_get_recordid_by_user_and_subject($userid, $subject->id);
    $name = $subject->name;
    $obj = new stdClass();
    $obj->id = $mark_id;
    $obj->mark = $data->$name;
    $obj->updated_at = time();
    $obj->modified_by = $userid;
    $DB->update_record('subject_marks', $obj);
}

function block_subject_get_all_marks_by_userid($userid) {
    global $DB;
    return $DB->get_records('subject_mark', array('user_id' => $userid));
}

function get_user_info_by_id($userid){
    global $DB;
    return $DB->get_record('user', array('id' => $userid));
}

function block_subject_create_marks_overview_table($subjects, $userids){
    $table_html  = html_writer::tag('h2', 'Overview', array('style' => 'text-align: center'));
    $table_html .= html_writer::start_tag('table', array('class' => 'table table-hover table-bordered'));
    $table_html .= html_writer::start_tag('thead');
    $table_html .= html_writer::tag('th', 'Student');
    foreach ($subjects as $subject){
        $table_html .= html_writer::tag('th', ucfirst($subject->name));
    }
    $table_html .= html_writer::end_tag('thead');

    $table_html .= html_writer::start_tag('tbody');
    foreach ($userids as $userid) {
        $id = (int)$userid->user_id;
        $user = get_user_info_by_id($id);
        $fullname = fullname($user);
        $table_html .= html_writer::start_tag('tr');
        $table_html .= html_writer::tag('td', $fullname);
        foreach ($subjects as $subject){
            $mark = block_subject_get_mark_by_user_and_subject($id, $subject->id);
            $table_html.= html_writer::tag('td', $mark);
        }
        $table_html .= html_writer::end_tag('tr');
    }
    $table_html .= html_writer::end_tag('tbody');
    $table_html .= html_writer::end_tag('table');
    return $table_html;
}

function block_subject_update_subject_name($id, $name){
    global $DB, $USER;

    $obj = new stdClass();
    $obj->id = $id;
    $obj->name = $name;
    $obj->updated_at = time();
    $obj->modified_by = $USER->id;
    $DB->update_record('subject_subjects', $obj);
}

function block_subject_delete_subject($id){
    global $DB;
    $DB->delete_records('subject_subjects',array('id' => $id));
    $DB->delete_records('subject_marks',array('sub_id' => $id));
}

function block_subject_insert_subject($courseid, $name){
    global  $DB, $USER;

    $obj = new stdClass();
    $obj->course_id = $courseid;
    $obj->name = $name;
    $obj->created_at = time();
    $obj->created_by = $USER->id;
    $obj->del_flag = 1;
    $DB->insert_record('subject_subjects', $obj);
}





