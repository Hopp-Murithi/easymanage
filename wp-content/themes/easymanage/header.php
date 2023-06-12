<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <title>EasyManage</title>
    <?php wp_head() ?>
</head>

<body>
<style>
    .logo {
        font-size: 34px;
        font-weight: 600;
        margin-left: 15px;
    }

    li {
        margin-right: 12px;
    }

    .search {
        margin-right: 15rem;
        display: flex; 
        align-items: center;
    }

    .username {
        font-size: 24px;
        color: black;
    }

    .search-form {
        display: flex;color: #000;
        width:100%;
        align-items: center;
        margin-top: -5px;
    }

    .search-input {
        margin-right: 10px;
       
        height: 34px;
        padding: 4px 8px;
        font-size: 16px;
    }

    .search-button {
        height: 32px;
        padding: 4px 4px;
        font-size: 16px;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light" style="position:fixed;width:100%">
  <a class="navbar-brand logo" href="#">
    <span style="color:#5277D6;">Easy</span><span style="color:#EB7017;">Manage</span>
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
    <ul class="navbar-nav">
      <?php if (is_user_logged_in()) : ?>

        <!-- Searchbar -->
        <li class="nav-item search">
          <form class="form-inline my-2 my-lg-0 search-form">
            <div class="input-group">
              <input class="form-control search-input" type="search" placeholder="Search Members" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-outline-success search-button" type="submit">
                  <i class="bi bi-search" style="color:#000000"></i>
                </button>
              </div>
            </div>
          </form>
        </li>

        <!-- Username and icon -->
        <li class="nav-item">
          <a class="nav-link username" href="#">
          <i class="bi bi-person"style="color:#000000"></i> <?php echo wp_get_current_user()->display_name; ?> 
          </a>
        </li>

      <?php endif; ?>
    </ul>
  </div>
</nav>


