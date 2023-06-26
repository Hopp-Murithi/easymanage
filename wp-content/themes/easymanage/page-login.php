<?php
/*
Template Name: Login Page
*/

$error_message = '';

// Function to track login attempts
function track_login_attempts($username, $password)
{
    if (!session_id()) {
        session_start();
    }

    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
    }

    $_SESSION['login_attempts']++;

    // Check if maximum login attempts reached
    if ($_SESSION['login_attempts'] >= 3) {

        if (isset($_SESSION['login_attempt_time']) && time() - $_SESSION['login_attempt_time'] < 60) {

            wp_die('Too many login attempts. Please try again after 1 minute.');
        }

        // Reset login_attempts session variable
        $_SESSION['login_attempts'] = 0;
    }

    $_SESSION['login_attempt_time'] = time();
}

add_action('wp_authenticate', 'track_login_attempts', 1, 2);

if (is_user_logged_in()) {
    $user = wp_get_current_user();
    $user_roles = $user->roles;

    if (in_array('administrator', $user_roles)) {
        wp_redirect('http://localhost/easymanage/dashboard/');
        exit;
    } elseif (in_array('program_manager', $user_roles)) {
        wp_redirect('http://localhost/easymanage/dashboard/');
        exit;
    } elseif (in_array('trainer', $user_roles)) {
        wp_redirect('http://localhost/easymanage/dashboard/');
        exit;
    } elseif (in_array('trainee', $user_roles)) {
        wp_redirect('http://localhost/easymanage/view-all-projects/');
        exit;
    }
}

$login_name = '';

if (isset($_POST['login'])) {
    $employee_email = $_POST['email'];
    $user_password = $_POST['password'];

    // Validate fields
    if (empty($employee_email) || empty($user_password)) {
        $error_message = "Email and password are required.";
    } else {
        // Call the track_login_attempts function passing the username and password
        track_login_attempts($employee_email, $user_password);

        //get token and set token in cookie
        $user = get_user_by('email', $employee_email);

        $login_name = $user->user_login;

        $args = [
            'method' => 'POST',
            'body' => [
                'username' => $login_name,
                'password' => $user_password
            ]
        ];
        $result = wp_remote_post('http://localhost/easymanage/wp-json/jwt-auth/v1/token', $args);


        $token = (json_decode(wp_remote_retrieve_body($result)));
        setcookie('token', $token->token, time() + (86400 * 30), '/', 'localhost');



        if (!$user) {
            $error_message = "Invalid user email.";
        } elseif (!wp_check_password($user_password, $user->user_pass, $user->ID)) {
            $error_message = "Invalid password.";
        } else {
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID);
            do_action('wp_login', $user->user_login, $user);

            $user_roles = $user->roles;
            $redirect_url = '';

            if (in_array('administrator', $user_roles)) {
                $redirect_url = 'http://localhost/easymanage/dashboard/';
            } elseif (in_array('program_manager', $user_roles)) {
                $redirect_url = 'http://localhost/easymanage/dashboard/';
            } elseif (in_array('trainer', $user_roles)) {
                $redirect_url = 'http://localhost/easymanage/dashboard/';
            } elseif (in_array('trainee', $user_roles)) {
                $redirect_url = 'http://localhost/easymanage/view-all-projects/';
            }

            $redirect_url .= '?user_id=' . $user->ID;

            wp_redirect($redirect_url);
            exit;
        }
    }
}

?>

<?php wp_head(); ?>


<?php get_header() ?>


<div class="form-container">
    <form class="form-inside" action="" method="POST">
        <div class="form">
            <div style="display:flex;justify-content:center;font-size:40px;color:#EB7017;font-weight:500;margin-top:-90px;">
                <?php
                $timezone = new DateTimeZone('Africa/Nairobi');
                $date = new DateTime('now', $timezone);
                $current_hour = $date->format('G');

                $period = '';

                if ($current_hour >= 5 && $current_hour < 12) {
                    $period = 'Morning';
                } elseif ($current_hour >= 12 && $current_hour < 18) {
                    $period = 'Afternoon';
                } else {
                    $period = 'Evening';
                }

                echo 'Good ' . $period . '!';
                ?>
            </div>
            <?php if (!empty($error_message)) : ?>
                <div style="color: red;font-size:20px;margin-top:10px;"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <div class="input1">
                <label for="employee-number">Email:</label>
                <input type="email" placeholder="Enter email" name="email">
            </div>
            <div class="input1">
                <label for="">Password:</label>
                <input type="password" placeholder="Enter password" name="password">
            </div>

            <button type="submit" style="margin-top: 40px;" class="btnreg" name="login">Login</button>
        </div>
    </form>
</div>

<?php get_footer(); ?>