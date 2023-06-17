<?php

/**
 * @package easyManage
 */

namespace Inc\Pages;

use WP_Error;

class createTables
{
    function register()
    {
        $this->create_cohort_table();
    }

    // Create products table
    public function create_cohort_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'cohorts';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id int(9) NOT NULL AUTO_INCREMENT,
            programme_name varchar(255) NOT NULL,
            startdate DATE NOT NULL,
            endDate DATE NOT NULL,
            assigned_to varchar(255) NOT NULL
            PRIMARY KEY (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
    }
}
