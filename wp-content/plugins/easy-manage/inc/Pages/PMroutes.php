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
            'methods'  => 'POST',
            'callback'  => array($this, 'create_manager'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));

        register_rest_route('easymanage/v2', '/manager/(?P<id>\d+)', array(
            'methods'  => 'GET',
            'callback'  => array($this, 'get_manager'),

            // 'permission_callback' => function () {
            //     return current_user_can('manage_options');
            // }
        ));

        register_rest_route('easymanage/v2', '/managers', array(
            'methods'  => 'GET',
            'callback'  => array($this, 'get_all_managers'),
            // 'permission_callback' => function () {
            //     return current_user_can('manage_options');
            // }
        ));
        register_rest_route('easymanage/v2', '/manager/(?P<id>\d+)', array(
            'methods' => 'PUT',
            'callback' => array($this, 'update_manager'),
        ));

        register_rest_route('easymanage/v2', '/manager/(?P<id>\d+)', array(
            'methods'  => 'DELETE',
            'callback' => array($this, 'delete_manager'),
            'permission_callback' => function () {
                return current_user_can('manage_options');
            }
        ));
    }

    public function create_manager($request)
    {
        $user = wp_insert_user(
            array(
                'user_login' => $request['managername'],
                'user_email' => $request['email'],
                'user_pass'  => 'manager',
                'role'       => 'program_manager',
                'meta_input' => array(
                    'phone_number'    => $request['phone'],
                    'is_deactivated'  => 0,
                    'is_deleted'      => 0
                )
            )
        );

        if (is_wp_error($user)) {
            $error_message = $user->get_error_message();
            return new WP_Error('400', $error_message);
        } else {
            return rest_ensure_response($user);
        }
    }

    // Get a single manager
    public function get_manager($request)
    {
        $manager_id = $request->get_param('id');
        $manager = get_user_by('ID', $manager_id);

        if (!$manager || !in_array('program_manager', $manager->roles)) {
            return new WP_Error('404', 'Manager not found');
        }

        $phone = get_user_meta($manager_id, 'phone_number', true);

        $response = [
            'status' => 'success',
            'manager' => [
                'id' => $manager->ID,
                'name' => $manager->user_login,
                'email' => $manager->user_email,
                'phone' => $phone,
                'password' => $manager->user_pass
            ]
        ];

        return rest_ensure_response($response);
    }


    // Get all managers
    public function get_all_managers($request)
    {
        $managers = get_users(array('role' => 'program_manager'));

        $response = array();

        if ($managers) {
            foreach ($managers as $manager) {
                $manager_id = $manager->ID;
                $phone      = get_user_meta($manager_id, 'phone_number', true);

                $response[] = array(
                    'id'    => $manager_id,
                    'name'  => $manager->user_login,
                    'email' => $manager->user_email,
                    'phone' => $phone
                );
            }
        }

        if (empty($response)) {
            return new WP_Error('404', 'No program managers found');
        }

        return rest_ensure_response($response);
    }


    public function update_manager($request)
    {
        $manager_id = $request->get_param('id');
        $manager = get_user_by('ID', $manager_id);
    
        if (!$manager || !in_array('manager', $manager->roles)) {
            return new WP_Error('404', 'manager not found');
        }
    
        $data = $request->get_json_params();
    
        // Update manager data
        $updated = wp_update_user(array(
            'ID' => $manager_id,
            'user_login' => isset($data['managername']) ? $data['managername'] : $manager->user_login,
            'user_email' => isset($data['email']) ? $data['email'] : $manager->user_email,
            'meta_input' => array(
                'phone_number' => isset($data['phone']) ? $data['phone'] : get_user_meta($manager_id, 'phone_number', true),
            ),
        ));
    
        if (is_wp_error($updated)) {
            $error_message = $updated->get_error_message();
            return new WP_Error('400', $error_message);
        } else {
            return rest_ensure_response($updated,'manager updated successfully');
        }
    }

    // Delete a manager (soft-delete)
    public function delete_manager($request)
    {
        $manager_id = $request->get_param('id');
        $manager = get_user_by('ID', $manager_id);

        if (!$manager || !in_array('program_manager', $manager->roles)) {
            return new WP_Error('404', 'Manager not found');
        }

        update_user_meta($manager_id, 'is_deleted', 1);

        $response = [
            'status' => 'success',
            'message' => 'Manager soft-deleted successfully',
        ];

        return rest_ensure_response($response);
    }
}
