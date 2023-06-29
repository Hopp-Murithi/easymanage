<?php get_header(); ?>
<?php get_sidebar(); ?>
<div class="main">

    <h1>Update program manager</h1>
    <?php
    global $success_msg;

    if ($success_msg) {
        echo "<p id='message'>Project manager has been updated successfully</p>";
        echo '<script> document.getElementById("message").style.display = "flex"; </script>';
        echo '<script> 
                setTimeout(function(){
                    document.getElementById("message").style.display ="none";
                }, 3000);
            </script>';
    }

    // Get the existing program manager data
    $manager_id = $_GET['manager_id'];
    $manager_data = wp_remote_get("http://localhost/easymanage/wp-json/easymanage/v2/manager/$manager_id");
    $manager_data = json_decode(wp_remote_retrieve_body($manager_data), true);

    if (isset($_POST['submit'])) {
        $managername = $_POST['managername'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // Update the program manager using the API endpoint
        $body = [
            'managername' => $managername,
            'email' => $email,
            'phone' => $phone
        ];

        $args = array(
            'body'        => $body,
            'method'      => 'POST',
        );

        $response = wp_remote_post("http://localhost/easymanage/wp-json/easymanage/v2/manager/$manager_id", $args);

        if (!is_wp_error($response)) {
            $response_data = json_decode(wp_remote_retrieve_body($response), true);
            // Display success message
            echo '<p id="message">Project manager has been updated successfully</p>';
            echo '<script> document.getElementById("message").style.display = "flex"; </script>';
            echo '<script> 
                    setTimeout(function(){
                        document.getElementById("message").style.display = "none";
                    }, 3000); 
                </script>';
        } else {
            // Display error message
            echo '<p id="message">Error: ' . $response['response']['message'] . '</p>';
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
            <div>
                <label for="name">Name</label>
                <input type="text" id="name" name="managername" value="<?php echo isset($manager_data['managername']) ? esc_attr($manager_data['managername']) : ''; ?>" />
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo isset($manager_data['email']) ? esc_attr($manager_data['email']) : ''; ?>" />
            </div>
            <div>
                <label for="phone">Phone Number</label>
                <input type="number" name="phone" id="phone" value="<?php echo isset($manager_data['phone']) ? esc_attr($manager_data['phone']) : ''; ?>" />
            </div>
            <div class="submit">
                <input type="submit" name="submit" value="Update">
            </div>
        </form>
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

<?php get_footer(); ?>
