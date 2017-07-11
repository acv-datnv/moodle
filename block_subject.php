<?php

defined('MOODLE_INTERNAL') || die();

class block_subject extends block_base {
    public function init() {
        $this->title = get_string('subject', 'block_subject');
    }

    function get_content()
    {
        global $CFG, $PAGE;
        $this->content = new stdClass();
        $courseid = $PAGE->course->id;
        $context = context_course::instance($courseid);

        if (has_capability('block/subject:manager', $context)) {
            $html = '<ul>';
            $html .= sprintf('<li><a href="%s/blocks/subject/setting.php?course=%d">%s</a></li>', $CFG->wwwroot, $courseid, get_string('view_setting', 'block_subject'));
            $html .= sprintf('<li><a href="%s/blocks/subject/test_custom.php?course=%d">%s</a></li>', $CFG->wwwroot, $courseid, get_string('view_report', 'block_subject'));

            $html .= '</ul>';
        } else if (has_capability('moodle/grade:export', $context)) {
            $html = '<ul>';
            $html .= sprintf('<li><a href="%s/blocks/subject/list.php?course=%d">%s</a></li>', $CFG->wwwroot, $courseid, get_string('view_list', 'block_subject'));
            $html .= '</ul>';
        } else {
            $html = '<ul>';
            $html .= sprintf('<li><a href="%s/blocks/subject/setting.php?course=%d">%s</a></li>', $CFG->wwwroot, $courseid, get_string('view_setting', 'block_subject'));
            $html .= sprintf('<li><a href="%s/blocks/subject/test_custom.php?course=%d">%s</a></li>', $CFG->wwwroot, $courseid, get_string('view_report', 'block_subject'));
            $html .= sprintf('<li><a href="%s/blocks/subject/list.php?course=%d">%s</a></li>', $CFG->wwwroot, $courseid, get_string('view_list', 'block_subject'));
            $html .= '</ul>';
        }

        $this->content->text = $html;
        return $this->content;
    }

    public function applicable_formats() {
        return array('course-view' => true);
    }
}
