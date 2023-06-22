<?php
/**
 * @package easyManage
 */

namespace Inc\Pages;

use WP_Error;

class projectRoutes
{
    public function register()
    {
        add_action('rest_api_init', array($this, 'register_project_endpoints'));
    }

    public function register_project_endpoints()
    {
        register_rest_route('easymanage/v2', '/project', array(
            'methods'             => 'POST',
            'callback'            => array($this, 'create_project'),
            // 'permission_callback' => function () {
            //     return current_user_can('manage_options');
            // }
        ));

        register_rest_route('easymanage/v2', '/project/(?P<id>\d+)', array(
            'methods'             => 'GET',
            'callback'            => array($this, 'get_project'),

            // 'permission_callback' => function () {
            //     return current_user_can('manage_options');
            // }
        ));

        register_rest_route('easymanage/v2', '/projects', array(
            'methods'             => 'GET',
            'callback'            => array($this, 'get_all_projects'),
            // 'permission_callback' => function () {
            //     return current_user_can('manage_options');
            // }
        ));

        register_rest_route('easymanage/v2', '/project/(?P<id>\d+)', array(
            'methods'             => 'PUT',
            'callback' => array($this, 'update_project'),
            // 'permission_callback' => function () {
            //     return current_user_can('manage_options');
            // }
        ));
    }

    public function create_project($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';

        $project_name = $request->get_param('project_name');
        $project_details = $request->get_param('project_details');
        $due_date = $request->get_param('due_date');
        $assigned_to = $request->get_param('assigned_to');
        $stack = $request->get_param('stack');

        $data = array(
            'project_name' => $project_name,
            'project_details' => $project_details,
            'due_date' => $due_date,
            'assigned_to' => $assigned_to,
            'stack' => $stack,
        );

        $wpdb->insert($table_name, $data);

        return rest_ensure_response($data, 'Project created successfully.');
    }

    public function get_all_projects($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';

        $projects = $wpdb->get_results("SELECT * FROM $table_name");

        return rest_ensure_response($projects);
    }

    // update project
    public function update_project($request)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';

        $id = $request->get_param('id');
        $project_name = $request->get_param('project_name');
        $project_details = $request->get_param('project_details');
        $due_date = $request->get_param('due_date');
        $assigned_to = $request->get_param('assigned_to');
        $stack = $request->get_param('stack');

        $data = array(
            'project_name' => $project_name,
            'project_details' => $project_details,
            'due_date' => $due_date,
            'assigned_to' => $assigned_to,
            'stack' => $stack,
        );

        $wpdb->update($table_name, $data, array('id' => $id));

        return rest_ensure_response($data, 'Project updated successfully.');
    }

    //Get a single project with ID
    public function get_project($request){
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
    
        $project_id = $request->get_param('id');
    
        $project = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $project_id));
    
        if (!$project) {
            return new WP_Error('project_not_found', 'project not found', array('status' => 404));
        }
    
        return rest_ensure_response($project);
     }
}
