<?php get_header() ?>

<?php wp_head();?>

<div class="form-container">
    <form class="form-inside" action="" method="POST">
        <div class="form">
        <div style="display:flex;justify-content:center;font-size:40px;color:#EB7017;font-weight:500;margin-top:-90px;">
    <?php
    $timezone = new DateTimeZone('Africa/Nairobi');
    $date = new DateTime('now', $timezone);
    $current_hour = $date->format('G');



    $period = '';


    if ($current_hour >= 5 && $current_hour < 12) {
      $period = 'Morning';
    } elseif ($current_hour >= 12 && $current_hour < 18) {
      $period = 'Afternoon';
    } else {
      $period = 'Evening';
    }



    echo 'Good ' . $period. '!'  ;
    ?>
  </div>
            <div class="input1">
                <label for="employee-number">Email:</label>
                <input type="email" placeholder="Enter email" name="email">
            </div>
            <div class="input1">
                <label for="">Password:</label>
                <input type="password" placeholder="Enter password" name="password">
            </div>
            <button type="submit" style="margin-top: 40px;" class="btnreg" name="login">Login</button>
        </div>
    </form>
</div>
