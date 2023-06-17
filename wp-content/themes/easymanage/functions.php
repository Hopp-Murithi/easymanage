<?php 
//
function easyManage_script_enqueue(){
    wp_enqueue_style('customstyle', get_template_directory_uri().'/custom/styles.css', [], '3.1.1', 'all');
    wp_enqueue_script('customjs', get_template_directory_uri(). '/custom/script.js',[], '1.0.0', true);

    // introducing bootstrap
    wp_register_style('bootstrapcss', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css', [], '5.2.3', 'all');

    wp_enqueue_style('bootstrapcss');

    wp_register_script('jsbootstrap','https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js', [], '5.2.3', false);
    wp_enqueue_script ('jsbootstrap');
    wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'easyManage_script_enqueue');

// custom logout

function custom_logout_redirect() {
    wp_redirect('http://localhost/easymanage/');
    exit;
}
add_action('wp_logout', 'custom_logout_redirect');

// Add new user roles
function add_custom_roles() {
    add_role(
        'trainer',
        __( 'Trainer' ),
        array(
            'read'         => true,
            'edit_posts'   => true,
            'delete_posts' => true,
        )
    );
    
    add_role(
        'trainee',
        __( 'Trainee' ),
        array(
            'read'         => true,
            'edit_posts'   => false,
            'delete_posts' => false,
        )
    );
    
    add_role(
        'program_manager',
        __( 'Program Manager' ),
        array(
            'read'         => true,
            'edit_posts'   => true,
            'delete_posts' => true,
        )
    );
}
add_action( 'init', 'add_custom_roles' );

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
                foreach ($users as $user) {
                    $name = $user->display_name;
                    $email = $user->user_email;
                    $role = implode(', ', $user->roles);
                    $status = 'Active'; // Assuming all users are active

                    ?>
                    <tr>
                        <td><i class="bi bi-person-circle text-dark"></i> <?php echo esc_html($name); ?></td>
                        <td><?php echo esc_html($email); ?></td>
                        <td><?php echo esc_html($role); ?></td>
                        <td><span class="badge bg-success text-white"><?php echo esc_html($status); ?></span></td>
                        <td>
                            <a href="#"><i class="bi bi-pencil-square text-dark"></i> </a>
                            <a><i class="bi bi-square-fill text-danger"></i> </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('display_table', 'display_table_shortcode');
