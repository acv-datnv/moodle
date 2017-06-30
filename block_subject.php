<?php

class block_subject extends block_base {
    public function init() {
        $this->title = get_string('subject', 'block_subject');
    }

    function get_content() {
        global $COURSE;

        if ($this->content !== NULL) {
            return $this->content;
        }

        if (empty($this->instance)) {
            return null;
        }

        $this->content = new stdClass();

        $url_view_setting = new moodle_url('/blocks/subject/setting.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
        $url_view_list = new moodle_url('/blocks/subject/list.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
        $url_view_report = new moodle_url('/blocks/subject/report.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));

        $this->content->text = 'my subject rating block';

        $this->content->footer = html_writer::link($url_view_setting, get_string('view_setting', 'block_subject'));
        $this->content->footer .= '<br />' . html_writer::link($url_view_list, get_string('view_list', 'block_subject'));
        $this->content->footer .= '<br />' . html_writer::link($url_view_report, get_string('view_report', 'block_subject'));

        return $this->content;
    }

    public function applicable_formats() {
        return array('course-view' => true);
    }
}
