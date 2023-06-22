<?php
/**
 * @package easyManage
 */

namespace Inc\Pages;

class createTables
{
    public function register()
    {
        $this->create_cohort_table();
        $this->create_project_table();
    }

    // Create cohorts table
    public function create_cohort_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'cohorts';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id int NOT NULL AUTO_INCREMENT,
            programme_name text NOT NULL,
            starts_date DATE NOT NULL,
            end_date DATE NOT NULL,
            assigned_to text NOT NULL,
            place text NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    // Create projects table
    public function create_project_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id int NOT NULL AUTO_INCREMENT,
            project_name text NOT NULL,
            project_details text NOT NULL,
            assigned_to text NOT NULL,
            stack text NOT NULL,
            due_date DATE NOT NULL,
            is_completed int NOT NULL default 0,
            PRIMARY KEY (id)
        ) $charset_collate;";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
