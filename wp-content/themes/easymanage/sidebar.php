<?php wp_head();

// Get the current user role
$user = wp_get_current_user();
$user_roles = $user->roles;

// Define menu options based on user roles
$admin_menu = array(
  array('icon' => 'bi bi-house', 'text' => 'Home', 'link' => 'http://localhost/easymanage/dashboard/'),
  array('icon' => 'bi bi-person-plus', 'text' => 'Add Program Manager', 'link' => 'http://localhost/easymanage/create-manager/'),
  array('icon' => 'bi bi-people', 'text' => 'View All Members', 'link' => 'http://localhost/easymanage/view-members/'),
  array('icon' => 'bi bi-file-earmark-text', 'text' => 'View All Projects', 'link' => 'http://localhost/easymanage/view-all-projects/'),
  array('icon' => 'bi bi-gear', 'text' => 'Admin Panel', 'link' => 'http://localhost/easymanage/wp-admin/')
);

$program_manager_menu = array(
  array('icon' => 'bi bi-house', 'text' => 'Home', 'link' => 'http://localhost/easymanage/dashboard/'),
  array('icon' => 'bi bi-person-plus', 'text' => 'Add Trainer', 'link' => 'http://localhost/easymanage/create-trainer/'),
  array('icon' => 'bi bi-bag-plus-fill', 'text' => 'Create Program', 'link' => 'http://localhost/easymanage/create-program/'),
  array('icon' => 'bi bi-people', 'text' => 'View All Members', 'link' => 'http://localhost/easymanage/view-members/'),
  array('icon' => 'bi bi-file-earmark-text', 'text' => 'View All Projects', 'link' => 'http://localhost/easymanage/view-all-projects/')
);

$trainer_menu = array(
  array('icon' => 'bi bi-house', 'text' => 'Home', 'link' => 'http://localhost/easymanage/dashboard/'),
  array('icon' => 'bi bi-person-plus', 'text' => 'Add Trainee', 'link' => 'http://localhost/easymanage/create-trainee/'),
  array('icon' => 'bi bi-people', 'text' => 'View Team Members', 'link' => 'http://localhost/easymanage/view-members/'),
  array('icon' => 'bi bi-file-earmark-text', 'text' => 'View Team Projects', 'link' => 'http://localhost/easymanage/view-all-projects/'),
  array('icon' => 'bi bi-file-earmark-plus', 'text' => 'Create New Project', 'link' => 'http://localhost/easymanage/create-project/')
);

$trainee_menu = array(
  array('icon' => 'bi bi-house', 'text' => 'Home', 'link' => 'http://localhost/easymanage/view-all-projects/'),
  array('icon' => 'bi bi-file-earmark-check', 'text' => 'Completed Projects', 'link' => 'http://localhost/easymanage/view-all-projects/')
);

$menu_options = array();

// Set menu options based on user role
if (in_array('administrator', $user_roles)) {
  $menu_options = $admin_menu;
} elseif (in_array('program_manager', $user_roles)) {
  $menu_options = $program_manager_menu;
} elseif (in_array('trainer', $user_roles)) {
  $menu_options = $trainer_menu;
} elseif (in_array('trainee', $user_roles)) {
  $menu_options = $trainee_menu;
}

?>

<div class="">
  <div class="row">
    <div class="col-md-3 p-0">
      <!-- Sidebar -->
      <div class="sidebar">
        <?php foreach ($menu_options as $option) : ?>
          <?php $is_active = (strpos($_SERVER['REQUEST_URI'], $option['link']) !== false); ?>
          <a href="<?php echo $option['link']; ?>" class="menu-link <?php if ($is_active) echo 'active'; ?>">
            <i class="<?php echo $option['icon']; ?> menu-icon"></i>
            <span class="menu-text"><?php echo $option['text']; ?></span>
            <span class="debug"><?php echo $is_active ? 'ACTIVE' : ''; ?></span>
          </a>
        <?php endforeach; ?>

        <div class="logout">
          <div class="logout-body">
            <ul style="list-style-type: none;">
              <li class="nav-item logout-icon">
                <a class="nav-link username" style="color:#ffffff;font-size:18px;" href="#">
                  <i class="bi bi-person-circle" style="color:#ffffff;font-size:25px;"></i> <?php echo wp_get_current_user()->display_name; ?>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<style>
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    margin-top: 5rem;
    background-color: #5277D6;
    color: #fff;
    padding: 20px;
    height: 100%;
    display: flex;
    flex-direction: column;
  }

  .logout {
    display: flex;
    justify-content: start;
    padding: 5px;
    margin-top: auto;
    border-top: 2px solid #fff;
    width: 100%;
    margin-bottom: 70px;
    color: #ffffff;
  }

  .menu-link {
    display: flex;
    align-items: center;
    font-size: 20px;
    font-weight: 500;
    color: #fff;
    padding: 8px;
    text-decoration: none;
    margin-bottom: 10px;
    border-bottom: 2px solid #fff;
  }

  .menu-link:hover {
    color: #000000;
  }

  .menu-link.active,
  .menu-link.active .menu-text,
  .menu-link.active .menu-icon {
    color: red;
    /* Change this color to the desired active menu color */
  }

  .menu-icon {
    font-size: 20px;
    margin-right: 10px;
  }

  .menu-text {
    font-size: 16px;
  }

  .logout-body {
    margin-top: 12px;
    margin-left: -12px;
  }

  .logout-text:hover {
    color: red;
  }

  .bi {
    display: inline-block;
    font-size: 1.5rem;
    font-weight: 400;
    line-height: 1;
    text-align: center;
    text-transform: none;
    vertical-align: -.125em;
    color: #ffffff;
  }
</style>