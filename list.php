
<?php
require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/list_form.php');
require_once(__DIR__ . '/lib.php');

//check for all required variables
$courseid = required_param('course', PARAM_INT);
$id = optional_param('id', 0, PARAM_INT);
$viewpage = optional_param('viewpage', false, PARAM_BOOL);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_subject_rating', $courseid);
}

require_login($course);

$PAGE->set_url('/blocks/subject/list.php?course='.$courseid);
$PAGE->set_pagelayout('incourse');
$PAGE->set_heading(get_string('list', 'block_subject'));

$subjects = block_subject_get_subjects_with_mark($courseid, $USER->id);
//echo '<pre>';
//print_object($subjects);
//echo '</pre>';die;

$list = new list_form($CFG->wwwroot.'/blocks/subject/list.php?course='.$courseid, array('subjects' => $subjects));

if ($list->is_cancelled()) {
    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($courseurl);
} else if ($data = $list->get_data()) {
    if (!empty($subjects) && is_array($subjects)) {
        foreach ($subjects as $subject) {
            if ($subject->mark == null) {
                block_subject_insert_mark_to_database($subject, $USER->id, $data);
                continue;
            }
            block_subject_update_mark_to_database($subject, $USER->id, $data);
        }
    }
    redirect(new moodle_url('/blocks/subject/list.php', array('course' => $courseid)), get_string('success', 'block_subject'));

} else {
    // form didn't validate or this is the first display
    $site = get_site();
    echo $OUTPUT->header();
    $list->display();
    echo $OUTPUT->footer();
}





