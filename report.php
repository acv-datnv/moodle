<?php

require_once('../../config.php');
require_once('lib.php');


$record = $DB->get_records_sql('
    SELECT sub.name, mark.user_id, mark.mark
    FROM {subject_marks} as mark, {subject_subjects} as sub
    WHERE mark.sub_id = sub.id
');
var_dump($record);