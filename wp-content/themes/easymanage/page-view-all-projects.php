<?php get_header(); 
 get_sidebar(); 

 $user = wp_get_current_user();
 $user_roles = $user->roles;
?>

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card clickable-card" data-bs-toggle="modal" data-bs-target="#project-details-modal">
                    <div class="card-body" id="project-card">
                        <h5 class="card-title">Create YouTube Streaming API</h5>
                        <div class="stack">
                            <p class="card-text">WordPress</p>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <p class="text-muted">Due: June 30th</p>
                            </div>
                            <div class="col-6 text-end">
                                <div class="assignee">
                                    <p class="" style="display:flex;justify-content:center;align-items:center;padding:8px;">John Doe</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card clickable-card" data-bs-toggle="modal" data-bs-target="#project-details-modal">
                    <div class="card-body" id="project-card">
                        <h5 class="card-title">Create YouTube Streaming API</h5>
                        <div class="stack">
                            <p class="card-text">WordPress</p>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <p class="text-muted">Due: June 30th</p>
                            </div>
                            <div class="col-6 text-end">
                                <div class="assignee">
                                    <p class="" style="display:flex;justify-content:center;align-items:center;padding:8px;">John Doe</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card clickable-card" data-bs-toggle="modal" data-bs-target="#project-details-modal">
                    <div class="card-body" id="project-card">
                        <h5 class="card-title">Create YouTube Streaming API</h5>
                        <div class="stack">
                            <p class="card-text">WordPress</p>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <p class="text-muted">Due: June 30th</p>
                            </div>
                            <div class="col-6 text-end">
                                <div class="assignee">
                                    <p class="" style="display:flex;justify-content:center;align-items:center;padding:8px;">John Doe</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card clickable-card" data-bs-toggle="modal" data-bs-target="#project-details-modal">
                    <div class="card-body" id="project-card">
                        <h5 class="card-title">Create YouTube Streaming API</h5>
                        <div class="stack">
                            <p class="card-text">WordPress</p>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <p class="text-muted">Due: June 30th</p>
                            </div>
                            <div class="col-6 text-end">
                                <div class="assignee">
                                    <p class="" style="display:flex;justify-content:center;align-items:center;padding:8px;">John Doe</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card clickable-card" data-bs-toggle="modal" data-bs-target="#project-details-modal">
                    <div class="card-body" id="project-card">
                        <h5 class="card-title">Create YouTube Streaming API</h5>
                        <div class="stack">
                            <p class="card-text">WordPress</p>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <p class="text-muted">Due: June 30th</p>
                            </div>
                            <div class="col-6 text-end">
                                <div class="assignee">
                                    <p class="" style="display:flex;justify-content:center;align-items:center;padding:8px;">John Doe</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card clickable-card" data-bs-toggle="modal" data-bs-target="#project-details-modal">
                    <div class="card-body" id="project-card">
                        <h5 class="card-title">Create YouTube Streaming API</h5>
                        <div class="stack">
                            <p class="card-text">WordPress</p>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <p class="text-muted">Due: June 30th</p>
                            </div>
                            <div class="col-6 text-end">
                                <div class="assignee">
                                    <p class="" style="display:flex;justify-content:center;align-items:center;padding:8px;">John Doe</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
    <!-- Modal for displaying project details -->
    <div class="modal fade" id="project-details-modal" tabindex="-1" aria-labelledby="project-details-modal-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="project-details-modal-label">Project Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Create YouTube Streaming API</h5>
                                <p>Additional project details...</p>

                                <div class="stack">
                                    <p class="card-text">WordPress</p>
                                </div>
                                <hr>
                                <div class="row">
                            <div class="col-6">
                                <p class="text-muted">Due: June 30th</p>
                            </div>
                            <div class="col-6 text-end">
                                <div class="assignee">
                                    <p class="" style="display:flex;justify-content:center;align-items:center;padding:8px;">John Doe</p>
                                </div>
                            </div>
                        </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <?php  
                    if (in_array('trainee', $user_roles)) {
                        
                        echo '<button type="submit" class="btn btn-success">Mark Complete</button>';
                    }
                    ?>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                 </div>
            </div>
        </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .main {
        float: right;
        margin-top: 5rem;
        width: 85%;
        height: 90.5vh;
        background-color: #ffffff;
    }

    .card {
        background-color: #EDEDED;
        margin-top: 3rem;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    .stack {
        display: flex;
        justify-content: center;
        background-color: #ffffff;
        padding: 5px;
        width: 40%;
        border-radius: 20px;
    }

    .assignee {
        /* display: flex;
        justify-content: center;
        align-items: center;  */
        background-color: #FFB580;
        margin-left: 40px;
        width: 70%;
        border-radius: 20px;
    }

    p {
        font-size: 20px;
    }
</style>
