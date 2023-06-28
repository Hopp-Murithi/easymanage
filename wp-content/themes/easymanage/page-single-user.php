<?php get_header(); ?>
<?php get_sidebar(); ?>

<div class="main">
    <h1>Account info</h1>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" style="font-size: 18px;">
                        <?php
                        $current_user_id = get_current_user_id();

                        if ($current_user_id) {
                            $user = get_user_by('ID', $current_user_id);

                            if ($user) {
                                $name = $user->display_name;
                                $role = implode(', ', $user->roles);
                                $phone = get_user_meta($current_user_id, 'phone_number', true);
                                $email = $user->user_email;
                                ?>
                                <h5 class="card-title" style="font-size: 24px;"><?php echo $name; ?></h5>
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

    .card {
        background-color: #EBF0FF;
        padding: 40px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .card-title {
        color: #EB7017;
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .card-text {
        font-size: 18px;
    }

    h1 {
        color: #EB7017;
        display: flex;
        justify-content: center;
        margin: 15px;
    }
</style>

<?php get_footer(); ?>
