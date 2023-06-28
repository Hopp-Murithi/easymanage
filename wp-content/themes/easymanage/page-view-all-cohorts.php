<?php
get_header();
get_sidebar();
?>

<?php


// Fetch data from the API
$response = wp_remote_get('http://localhost/easymanage/wp-json/easymanage/v2/cohorts');

if (!is_wp_error($response)) {
    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body);

    if (!empty($data)) {
        echo '<div class="main">';
        echo '<div class="container">';
        echo '<div class="row" id="card-container">';

        foreach ($data as $index => $cohort) {
            $title = $cohort->programme_name;
            $place = $cohort->place;
            $starts_date = $cohort->starts_date;
            $end_date = $cohort->end_date;
            $assignees = $cohort->assigned_to;
            $assignee_array = explode(',', $assignees);
            $assignee_count = count($assignee_array);


            echo '<div class="col-md-4">';
            echo '<div class="card clickable-card" data-bs-toggle="modal" data-bs-target="#project-details-modal-' . $index . '" data-title="' . $title . '" data-stack="' . $place . '" data-due-date="' . $starts_date . '" data-assignees="' . htmlentities(json_encode($assignees)) . '">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . $title . '</h5>';
            echo '<div class="stack">';
            echo '<p class="card-text"><i class="bi bi-geo-alt-fill" style="color:black;margin-right:1rem;float:left;"></i></p>';
            echo '<p class="card-text">' . $place . '</p>';
            echo '</div>';
            echo '<hr>';
            echo '<div class="row">';
            echo '<div class="col-6">';
            echo '<p class="text-muted">Starts: ' . $starts_date . '</p>';
            echo '</div>';
            echo '<div class="col-6 text-end">';
            echo '<div class="assignee">';
            if ($assignee_count > 0) {
                $display_assignee = substr($assignee_array[0], 0, 4);
                echo '<p class="" style="display:flex;justify-content:center;align-items:center;padding:8px;">' . $display_assignee;

                if ($assignee_count > 0) {
                    echo '...';
                }

                echo '</p>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            // Modal for displaying project details
            echo '<div class="modal fade" id="project-details-modal-' . $index . '" tabindex="-1" aria-labelledby="project-details-modal-label-' . $index . '" aria-hidden="true">';
            echo '<div class="modal-dialog modal-dialog-centered">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="modal-project-title-' . $index . '">Cohort details</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo "<h5 class='card-title'>$title</h5>"; // Remove the duplicate id="modal-project-title"
            echo '<p id="modal-project-details-' . $index . '">  </p>';
            echo '<div class="stack">';
            echo '<p class="card-text"><i class="bi bi-geo-alt-fill" style="color:black;margin-right:1rem;float:left;"></i></p>';
            echo '<p class="card-text" id="modal-project-stack-' . $index . '"> ' . $place . ' </p>';
            echo '</div>';
            echo '<hr>';
            echo '<div class="row">';
            echo '<div class="col-6">';
            echo '<p class="text-muted" id="modal-due-date-' . $index . '">Starts on: ' . $starts_date . ' </p>';
            echo '<p class="text-muted" id="modal-due-date-' . $index . '">Ends on: ' . $end_date . ' </p>';
            echo '</div>';
            echo '<div class="col-6 text-end">';
            echo '<div class="assignee">';
            echo '<p id="modal-assignee-' . $index . '" style="display:flex;justify-content:center;align-items:center;padding:8px;"> ' . $assignees . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            // Display the "Mark Complete" button for logged-in trainees


            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
        echo '</div>'; // Closing tag for <div class="main">
    } else {
        echo '<p class="no-cohorts">No Cohorts found.</p>';
    }
} else {
    echo '<p>Error occurred while fetching data from the API.</p>';
}
?>

<?php
get_footer();
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .main {
        float: right;
        margin-top: 5rem;
        width: 85%;
        height: 90.5vh;
        background-color: #ffffff;
    }

    .card {
        background-color: #EDEDED;
        margin-top: 3rem;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .stack {
        display: flex;
        justify-content: center;
        background-color: #ffffff;
        padding: 5px;
        width: 70%;
        border-radius: 20px;
    }

    .assignee {
        background-color: #FFB580;
        width: 100%;
        border-radius: 20px;
    }

    p {
        font-size: 20px;
    }

    .no-cohorts {
        display: flex;
        color: red;
        justify-content: center;
        align-items: center;
        width: 100vw;
        height: 90vh;
        font-size: 40px;
    }
</style>

<script>
    // JavaScript code for handling modal and card click eventsa
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.getElementsByClassName('clickable-card');

        // Handle card click event
        for (let i = 0; i < cards.length; i++) {
            const card = cards[i];
            card.addEventListener('click', function() {
                const title = card.getAttribute('data-title');
                const stack = card.getAttribute('data-stack');
                const dueDate = card.getAttribute('data-due-date');
                const assignees = JSON.parse(html_entity_decode(card.getAttribute('data-assignees')));

                const modalTitle = document.getElementById('modal-project-title-' + i);
                const modalDetails = document.getElementById('modal-project-details-' + i);
                const modalStack = document.getElementById('modal-project-stack-' + i);
                const modalDueDate = document.getElementById('modal-due-date-' + i);
                const modalAssignee = document.getElementById('modal-assignee-' + i);

                modalTitle.innerText = title;
                modalDetails.innerText = 'Additional project details...';
                modalStack.innerText = stack;
                modalDueDate.innerText = 'Due: ' + dueDate;
                modalAssignee.innerHTML = '';

                if (assignees.length > 0) {
                    const p = document.createElement('p');
                    p.innerText = assignees[0].substr(0, 5);

                    if (assignees.length > 1) {
                        p.innerText += '...';
                    }

                    modalAssignee.appendChild(p);
                }
            });
        }
    });
</script>