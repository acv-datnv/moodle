<?php
/**
 * Created by PhpStorm.
 * User: HoangAnh
 * Date: 7/5/2017
 * Time: 4:20 PM
 */

class report_table extends table_sql {
    function __construct($uniqueid)
    {
        parent::__construct($uniqueid);
        //define the list of columns to show
        $columns = array('name', 'mark');
        $this->define_columns($columns);

        //define the titles of columns to show
        $headers = array('Subject', 'Mark');
        $this->define_headers($headers);
    }
}