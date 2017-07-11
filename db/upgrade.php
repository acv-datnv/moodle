<?php
function xmldb_block_subject_upgrade($oldversion=0) {
    global $DB;

    $dbman = $DB->get_manager();
    return true;
}