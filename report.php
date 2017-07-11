<?php

require(__DIR__. '/../../config.php');
require_once($CFG->libdir . '/tablelib.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/report_table.php');

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/test_custom.php');
$courseid = required_param('course', PARAM_INT);


$PAGE->set_title('Testing');
$PAGE->set_heading('Testing table class');
echo $OUTPUT->header();

$userids = block_subject_get_all_userids();
$subjects = block_subject_get_all_subjects($courseid);


foreach ($userids as $userid){
    $id = (int)$userid->user_id;
    $user = get_user_info_by_id($id);
    $fullname = fullname($user);
    $out = html_writer::tag('h4', $fullname);
    echo $out;
    $table = new report_table('uniqueid');
    // Work out the sql for the table.
    $fields = 'm.id, m.user_id, m.mark, s.name';
    $from = '{subject_marks} as m JOIN {subject_subjects} as s ON m.sub_id = s.id';
    $wheres = "m.user_id = $id AND s.course_id = $courseid";
    $table->set_sql($fields, $from, $wheres);

    $table->define_baseurl("$CFG->wwwroot/test_custom.php");

    $table->out(100, false);
}

echo $overview = block_subject_create_marks_overview_table($subjects, $userids);


echo $OUTPUT->footer();
