<?php
get_header();
get_sidebar();

// Query to get the list of assignees
$assignees_query = new WP_User_Query(array(
    'role' => 'trainee',
));

$assignees = $assignees_query->get_results();
?>


<div class="main">
    <h1>New Project</h1>

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

    if ( isset($_POST['submit'])) {
        $project_name = $_POST['project_name'];
        $project_details = $_POST['project_details'];
        $assigned_to = $_POST['assigned_to'];
        $due_date = $_POST['due_date'];
        $stack = $_POST['stack'];

        // Create the program manager using the API endpoint
        global $wpdb;
        $wpdb->get_results("SELECT * FROM wp_users WHERE user_login = ''");



        $body = [
            'project_name' => $project_name,
            'project_details' => $project_details,
            'due_date' => $due_date,
            'assigned_to' => $assigned_to,
            'stack' => $stack,
            
        ];

        $args = array(
            'body'        => $body,
            'method'=> 'POST',
            // 'headers'     => array(
            //     'Content-Type: application/json',
            //     'Authorization: Bearer '.$token
            // ),
           
        );

        $response = wp_remote_post( 'hhttp://localhost/easymanage/wp-json/easymanage/v2/project', $args );
    
// var_dump($response);

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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="form-cont">
                    <div class="form-group">
                        <label for="projectTitle">Project Title</label>
                        <input type="text"  name="project_name" class="form-control" id="projectTitle" placeholder="Enter project title" required>
                    </div>
                    <div class="form-group">
                        <label for="project_details">Project Description</label>
                        <textarea class="form-control" name="project_details" id="project_details" rows="3" placeholder="Enter project description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="assignees">Assignees</label>
                        <select class="form-control" name="assigned_to" id="assignees" multiple onchange="handleAssigneeSelection(this)">
                            <?php foreach ($assignees as $assignee) : ?>
                                <option value="<?php echo esc_attr($assignee->ID); ?>"><?php echo esc_html($assignee->display_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="selectedAssignees"></div>
                    <div class="form-group">
                        <label for="dueDate">Due Date</label>
                        <input type="date" class="form-control" id="dueDate" name="due_date" min="<?php echo esc_attr(date('Y-m-d')); ?>" required>
                    </div>
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
        height: 90.5vh;
        background-color: #ffffff;
    }

    .form-cont {
        background-color: #EBF0FF;
        padding: 40px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }
    .form-cont:hover{
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
        border-radius: 4px;
        margin-right: 5px;
        margin-top: 1rem;
    }

    .selectedAssignee span {
        
        margin-left: 5px;
        cursor: pointer;
    }
</style>

<script>
    function handleAssigneeSelection(select) {
        var selectedAssigneesDiv = document.getElementById('selectedAssignees');
        selectedAssigneesDiv.innerHTML = ''; // Clear previous selections

        var selectedOptions = Array.from(select.selectedOptions);

        selectedOptions.forEach(function(option) {
            var userId = option.value;
            var displayName = option.text;

            // Create a new div element for the selected assignee
            var assigneeDiv = document.createElement('div');
            assigneeDiv.classList.add('selectedAssignee');
            assigneeDiv.innerHTML = displayName;

            // Create a hidden input field to store the assignee ID
            var assigneeInput = document.createElement('input');
            assigneeInput.type = 'hidden';
            assigneeInput.name = 'assignees[]';
            assigneeInput.value = userId;

            // Append the div and input to the selectedAssigneesDiv
            selectedAssigneesDiv.appendChild(assigneeDiv);
            selectedAssigneesDiv.appendChild(assigneeInput);
        });
    }
</script>
