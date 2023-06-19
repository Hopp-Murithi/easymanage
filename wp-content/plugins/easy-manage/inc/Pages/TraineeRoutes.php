<?php
/**
 * @package easyManage
 */

namespace Inc\Pages;

use WP_Error;

// Class to create trainees endpoints 
class TraineeRoutes
{
    public function register()
    {
        add_action('rest_api_init', array($this, 'register_api_endpoints'));
    }

    public function register_api_endpoints()
    {
        register_rest_route('easymanage/v2', '/trainee', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_trainee'),
        ));

        register_rest_route('easymanage/v2', '/trainee/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_trainee'),
        ));

        register_rest_route('easymanage/v2', '/trainees', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_all_trainees'),
        ));
    }

    public function create_trainee($request)
    {
        $user = wp_insert_user([
            'user_login' => $request['traineename'],
            'user_email' => $request['email'],
            'user_pass' => 'trainee',
            'role' => 'trainee',
            'meta_input' => [
                'phone_number' => $request['phone'],
                'is_deactivated' => 0,
                'is_deleted' => 0
            ]
        ]);

        if (is_wp_error($user)) {
            $error_message = $user->get_error_message();
            return new WP_Error('400', $error_message);
        } else {
            return rest_ensure_response($user->user_email);
        }
    }

    // Get a single trainee
    public function get_trainee($request)
    {
        $trainee_id = $request->get_param('id');
        $trainee = get_user_by('ID', $trainee_id);

        if (!$trainee) {
            return new WP_Error('404', 'Trainee not found');
        }

        $phone = get_user_meta($trainee_id, 'phone_number', true);

        $response = [
            'status' => 'success',
            'trainee' => [
                'id' => $trainee->ID,
                'name' => $trainee->user_login,
                'email' => $trainee->user_email,
                'phone' => $phone,
                'password' => $trainee->user_pass
            ]
        ];

        return rest_ensure_response($response);
    }

    // Get all trainees
    public function get_all_trainees($request)
    {
        $trainees = get_users(array('role' => 'trainee'));

        $response = array();

        if ($trainees) {
            foreach ($trainees as $trainee) {
                $trainee_id = $trainee->ID;
                $phone = get_user_meta($trainee_id, 'phone_number', true);

                $response[] = array(
                    'id' => $trainee_id,
                    'name' => $trainee->user_login,
                    'email' => $trainee->user_email,
                    'phone' => $phone
                );
            }
        }

        if (empty($response)) {
            $response = new WP_Error('404', 'No program trainees found');
        }

        return rest_ensure_response($response);
    }
}
