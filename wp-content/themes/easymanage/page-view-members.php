<?php get_header()?>
<?php get_sidebar() ?>
<div class="main" >

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Members List</h1>
            <?php echo do_shortcode('[display_table]'); ?>
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