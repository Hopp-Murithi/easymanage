<?php
//
function easyManage_script_enqueue()
{
    wp_enqueue_style('customstyle', get_template_directory_uri() . '/custom/styles.css', [], '3.1.1', 'all');
    wp_enqueue_script('customjs', get_template_directory_uri() . '/custom/script.js', [], '1.0.0', true);

    // introducing bootstrap
    wp_register_style('bootstrapcss', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css', [], '5.2.3', 'all');

    wp_enqueue_style('bootstrapcss');

    wp_register_script('jsbootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js', [], '5.2.3', false);
    wp_enqueue_script('jsbootstrap');
    wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'easyManage_script_enqueue');

// custom logout

// function custom_logout_redirect() {
//     wp_redirect('http://localhost/easymanage/');
//     exit;
// }
// add_action('wp_logout', 'custom_logout_redirect');

// Add new user roles
function add_custom_roles()
{
    add_role(
        'trainer',
        __('Trainer'),
        array(
            'read'         => true,
            'edit_posts'   => true,
            'delete_posts' => true,
        )
    );

    add_role(
        'trainee',
        __('Trainee'),
        array(
            'read'         => true,
            'edit_posts'   => false,
            'delete_posts' => false,
        )
    );

    add_role(
        'program_manager',
        __('Program Manager'),
        array(
            'read'         => true,
            'edit_posts'   => true,
            'delete_posts' => true,
        )
    );
}
add_action('init', 'add_custom_roles');


function display_table_shortcode()
{
    ob_start();
?>
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $users = get_users(); // Retrieve all users
                $current_user = wp_get_current_user(); // Get the current user
                $current_user_roles = $current_user->roles; // Get the roles of the current user

                foreach ($users as $user) {
                    $name = $user->display_name;
                    $email = $user->user_email;
                    $role = implode(', ', $user->roles);
                    $is_deactivated = get_user_meta($user->ID, 'is_deactivated', true);
                    $status = ($is_deactivated == 1) ? 'Inactive' : 'Active';
                    $status_class = ($is_deactivated == 1) ? 'bg-danger text-white' : 'bg-success text-white';
                    $toggle_action = ($is_deactivated == 1) ? 'activate' : 'deactivate';
                    $toggle_icon = ($is_deactivated == 1) ? 'bi-play-fill' : 'bi-square-fill';
                ?>
                    <tr>
                        <td><i class="bi bi-person-circle text-dark"></i> <?php echo esc_html($name); ?></td>
                        <td><?php echo esc_html($email); ?></td>
                        <td><?php echo esc_html($role); ?></td>
                        <td><span class="badge <?php echo esc_attr($status_class); ?>"><?php echo esc_html($status); ?></span></td>
                        <td>
                            <?php if (in_array('program_manager', $current_user_roles) && $role !== 'administrator' && $role !== 'program_manager') : ?>
                                <a href="#"><i class="bi bi-pencil-square text-dark"></i></a>
                            <?php elseif (in_array('trainer', $current_user_roles) && in_array('trainee', $user->roles)) : ?>
                                <a href="#"><i class="bi bi-pencil-square text-dark"></i></a>
                            <?php elseif (in_array('administrator', $current_user_roles) && $role !== 'administrator') : ?>
                                <a href="#"><i class="bi bi-pencil-square text-dark"></i></a>
                                <a href="#" class="toggle-user" data-user-id="<?php echo esc_attr($user->ID); ?>" data-action="<?php echo esc_attr($toggle_action); ?>"><i class="bi <?php echo esc_attr($toggle_icon); ?> text-danger"></i></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        (function($) {
            $(document).ready(function() {
                $('.toggle-user').on('click', function(e) {
                    e.preventDefault();
                    var userId = $(this).data('user-id');
                    var action = $(this).data('action');
                    var icon = $(this).find('i');

                    // Make an AJAX request to update the is_deactivated value
                    $.ajax({
                        url: '<?php echo admin_url("admin-ajax.php"); ?>',
                        type: 'POST',
                        data: {
                            action: 'toggle_user_status',
                            user_id: userId,
                            action_type: action
                        },
                        success: function(response) {
                            if (response.success) {
                                // Toggle the status and icon based on the updated value
                                if (action === 'deactivate') {
                                    icon.removeClass('bi-square-fill').addClass('bi-play-fill');
                                    icon.closest('tr').find('.badge').removeClass('bg-success').addClass('bg-danger').text('Inactive');
                                } else {
                                    icon.removeClass('bi-play-fill').addClass('bi-square-fill');
                                    icon.closest('tr').find('.badge').removeClass('bg-danger').addClass('bg-success').text('Active');
                                }
                            } else {
                                console.log('Error:', response.data.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('AJAX Error:', error);
                        }
                    });
                });
            });
        })(jQuery);
    </script>
<?php
    return ob_get_clean();
}
add_shortcode('display_table', 'display_table_shortcode');

// AJAX callback to handle the user status toggle
add_action('wp_ajax_toggle_user_status', 'toggle_user_status_ajax_callback');
add_action('wp_ajax_nopriv_toggle_user_status', 'toggle_user_status_ajax_callback');
function toggle_user_status_ajax_callback()
{
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized', 403);
    }

    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
    $action_type = isset($_POST['action_type']) ? sanitize_text_field($_POST['action_type']) : '';

    if (!$user_id || !in_array($action_type, array('activate', 'deactivate'))) {
        wp_send_json_error('Invalid request');
    }

    // Update the is_deactivated value for the user
    $is_deactivated = ($action_type === 'deactivate') ? 1 : 0;
    update_user_meta($user_id, 'is_deactivated', $is_deactivated);

    wp_send_json_success();
}

