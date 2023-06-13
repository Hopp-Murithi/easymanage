<?php
get_header();
get_sidebar();
wp_head();
?>
<div class="main">

  <div class="container">
    <div class="row">
      <h1>Team Overview</h1>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <i class="bi bi-people icon"></i>
            <h5 class="card-title">Total Members</h5>
            <p class="card-text"><?php echo get_user_count_by_role('program_manager') + get_user_count_by_role('trainer') + get_user_count_by_role('trainee') ; ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <i class="bi bi-people icon"></i>
            <h5 class="card-title">Program Managers</h5>
            <p class="card-text"><?php echo get_user_count_by_role('program_manager'); ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <i class="bi bi-people icon"></i>
            <h5 class="card-title">Trainers</h5>
            <p class="card-text"><?php echo get_user_count_by_role('trainer'); ?></p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <i class="bi bi-people icon"></i>
            <h5 class="card-title">Trainees</h5>
            <p class="card-text"><?php echo get_user_count_by_role('trainee'); ?></p>
          </div>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <h1>Projects Overview</h1>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <i class="bi bi-bar-chart-line-fill icon"></i>
            <h5 class="card-title">Completed projects</h5>
            <p class="card-text">10</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <i class="bi bi-bar-chart-line-fill icon"></i>
            <h5 class="card-title">Pending projects...</h5>
            <p class="card-text">7</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <i class="bi bi-bar-chart-line-fill icon"></i>
            <h5 class="card-title">In review...</h5>
            <p class="card-text">2</p>
          </div>
        </div>
      </div>
    </div>

    <br>

    <h1>Newest Member</h1>
    <?php
    $latest_member = get_users([
      'number' => 1,
      'orderby' => 'registered',
      'order' => 'DESC',
    ]);
    if (!empty($latest_member)) {
      $latest_member = $latest_member[0];
      ?>
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Role</th>
          </tr>
        </thead>
        <tbody style="background-color:#EBF0FF ;">
          <tr>
            <td><?php echo esc_html($latest_member->display_name); ?></td>
            <td><?php echo esc_html($latest_member->user_email); ?></td>
            <td>
              <span class="badge bg-success text-white">Active</span>
            </td>
            <td><?php echo esc_html(implode(', ', $latest_member->roles)); ?></td>
          </tr>
        </tbody>
      </table>
    <?php } else { ?>
      <p>No members found.</p>
    <?php } ?>
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

  .icon {
    display: inline-block;
    font-size: 1.5rem;
    font-weight: 400;
    line-height: 1;
    text-align: center;
    text-transform: none;
    vertical-align: -.125em;
    color: #EB7017;
  }

  p {
    padding: 5px;
    font-size: 38px;
    color: #5277D6;
    font-weight: 600;
  }

  .card {
    background-color: #EBF0FF;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  }

  .card:hover {
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
  }
</style>

<?php get_footer(); ?>

<?php
function get_user_count_by_role($role)
{
  global $wpdb;
  $count = $wpdb->get_var($wpdb->prepare(
    "SELECT COUNT(*) FROM $wpdb->users 
    INNER JOIN $wpdb->usermeta ON ($wpdb->users.ID = $wpdb->usermeta.user_id) 
    WHERE $wpdb->usermeta.meta_key = %s 
    AND $wpdb->usermeta.meta_value LIKE %s",
    $wpdb->prefix . 'capabilities',
    '%"'.$role.'"%'
  ));
  return $count;
}
?>
