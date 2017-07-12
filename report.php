<?php

require(__DIR__. '/../../config.php');
require_once($CFG->libdir . '/tablelib.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/report_table.php');

$courseid = required_param('course', PARAM_INT);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
	print_error('invalidcourse', 'block_subject_rating', $courseid);
}

require_login($course);
$context = context_course::instance($courseid);
require_capability('block/subject:manager', $context);

$PAGE->set_url('/test_custom.php');
$PAGE->set_context($context);
$PAGE->set_title(get_string('view_report', 'block_subject'));
$PAGE->set_heading(get_string('view_report', 'block_subject'));
$PAGE->set_pagelayout('incourse');


$userids = block_subject_get_all_user_ids_marked();
$subjects = block_subject_get_all_subjects($courseid);

echo $OUTPUT->header();

if (!empty($userids) && is_array($userids)) {
	foreach ($userids as $userid) {
		$sql = create_sql_marks_table($userid, $courseid);
		echo $sql['title'];
		$table = new report_table('report_table');
		$table->set_sql($sql['field'], $sql['from'], $sql['where']);
		$table->define_baseurl("$CFG->wwwroot/report.php");
		$table->out(100, false);
	}
}

if (!empty($userids) && is_array($userids) && !empty($subjects) && is_array($subjects)) {
	echo $overview = block_subject_create_marks_overview_table($subjects, $userids);
}

echo $OUTPUT->footer();
