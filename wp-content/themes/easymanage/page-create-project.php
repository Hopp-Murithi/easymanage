<?php
get_header();
get_sidebar();

// Query to get the list of assignees
$assignees_query = new WP_User_Query(array(
    'role' => 'trainee',
));

$assignees = $assignees_query->get_results();

// Variable to store validation errors
$errors = []; ?>

<div class="main">
    <h1>New Project</h1>
    <?php
    if (isset($_POST['submit'])) {
        // Validate project name
        $project_name = isset($_POST['project_name']) ? $_POST['project_name'] : '';
        if (empty($project_name)) {
            $errors[] = 'Project name is required.';
        }

        // Validate project details
        $project_details = isset($_POST['project_details']) ? $_POST['project_details'] : '';
        if (empty($project_details)) {
            $errors[] = 'Project details are required.';
        }

        // Validate assigned to
        $assigned_to = isset($_POST['assigned_to']) ? $_POST['assigned_to'] : array();
        if (empty($assigned_to)) {
            $errors[] = 'Assignees are required.';
        }

        // Validate due date
        $due_date = isset($_POST['due_date']) ? $_POST['due_date'] : '';
        if (empty($due_date)) {
            $errors[] = 'Due date is required.';
        }

        // Get the trainer's assigned cohort and retrieve the stack
        // Get the trainer's ID and user_login
        $trainer_id = get_current_user_id();

        global $wpdb;
        $users_table = $wpdb->prefix . 'users';
        $user_login = $wpdb->get_var($wpdb->prepare("SELECT user_login FROM $users_table WHERE ID = %d", $trainer_id));

        // Get the trainer's assigned cohort and retrieve the stack
        $cohorts_table = $wpdb->prefix . 'cohorts';
        $cohort = $wpdb->get_row($wpdb->prepare("SELECT * FROM $cohorts_table WHERE assigned_to = %s", $user_login));
        $stack = $cohort->programme_name;

        if (empty($errors)) {
            // Create the program manager using the API endpoint
            $wpdb->get_results("SELECT * FROM wp_users WHERE user_login = ''");

            $body = array(
                'project_name' => $project_name,
                'project_details' => $project_details,
                'due_date' => $due_date,
                'assigned_to' => $assigned_to,
                'stack' => $stack,
            );

            $args = array(
                'body'   => $body,
                'method' => 'POST',
            );

            $response = wp_remote_post('http://localhost/easymanage/wp-json/easymanage/v2/project', $args);

            if (!is_wp_error($response)) {
                $response_data = json_decode(wp_remote_retrieve_body($response), true);
                // Display success message
                echo '<p id="message">Project has been added successfully</p>';
                echo '<script> document.getElementById("message").style.display = "flex"; </script>';
                echo '<script> 
                    setTimeout(function(){
                        document.getElementById("message").style.display = "none";
                    }, 3000); 
                </script>';
            } else {
                // Display error message
                echo '<p id="message">Error: ' . $response->get_error_message() . '</p>';
                echo '<script> document.getElementById("message").style.display = "flex"; </script>';
                echo '<script> 
                    setTimeout(function(){
                        document.getElementById("message").style.display = "none";
                    }, 3000);
                </script>';
            }
        }
    }
    ?>
    <?php
    if (!empty($errors)) {
        // Display validation errors
        echo '<div class="alert alert-danger">';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '</div>';
    }

    global $success_msg;

    if ($success_msg) {
        echo "<p id='message'>Project manager has been added successfully</p>";
        echo '<script> document.getElementById("message").style.display = "flex"; </script>';
        echo '<script> 
                setTimeout(function(){
                    document.getElementById("message").style.display = "none";
                }, 3000);
            </script>';
    }
    ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="form-cont" method="POST" action="">
                    <div class="form-group">
                        <label for="projectTitle">Project Title</label>
                        <input type="text" name="project_name" class="form-control" id="projectTitle" placeholder="Enter project title">
                    </div>
                    <div class="form-group">
                        <label for="project_details">Project Description</label>
                        <textarea class="form-control" name="project_details" id="project_details" rows="3" placeholder="Enter project description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="assignees">Assignees</label>
                        <select class="form-control" name="assigned_to[]" id="assignees" multiple onchange="handleAssigneeSelection(this)">
                            <?php foreach ($assignees as $assignee) : ?>
                                <option value="<?php echo esc_attr($assignee->ID); ?>"><?php echo esc_html($assignee->display_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="selectedAssignees"></div>
                    <div class="form-group">
                        <label for="dueDate">Due Date</label>
                        <input type="date" class="form-control" id="dueDate" name="due_date" min="<?php echo esc_attr(date('Y-m-d')); ?>">
                    </div>
                    <!-- Remove the stack input field -->
                    <div class="button">
                        <button type="submit" class="btn" name="submit" style="background-color: #5277D6;color: #ffffff;width: 50%;border-radius:10px ;">Create Project</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .main {
        float: right;
        margin-top: 5rem;
        width: 85%;
        height: 90vh;
        background-color: #ffffff;
        overflow-y: hidden;
    }

    .form-cont {
        background-color: #EBF0FF;
        padding: 40px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .form-cont:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .button {
        width: 100%;
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    h1 {
        color: #EB7017;
        display: flex;
        justify-content: center;
        margin: 40px;
    }

    #selectedAssignees {
        margin-bottom: 10px;
    }

    .selectedAssignee {
        display: inline-block;
        background-color: #ffffff;
        padding: 5px 10px;
        border-radius: 5px;
        border: 1px solid #ced4da;
        margin-right: 5px;
        margin-top: 5px;
    }

    #message {
        display: none;
        background-color: #4CAF50;
        color: white;
        padding: 15px;
        text-align: center;
        position: fixed;
        top: 0;
        left: 50%;
        transform: translate(-50%, 0);
        z-index: 9999;
        width: 300px;
    }
</style>

<script>
    function handleAssigneeSelection(select) {
        var selectedAssignees = document.getElementById('selectedAssignees');
        selectedAssignees.innerHTML = '';

        for (var i = 0; i < select.options.length; i++) {
            if (select.options[i].selected) {
                var assignee = document.createElement('span');
                assignee.className = 'selectedAssignee';
                assignee.textContent = select.options[i].text;
                selectedAssignees.appendChild(assignee);
            }
        }
    }
</script>

<?php get_footer(); ?>