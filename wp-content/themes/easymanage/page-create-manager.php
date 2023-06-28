<?php get_header() ?>
<?php get_sidebar() ?>
<div class="main">

    <h1>New program manager</h1>
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
        $managername = $_POST['managername'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // Create the program manager using the API endpoint
        $body = [
            'managername' => $managername,
            'email' => $email,
            'phone' => $phone
        ];

        $args = array(
            'body'        => $body,
            'method'      => 'POST',
        );

        $response = wp_remote_post('http://localhost/easymanage/wp-json/easymanage/v2/manager', $args);

        if (!is_wp_error($response)) {
            $response_data = json_decode(wp_remote_retrieve_body($response), true);
            // Display success message
            echo '<p id="message">Project manager has been added successfully</p>';
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
                <input type="text" id="name" name="managername" />
            </div>
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" />
            </div>
            <div>
                <label for="phone">Phone Number</label>
                <input type="number" name="phone" id="phone" />
            </div>
            <div class="submit">
                <input type="submit" name="submit" value="Create">
            </div>
        </form>
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

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #EBF0FF;
        width: 50%;
        height: 60vh;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .container:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    h1 {
        color: #EB7017;
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
    input[type="email"] {
        padding: 5px;
        margin-bottom: 10px;
        width: 100%;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #5277D6;
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
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #7AFF85;
        color: #ffffff;
        width: 100%;
        border-radius: 5px;
        padding: 4px;
        font-size: 20px;
        font-weight: 400;
    }
</style>

<?php get_footer(); ?>
