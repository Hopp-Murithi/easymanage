<?php 
get_header();?>
<?php get_sidebar()
?>

<div class="main">
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <?php
                        if (isset($_GET['id'])) {
                            $user_id = intval($_GET['id']);
                            $user = get_user_by('ID', $user_id);

                            if ($user) {
                                $name = $user->display_name;
                                $role = implode(', ', $user->roles);
                                $phone = get_user_meta($user_id, 'phone_number', true);
                                $email = $user->user_email;
                        ?>
                                <h5 class="card-title">$name</h5>
                                <div class="card-text">
                                    <p><strong>Name:</strong> <?php echo $name; ?></p>
                                    <p><strong>Role:</strong> <?php echo $role; ?></p>
                                    <p><strong>Phone Number:</strong> <?php echo $phone; ?></p>
                                    <p><strong>Email:</strong> <?php echo $email; ?></p>
                                </div>
                        <?php
                            } else {
                                echo '<p>User not found.</p>';
                            }
                        } else {
                            echo '<p>User ID not specified in the URL.</p>';
                        }
                        ?>
                    </div>
                </div>
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

    h1 {
        color: #EB7017;
        display: flex;
        justify-content: center;
        margin: 15px;
    }
</style>