<?php

/**
 * @package easyManage
 */

namespace Inc\Pages;

use WP_Error;

// Class to create program trainers endpoints 
class TrainerRoutes
{
    public function register()
    {
        add_action('rest_api_init', array($this, 'register_api_endpoints'));
    }
    public function register_api_endpoints()
    {
        register_rest_route('easymanage/v2', '/trainer', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_trainer'),
            // 'permission_callback' => function () {
            //     return current_user_can('manage_options');
            // }
        ));

        register_rest_route('easymanage/v2', '/trainer/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_trainer'),
            // 'permission_callback' => function () {
            //     return current_user_can('manage_options');
            // }
        ));
        register_rest_route('easymanage/v2', '/trainer', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_all_trainers'),
            // 'permission_callback' => function () {
            //     return current_user_can('manage_options');
            // }
        ));
    }

    public function create_trainer($request)
    {
        $user = wp_insert_user(
            [
                'user_login' => $request['trainername'],
                'user_email' => $request['email'],
                'user_pass' => 'trainer',
                'role' => 'trainer',
                'meta_input' => [
                    'phone_number' => $request['phone'],
                    'is_deactivated' => 0,
                    'is_deleted' => 0
                ]
            ]
        );
    
        if (is_wp_error($user)) {
            $error_message = $user->get_error_message();
            return new WP_Error('400', $error_message);
        } else {
            return rest_ensure_response($user->email);
        }
    }
    

    //get a single trainer
    public function get_trainer($request)
    {
        $trainer_id = $request->get_param('id');
        $trainer = get_user_by('ID', $trainer_id);

        if (!$trainer) {
            return new WP_Error('404', 'trainer not found');
        }

        $phone = get_user_meta($trainer_id, 'phone_number', true);

        $response = [
            'status' => 'success',
            'trainer' => [
                'id' => $trainer->ID,
                'name' => $trainer->user_login,
                'email' => $trainer->user_email,
                'phone' => $phone,
                'password' => $trainer->user_pass
            ]
        ];

        return rest_ensure_response($response);
    }


    //get all trainers
    public function get_all_trainers($request)
    {
        $trainers = get_users(array('role' => 'program_trainer'));

        $response = array();

        if ($trainers) {
            foreach ($trainers as $trainer) {
                $trainer_id = $trainer->ID;
                $phone = get_user_meta($trainer_id, 'phone_number', true);

                $response[] = array(
                    'id' => $trainer_id,
                    'name' => $trainer->user_login,
                    'email' => $trainer->user_email,
                    'phone' => $phone
                );
            }
        }

        if (empty($response)) {
            $response = new WP_Error('404', 'No program trainers found');
        }

        return rest_ensure_response($response);
    }
}
