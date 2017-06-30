
<?php

require_once('../../config.php');

global $PAGE, $OUTPUT;

$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();
$out = html_writer::div('anonymous');
$out .= html_writer::div('kermit', 'frog');
$out .= html_writer::start_span('zombie') . 'BRAINS' . html_writer::end_span();
$out .= html_writer::div('Mr', 'toad', array('id' => 'tophat'));
echo $out;
echo $OUTPUT->footer();


?>

