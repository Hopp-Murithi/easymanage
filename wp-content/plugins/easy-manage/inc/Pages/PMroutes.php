<?php

/**
 * @package easyManage
 */

namespace Inc\Pages;

use WP_Error;

// Class to create program managers endpoints 
class PMroutes
{
    public function register()

    {
        add_action('rest_api_init', array($this, 'register_api_endpoints'));
    }
    public function register_api_endpoints()
    {
        register_rest_route('easymanage/v2', '/manager', array(
            'methods' => 'POST',
            'callback' => array($this, 'create_manager'),
            // 'permission_callback' => function () {
            //     return current_user_can('manage_options');
            // }
        ));

        register_rest_route('easymanage/v2', '/manager/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_manager'),
            // 'permission_callback' => function () {
            //     return current_user_can('manage_options');
            // }
        ));
        register_rest_route('easymanage/v2', '/manager', array(
            'methods' => 'GET',
            'callback' => array($this, 'get_all_managers'),
            // 'permission_callback' => function () {
            //     return current_user_can('manage_options');
            // }
        ));
    }

    public function create_manager($request)
    {
        $user = wp_insert_user(
            [
                'user_login' => $request['managername'],
                'user_email' => $request['email'],
                'user_pass' => 'manager',
                'role' => 'program_manager',
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
    

    //get a single manager
    public function get_manager($request)
    {
        $manager_id = $request->get_param('id');
        $manager = get_users();

        $manager = array_filter($manager, function ($user) use ($manager_id) {
            return 
            
            (string)$user->ID == $manager_id;
        });

        if( count($manager) == 0) return new WP_Error('404','Hakuna mtu');

        if ($manager && $manager[0]->role == 'program-manager') {
            $phone = get_user_meta($manager_id, 'phone_number', true);
            $response = [
                'status' => 'success',
                'manager' => [
                    'id' => $manager[0]->ID,
                    'name' => $manager[0]->user_login,
                    'email' => $manager[0]->user_email,
                    'phone' => $phone
                ]
            ];
        } else {
            $response = new WP_Error('404', 'Program manager not found');
        }

        return  rest_ensure_response($response);
        
    }


    //get all managers
    public function get_all_managers($request)
    {
        $managers = get_users(array('role' => 'program_manager'));

        $response = array();

        if ($managers) {
            foreach ($managers as $manager) {
                $manager_id = $manager->ID;
                $phone = get_user_meta($manager_id, 'phone_number', true);

                $response[] = array(
                    'id' => $manager_id,
                    'name' => $manager->user_login,
                    'email' => $manager->user_email,
                    'phone' => $phone
                );
            }
        }

        if (empty($response)) {
            $response = new WP_Error('404', 'No program managers found');
        }

        return rest_ensure_response($response);
    }
}
