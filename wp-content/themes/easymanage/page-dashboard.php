<?php get_header()?>
<?php get_sidebar() ?>
<?php wp_head() ?>
<div class="main" >

<div class="container">
  <div class="row">
  <h1>Team Overview</h1>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
        <i class="bi bi-people icon"></i>
          <h5 class="card-title">Project managers</h5>
          <p class="card-text">3</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
        <i class="bi bi-people icon"></i>
          <h5 class="card-title">Trainers</h5>
          <p class="card-text">7</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
        <i class="bi bi-people icon"></i>
          <h5 class="card-title">Trainees</h5>
          <p class="card-text">25</p>
        </div>
      </div>
    </div>
  </div>
  <br>
  <div class="row">
  <h1>Projects overview</h1>
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
p{
    padding: 5px;
    font-size: 38px;
    color: #5277D6;
    font-weight: 600;
}
.card{
    background-color: #EBF0FF;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}
.card:hover{
    box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
}
</style>