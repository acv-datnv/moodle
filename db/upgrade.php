<?php
function xmldb_block_subject_upgrade($oldversion=0) {
    global $DB;

    $dbman = $DB->get_manager();
    if ($oldversion < 2017061605) {

        // Define table subject_marks to be created.
        $table = new xmldb_table('subject_marks');

        // Adding fields to table subject_marks.
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('sub_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('user_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('mark', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('created_at', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('updated_at', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('created_by', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('modified_by', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('del_flag', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1');

        // Adding keys to table subject_marks.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table subject_marks.
        $table->add_index('user_id', XMLDB_INDEX_NOTUNIQUE, array('user_id'));

        // Conditionally launch create table for subject_marks.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        $table1 = new xmldb_table('subject_subjects');

        // Adding fields to table subject_subjects.
        $table1->add_field('id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table1->add_field('name', XMLDB_TYPE_CHAR, '256', null, XMLDB_NOTNULL, null, 'name');
        $table1->add_field('course_id', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table1->add_field('created_at', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table1->add_field('updated_at', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table1->add_field('created_by', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table1->add_field('modified_by', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, '0');
        $table1->add_field('del_flag', XMLDB_TYPE_INTEGER, '1', null, XMLDB_NOTNULL, null, '1');

        // Adding keys to table subject_subjects.
        $table1->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Adding indexes to table subject_subjects.
        $table1->add_index('course_id', XMLDB_INDEX_NOTUNIQUE, array('course_id'));

        // Conditionally launch create table for subject_subjects.
        if (!$dbman->table_exists($table1)) {
            $dbman->create_table($table1);
        }

        // Subject savepoint reached.
        upgrade_block_savepoint(true, 2017061605, 'subject');
    }
}