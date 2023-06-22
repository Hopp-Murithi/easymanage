<?php
/**
 * Template Name: New Program Template
 */

get_header();
get_sidebar();

$assignees_query = new WP_User_Query(array(
    'role' => 'trainer',
));

$assignees = $assignees_query->get_results();
?>

<div class="main">
    <h1>New program</h1>
    <div class="container">
        <form style="width:100%;" method="post">
            <?php
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

            <div>
                <label for="name">Program name</label>
                <input type="text" id="name" name="name" />
            </div>

            <div class="form-group">
                        <label for="assignees">Assign to:</label>
                        <select class="form-control" id="assignees">
                            <?php foreach ($assignees as $assignee) : ?>
                                <option value="<?php echo esc_attr($assignee->ID); ?>"><?php echo esc_html($assignee->display_name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

            <div>
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" id="start_date"  min="<?php echo esc_attr(date('Y-m-d')); ?>" />
            </div>

            <div>
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" id="end_date"  min="<?php echo esc_attr(date('Y-m-d')); ?>" />
            </div>

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
        /* height: 40vh; */
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
        border-radius: 5px;
        padding: 4px;
        font-size: 20px;
        font-weight: 400;
    }
</style>

<?php get_footer(); ?>
