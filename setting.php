<?php

require(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
require_once(__DIR__ . '/setting_form.php');

$courseid = required_param('course', PARAM_INT);

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_subject', $courseid);
}

//check login and get context
require_login($courseid, false);
$context = context_course::instance($courseid);
require_capability('block/subject:manager', $context);

$num = optional_param('num', 0, PARAM_INT);
$num++;

$PAGE->set_course($course);
$PAGE->set_url('/blocks/subject/setting.php?course=' . $courseid);
$PAGE->set_title(get_string('setting', 'block_subject'));
$PAGE->set_heading(get_string('setting', 'block_subject'));
$PAGE->set_pagelayout('incourse');
$PAGE->requires->css('/blocks/subject/style.css');
$PAGE->requires->jquery();
$PAGE->requires->js('/blocks/subject/subject_js.js');

$subjects = block_subject_get_all_subjects($courseid);

$setting = new setting_form($CFG->wwwroot . '/blocks/subject/setting.php?course=' . $courseid, array('subjects' => $subjects, 'num' => $num), 'post', '', array('id' => 'setting_subject_form'));

if ($setting->is_cancelled()) {
    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($courseurl);
} else if ($data = $setting->get_data()) {
    if (!empty($data->submitbutton)) {
        $subs = $data->Subject;
        if (!empty($subs) && is_array($subs)) {
            foreach ($subs as $subid => $sub) {
                if ($subid > 0) {
                    if (!empty($sub['name'])) {
                        block_subject_update_subject_name($subid, $sub['name'], $USER->id);
                    } else {
                        block_subject_delete_subject($subid);
                        block_subject_delete_mark($subid);
                    }
                } else {
                    if (!empty($sub['name'])) {
                        block_subject_insert_subject($courseid, $sub['name'], $USER->id);
                    }else{
                        continue;
                    }
                }
            }
            redirect(new moodle_url('/blocks/subject/setting.php', array('course' => $courseid)), get_string('success', 'block_subject'));
        }
    }
}

echo $OUTPUT->header();
$setting->display();
echo $OUTPUT->footer();
