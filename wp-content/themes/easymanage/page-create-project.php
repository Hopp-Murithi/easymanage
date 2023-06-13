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
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="form-cont">
                    <div class="form-group">
                        <label for="projectTitle">Project Title</label>
                        <input type="text" class="form-control" id="projectTitle" placeholder="Enter project title" required>
                    </div>
                    <div class="form-group">
                        <label for="projectDescription">Project Description</label>
                        <textarea class="form-control" id="projectDescription" rows="3" placeholder="Enter project description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="assignees">Assignees</label>
                        <select class="form-control" id="assignees" multiple onchange="handleAssigneeSelection(this)">
                            <?php foreach ($assignees as $assignee) : ?>
                                <option value="<?php echo esc_attr($assignee->ID); ?>"><?php echo esc_html($assignee->display_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="selectedAssignees"></div>
                    <div class="form-group">
                        <label for="dueDate">Due Date</label>
                        <input type="date" class="form-control" id="dueDate" min="<?php echo esc_attr(date('Y-m-d')); ?>" required>
                    </div>
                    <div class="button">
                        <button type="submit" class="btn" style="background-color: #5277D6;color: #ffffff;width: 50%;border-radius:10px ;">Create Ticket</button>
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
        background-color: #e9ecef;
        padding: 5px 10px;
        border-radius: 4px;
        margin-right: 5px;
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
