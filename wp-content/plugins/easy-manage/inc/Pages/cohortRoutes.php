<?php
/**
 * @package easyManage
 */

namespace Inc\Pages;

use WP_Error;

class cohortRoutes{
 public function register(){
    add_action('rest_api_init',[$this, 'register_cohort_endpoints']);
 }

 public function register_cohort_endpoints(){
    register_rest_route('easymanage/v2', '/cohort', array(
        'methods'             => 'POST',
        'callback'            => array($this, 'create_cohort'),
        // 'permission_callback' => function () {
        //     return current_user_can('manage_options');
        // }
    ));

    register_rest_route('easymanage/v2', '/cohort/(?P<id>\d+)', array(
        'methods'             => 'GET',
        'callback'            => array($this, 'get_cohort'),
        
        // 'permission_callback' => function () {
        //     return current_user_can('manage_options');
        // }
    ));

    register_rest_route('easymanage/v2', '/cohorts', array(
        'methods'             => 'GET',
        'callback'            => array($this, 'get_all_cohorts'),
        // 'permission_callback' => function () {
        //     return current_user_can('manage_options');
        // }
    ));

    register_rest_route('easymanage/v2', '/cohort/(?P<id>\d+)', array(
        'methods'             => 'PATCH',
        'callback'            => array($this, 'update_cohort'),
        // 'permission_callback' => function () {
        //     return current_user_can('manage_options');
        // }
    ));
 }

 public function create_cohort($request){
    global $wpdb;
    $table_name = $wpdb->prefix . 'cohorts';

    $programme_name = $request->get_param('programme_name');
    $starts_date = $request->get_param('starts_date');
    $end_date = $request->get_param('end_date');
    $assigned_to = $request->get_param('assigned_to');
    $place = $request->get_param('place');

    $data = array(
        'programme_name' => $programme_name,
        'starts_date' => $starts_date,
        'end_date' => $end_date,
        'assigned_to' => $assigned_to,
        'place' => $place
    );

    $wpdb->insert($table_name, $data);

    return rest_ensure_response($data,'Cohort created successfully.');
 }

 public function get_all_cohorts($request){
    global $wpdb;
    $table_name = $wpdb->prefix . 'cohorts';

    $cohorts = $wpdb->get_results("SELECT * FROM $table_name");

    return rest_ensure_response($cohorts);
 }

 public function get_cohort($request){
    global $wpdb;
    $table_name = $wpdb->prefix . 'cohorts';

    $cohort_id = $request->get_param('id');

    $cohort = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $cohort_id));

    if (!$cohort) {
        return new WP_Error('cohort_not_found', 'Cohort not found', array('status' => 404));
    }

    return rest_ensure_response($cohort);
 }

 public function update_cohort($request){
    global $wpdb;
    $table_name = $wpdb->prefix . 'cohorts';

    $cohort_id = $request->get_param('id');
    $programme_name = $request->get_param('programme_name');
    $starts_date = $request->get_param('starts_date');
    $end_date = $request->get_param('end_date');
    $assigned_to = $request->get_param('assigned_to');
    $place = $request->get_param('place');

    $data = array(
        'programme_name' => $programme_name,
        'starts_date' => $starts_date,
        'end_date' => $end_date,
        'assigned_to' => $assigned_to,
        'place' => $place
    );

    $where = array('id' => $cohort_id);

    $wpdb->update($table_name, $data, $where);

    return rest_ensure_response($data,'Cohort updated successfully.');
 }
}
