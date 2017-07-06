<?php

require_once('../../config.php');
require "$CFG->libdir/tablelib.php";
require 'lib.php';
require "test_table.php";

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/test_custom.php');
$courseid = required_param('courseid', PARAM_INT);
$blockid = required_param('blockid', PARAM_INT);
$download = optional_param('download', '', PARAM_ALPHA);

$PAGE->set_title('Testing');
$PAGE->set_heading('Testing table class');
$PAGE->navbar->add('Testing table class', new moodle_url('/blocks/subject/test_custom.php?', array('courseid' => $courseid,'blockid' => $blockid)));
echo $OUTPUT->header();

$userids = get_userid();
$subjects = get_all_subjects($courseid);


foreach ($userids as $userid){
    $id = (int)$userid->user_id;
    $user = get_user_info_by_id($id);
    $fullname = fullname($user);
    $out = html_writer::tag('h4', $fullname);
    echo $out;
    $table = new test_table('uniqueid');
    // Work out the sql for the table.
    $fields = 'm.id, m.user_id, m.mark, s.name';
    $from = '{subject_marks} as m JOIN {subject_subjects} as s ON m.sub_id = s.id';
    $where = "m.user_id = $id";
    $table->set_sql($fields, $from, $where);

    $table->define_baseurl("$CFG->wwwroot/test_custom.php");

    $table->out(100, false);
}

echo $overview = create_overview_table($subjects, $userids);


echo $OUTPUT->footer();
