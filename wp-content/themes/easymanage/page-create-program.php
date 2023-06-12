<?php get_header() ?>
<?php get_sidebar() ?>
<div class="main">
    <h1>New program </h1>
    <div class="container">




        <form style="width:100%;" method="post">


            <?php

            global $success_msg;

            if ($success_msg) {
                echo "<p id='message'>Project manager has been added successfully</p>";

                echo '<script> document.getElementById("message").style.display = "flex"; </script>';

                echo    '<script> 
                setTimeout(function(){
                    document.getElementById("message").style.display ="none";
                }, 3000);
            </script>';
            }
            ?>
            <div>
                <label for="name">Name</label>
                <input type="text" id='name' name="name" />
            </div>
            <div>
                <label for="email">Assign to</label>
                <input type="email" name="email" id='email' />
            </div>
        
            <div class="submit"> <input type="submit" name='submit' value="Create"></div>


        </form>
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


    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #D7DCE2;
        width: 50%;
        height: 40vh;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }
    .container:hover{
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
}
    h1 {
        color: #EB7017;
        display: flex;
        justify-content: center;
        margin: 15px;
    }
form{
    margin-top: -5rem;
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
        background-color: #7AFF85;
        ;
        color: #ffffff;
        border-radius: 5px;
        padding: 4px;
        font-size: 20px;
        font-weight: 400;
    }
</style>