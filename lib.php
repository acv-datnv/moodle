<?php

function block_subject_get_all_subjects($courseid, $fields = '*') {
    global $DB;

    return $DB->get_records('subject_subjects', array('course_id' => $courseid, 'del_flag' => 0), null, $fields);
}

function block_subject_get_mark_by_user_and_subject($userid, $subjectid) {
    global $DB;

    $subjectmark = $DB->get_field('subject_marks', 'mark', array('user_id' => $userid,'sub_id' => $subjectid, 'del_flag' => 0));
    return ($subjectmark) ? $subjectmark : 0;
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

function block_subject_get_mark_id_by_user_and_subject($userid, $subjectid){
    global $DB;

    return $DB->get_field('subject_marks', 'id', array('user_id' => $userid, 'sub_id' => $subjectid, 'del_flag' => 0));
}

function block_subject_get_all_user_ids_marked () {
    global $DB;

    return $DB->get_fieldset_select('subject_marks', 'DISTINCT user_id', 'del_flag = ?', array(0));
}

function block_subject_insert_mark_($subject, $userid, $data){
    global $DB;

    $name = $subject->name;
    $obj = new stdClass();
    $obj->sub_id = $subject->id;
    $obj->user_id = $userid;
    $obj->mark = $data->$name;
    $obj->created_at = time();
    $obj->created_by = $userid;
    return $DB->insert_record('subject_marks', $obj);
}

function block_subject_update_mark($subject, $userid, $data){
    global $DB;

    $mark_id = block_subject_get_mark_id_by_user_and_subject($userid, $subject->id);
    if ($mark_id) {
        $name = $subject->name;
        $obj = new stdClass();
        $obj->id = $mark_id;
        $obj->mark = $data->$name;
        $obj->updated_at = time();
        $obj->modified_by = $userid;
        return $DB->update_record('subject_marks', $obj);
    }
    return false;
}

function block_subject_get_all_marks_by_userid($userid) {
    global $DB;

    return $DB->get_records('subject_mark', array('user_id' => $userid, 'del_flag' => 0));
}

function get_user_info_by_id($userid){
    global $DB;

    return $DB->get_record('user', array('id' => $userid, 'deleted' => 0));
}

function block_subject_create_marks_overview_table($subjects, $userids){
    $tablehtml  = html_writer::tag('h2', 'Overview', array('style' => 'text-align: center'));
    $tablehtml .= html_writer::start_tag('table', array('class' => 'table table-hover table-bordered'));
    $tablehtml .= html_writer::start_tag('thead');
    $tablehtml .= html_writer::tag('th', 'Student');
    foreach ($subjects as $subject){
        $tablehtml .= html_writer::tag('th', ucfirst($subject->name));
    }
    $tablehtml .= html_writer::end_tag('thead');

    $tablehtml .= html_writer::start_tag('tbody');
    foreach ($userids as $userid) {
        $id = (int)$userid;
        $user = get_user_info_by_id($id);
        if (!empty($user)) {
            $tablehtml .= html_writer::start_tag('tr');
            $tablehtml .= html_writer::tag('td', fullname($user));
            foreach ($subjects as $subject){
                $mark = block_subject_get_mark_by_user_and_subject($id, $subject->id);
                $tablehtml.= html_writer::tag('td', $mark);
            }
            $tablehtml .= html_writer::end_tag('tr');
        }
    }
    $tablehtml .= html_writer::end_tag('tbody');
    $tablehtml .= html_writer::end_tag('table');

    return $tablehtml;
}

function block_subject_update_subject_name($id, $name, $userid){
    global $DB;

    $obj = new stdClass();
    $obj->id = $id;
    $obj->name = $name;
    $obj->updated_at = time();
    $obj->modified_by = $userid;

    return $DB->update_record('subject_subjects', $obj);
}

function block_subject_delete_subject($id){
    global $DB;

    return $DB->delete_records('subject_subjects',array('id' => $id));
}

function block_subject_delete_mark($id){
    global $DB;

    return $DB->delete_records('subject_marks',array('sub_id' => $id));
}

function block_subject_insert_subject($courseid, $name, $userid){
    global  $DB;

    $obj = new stdClass();
    $obj->course_id = $courseid;
    $obj->name = $name;
    $obj->created_at = time();
    $obj->created_by = $userid;

    return $DB->insert_record('subject_subjects', $obj);
}

function create_sql_marks_table ($userid, $courseid) {
	$out = array();
	$id = (int)$userid;
	$user = get_user_info_by_id($id);
	$title = html_writer::tag('h4', fullname($user));
	$fields = 'm.id, m.user_id, m.mark, s.name';
	$from = '{subject_marks} as m JOIN {subject_subjects} as s ON m.sub_id = s.id';
	$wheres = "m.user_id = $id AND s.course_id = $courseid";
	$out['title'] = $title;
	$out['field'] = $fields;
	$out['from'] = $from;
	$out['where'] = $wheres;

	return $out;
}
