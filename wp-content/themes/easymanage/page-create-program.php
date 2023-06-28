<?php


get_header();
get_sidebar();

$assignees_query = new WP_User_Query(array(
    'role' => 'trainer',
));

$assignees = $assignees_query->get_results();
?>

<div class="main">
    <h1>New program</h1>

    <?php
    global $success_msg;

    if ($success_msg) {
        echo "<p id='message'>Project manager has been added successfully</p>";
        echo '<script> document.getElementById("message").style.display = "flex"; </script>';
        echo '<script> 
                setTimeout(function(){
                    document.getElementById("message").style.display ="none";
                }, 3000);
            </script>';
    }

    if (isset($_POST['submit'])) {
        $programme_name = $_POST['programme_name'];
        $assigned_to = $_POST['assigned_to'];
        $starts_date = $_POST['starts_date'];
        $end_date = $_POST['end_date'];
        $place = $_POST['place'];

        // Create the program using the API endpoint
        global $wpdb;
        $wpdb->get_results("SELECT * FROM wp_users WHERE user_login = ''");

        $body = [
            'programme_name' => $programme_name,
            'assigned_to' => $assigned_to,
            'starts_date' => $starts_date,
            'end_date' => $end_date,
            'place' => $place
        ];

        $args = array(
            'body'        => $body,
            'method' => 'POST',
        );

        $response = wp_remote_post('http://localhost/easymanage/wp-json/easymanage/v2/cohort', $args);

        if (!is_wp_error($response)) {
            $response_data = json_decode(wp_remote_retrieve_body($response), true);
            // Display success message
            echo '<p id="message">Cohort has been added successfully</p>';
            echo '<script> document.getElementById("message").style.display = "flex"; </script>';
            echo '<script> 
                    setTimeout(function(){
                        document.getElementById("message").style.display = "none";
                    }, 3000); 
                </script>';
        } else {
            //Display error message
            echo '<p id="message">Error: ' . $response->get_error_message() . '</p>';
            echo '<script> document.getElementById("message").style.display = "flex"; </script>';
            echo '<script> 
                    setTimeout(function(){
                        document.getElementById("message").style.display = "none";
                    }, 3000);
                </script>';
        }
    }
    ?>

    <div class="container">
        <form style="width:100%;" method="post">
            <?php
            global $success_msg;

            if ($success_msg) {
                echo "<p id='message'>Project has been added successfully</p>";
                echo '<script> document.getElementById("message").style.display = "flex"; </script>';
                echo '<script>
                    setTimeout(function(){
                        document.getElementById("message").style.display = "none";
                    }, 3000);
                </script>';
            }
            ?>

            <label for="programme_name">Program name</label>
            <input type="text" id="programme_name" name="programme_name" />

            <label for="assigned_to">Assign to:</label>
            <select class="form-control" name="assigned_to" id="assigned_to">
                <?php foreach ($assignees as $assignee) : ?>
                    <option value="<?php echo esc_attr($assignee->display_name); ?>"><?php echo esc_html($assignee->display_name); ?></option>
                <?php endforeach; ?>
            </select>


            <label for="starts_date">Start Date</label>
            <input type="date" name="starts_date" id="starts_date" min="<?php echo esc_attr(date('Y-m-d')); ?>" />

            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" min="<?php echo esc_attr(date('Y-m-d')); ?>" />

            <label for="place">Location</label>
            <input type="text" id="place" name="place" />


            <div class="submit">
                <input type="submit" name="submit" value="Create" />
            </div>
        </form>
    </div>
</div>

<style>
    /* CSS styles for the form and container */
    .main {
        float: right;
        margin-top: 5rem;
        width: 85%;
        height: 90.5vh;
        background-color: #ffffff;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #ebf0ff;
        width: 50%;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .container:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    h1 {
        color: #eb7017;
        display: flex;
        justify-content: center;
        margin: 15px;
    }



    label {
        display: block;
        padding-top: 8px;
        color: black;
        margin-bottom: 10px;
        font-family: "Roboto Mono", monospace;
        font-size: 18px;
    }

    input[type="text"],
    input[type="number"],
    input[type="email"],
    input[type="date"] {
        padding: 5px;
        margin-bottom: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #5277d6;
        color: white;
        width: 50%;
        margin-top: 20px;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #040404;
    }

    .submit {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    #message {
        background-color: #7aff85;
        color: #ffffff;
        display: flex;
        justify-content: center;
        width: 100%;
        border-radius: 5px;
        padding: 4px;
        font-size: 20px;
        font-weight: 400;
    }
</style>

<?php get_footer(); ?>
