<?php
/**
 * Created by PhpStorm.
 * User: HoangAnh
 * Date: 6/29/2017
 * Time: 9:02 AM
 */

function block_subject_rating_images() {
    return array(html_writer::tag('img', '', array('alt' => get_string('red', 'block_subject_rating'), 'src' => "pix/picture0.gif")),
        html_writer::tag('img', '', array('alt' => get_string('blue', 'block_subject_rating'), 'src' => "pix/picture1.gif")),
        html_writer::tag('img', '', array('alt' => get_string('green', 'block_subject_rating'), 'src' => "pix/picture2.gif")));
}

function block_subject_rating_print_page($subject_rating, $return = false) {
    global $OUTPUT, $COURSE;
    $display = $OUTPUT->heading($subject_rating->pagetitle);
    $display .= $OUTPUT->box_start();
    if($subject_rating->displaydate) {
        $display .= userdate($subject_rating->displaydate);
    }

    $display .= clean_text($subject_rating->displaytext);

    //close the box
    $display .= $OUTPUT->box_end();
    if ($subject_rating->displaypicture) {
        $display .= $OUTPUT->box_start();
        $images = block_simplehtml_images();
        $display .= $images[$subject_rating->picture];
        $display .= html_writer::start_tag('p');
        $display .= clean_text($subject_rating->description);
        $display .= html_writer::end_tag('p');
        $display .= $OUTPUT->box_end();
    }

    if($return) {
        return $display;
    } else {
        echo $display;
    }
}