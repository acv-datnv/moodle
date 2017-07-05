<?php
function xmldb_block_subject_rating_upgrade($oldversion=0) {
    global $DB;

    $dbman = $DB->get_manager();
    if ($oldversion < 2017062915) {

        // Define table block_subject_rating to be created.
        $table = new xmldb_table('block_subject_rating');

        // Adding fields to table block_subject_rating.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('blockid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('displaytext', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('format', XMLDB_TYPE_INTEGER, '3', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('filename', XMLDB_TYPE_CHAR, '255', null, null, null, null);
        $table->add_field('picture', XMLDB_TYPE_INTEGER, '2', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('description', XMLDB_TYPE_TEXT, null, null, XMLDB_NOTNULL, null, null);
        $table->add_field('displaypicture', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('displaydate', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table block_subject_rating.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for block_subject_rating.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Subject_rating savepoint reached.
        upgrade_block_savepoint(true, 2017062915, 'subject_rating');
    }
}