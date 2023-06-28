<?php
/**
 * @package easyManage
 */

namespace Inc\Pages;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

class ProjectRoutes {
    public function register() {
        add_action('rest_api_init', array($this, 'register_project_endpoints'));
    }

    public function register_project_endpoints() {
        register_rest_route('easymanage/v2', '/project', array(
            'methods'             => 'POST',
            'callback'            => array($this, 'create_project'),
        ));

        register_rest_route('easymanage/v2', '/project/(?P<id>\d+)', array(
            'methods'             => 'GET',
            'callback'            => array($this, 'get_project'),
        ));

        register_rest_route('easymanage/v2', '/projects', array(
            'methods'             => 'GET',
            'callback'            => array($this, 'get_all_projects'),
        ));

        register_rest_route('easymanage/v2', '/project/(?P<id>\d+)', array(
            'methods'             => 'PUT',
            'callback' => array($this, 'update_project'),
        ));
    }

    public function create_project(WP_REST_Request $request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';
        $cohorts_table = $wpdb->prefix . 'cohorts';

        $project_name = $request->get_param('project_name');
        $project_details = $request->get_param('project_details');
        $due_date = $request->get_param('due_date');
        $assigned_to = $request->get_param('assigned_to');
        $trainer_stack = $request->get_param('stack');

        // Retrieve the trainer's stack from the cohorts table

        $data = array(
            'project_name' => $project_name,
            'project_details' => $project_details,
            'due_date' => $due_date,
            'assigned_to' => $assigned_to,
            'stack' => $trainer_stack,
        );

        $wpdb->insert($table_name, $data);

        $response = new WP_REST_Response($data);
        $response->set_status(201);
        $response->set_data(array('message' => 'Project created successfully.'));
        return $response;
    }

    public function get_all_projects() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';

        $projects = $wpdb->get_results("SELECT * FROM $table_name");

        $response = new WP_REST_Response($projects);
        $response->set_status(200);
        return $response;
    }

    public function update_project(WP_REST_Request $request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';

        $id = $request->get_param('id');
        $project_name = $request->get_param('project_name');
        $project_details = $request->get_param('project_details');
        $due_date = $request->get_param('due_date');
        $assigned_to = $request->get_param('assigned_to');

        $data = array(
            'project_name' => $project_name,
            'project_details' => $project_details,
            'due_date' => $due_date,
            'assigned_to' => $assigned_to,
        );

        $wpdb->update($table_name, $data, array('id' => $id));

        $response = new WP_REST_Response($data);
        $response->set_status(200);
        $response->set_data(array('message' => 'Project updated successfully.'));
        return $response;
    }

    public function get_project(WP_REST_Request $request) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'projects';

        $id = $request->get_param('id');

        $project = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id));

        if (!$project) {
            $error = new WP_Error('project_not_found', 'Project not found.', array('status' => 404));
            return $error;
        }

        $response = new WP_REST_Response($project);
        $response->set_status(200);
        return $response;
    }
}
