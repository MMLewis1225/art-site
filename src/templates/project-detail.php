<?php
// Check if user is logged in
if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
    header("Location: index.php?command=login");
    exit();
}

// Get project data
$project = $project ?? null;
if (!$project) {
    header("Location: index.php?command=my_projects");
    exit();
}

// Make sure the project belongs to the current user
if ($project['user_id'] != $_SESSION["user_id"]) {
    header("Location: index.php?command=my_projects");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ava Lipshultz & Megan Lewis">
    <title><?php echo htmlspecialchars($project['title']); ?> - Art Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <header>
        <?php include("nav.php"); ?>
    </header>

    <div class="container py-4">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="index.php?command=my_projects" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Projects
            </a>
        </div>

        <div class="row">
            <!-- Project Details -->
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h1 class="card-title"><?php echo htmlspecialchars($project['title']); ?></h1>
                        
                        <div class="d-flex align-items-center text-muted mb-3">
                            <small>Created: <?php echo date("F j, Y", strtotime($project['created_at'])); ?></small>
                            <?php if ($project['created_at'] != $project['updated_at']): ?>
                                <small class="ms-3">Updated: <?php echo date("F j, Y", strtotime($project['updated_at'])); ?></small>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Project Image -->
                        <?php if (!empty($project['image_url'])): ?>
                            <div class="text-center my-4">
                                <img 
                                    src="<?php echo htmlspecialchars($project['image_url']); ?>" 
                                    class="img-fluid rounded" 
                                    alt="<?php echo htmlspecialchars($project['title']); ?>"
                                    style="max-height: 500px;"
                                    onerror="this.onerror=null; this.style.display='none'; document.getElementById('image-error').classList.remove('d-none');"
                                >
                                <div id="image-error" class="alert alert-warning mt-3 d-none">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    The image URL provided is not accessible. Please <a href="index.php?command=edit_project&project_id=<?php echo $project['project_id']; ?>">edit your project</a> to update it.
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Project Notes -->
                        <?php if (!empty($project['notes'])): ?>
                            <div class="my-4">
                                <h5>Notes</h5>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <?php echo nl2br(htmlspecialchars($project['notes'])); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-md-4">
                <!-- Actions -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Actions</h5>
                        <div class="d-grid gap-2">
                            <a href="index.php?command=edit_project&project_id=<?php echo $project['project_id']; ?>" class="btn btn-primary">
                                <i class="bi bi-pencil me-1"></i> Edit Project
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProjectModal">
                                <i class="bi bi-trash me-1"></i> Delete Project
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Connected Content -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Connected Content</h5>
                        
                        <!-- Connected Challenge -->
                        <?php if (isset($project['challenge_id']) && !empty($project['challenge_id'])): ?>
                            <div class="mb-3">
                                <h6 class="text-muted">Challenge</h6>
                                <div class="card bg-light">
                                    <div class="card-body py-2">
                                        <h6><?php echo htmlspecialchars($project['challenge_title']); ?></h6>
                                        <p class="small mb-1">
                                            <?php 
                                                echo htmlspecialchars(substr($project['challenge_description'], 0, 100));
                                                if (strlen($project['challenge_description']) > 100) echo '...';
                                            ?>
                                        </p>
                                        <a href="index.php?command=challenge_details&id=<?php echo $project['challenge_id']; ?>" class="btn btn-sm btn-outline-secondary">
                                            View Challenge
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Connected Prompt -->
                        <?php if (isset($project['prompt_id']) && !empty($project['prompt_id'])): ?>
                            <div>
                                <h6 class="text-muted">Prompt</h6>
                                <div class="card bg-light">
                                    <div class="card-body py-2">
                                        <p class="small mb-1">
                                            <?php echo htmlspecialchars($project['prompt_text']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!isset($project['challenge_id']) && !isset($project['prompt_id'])): ?>
                            <div class="alert alert-info mb-0">
                                <small>No challenges or prompts connected.</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this art project? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="index.php?command=delete_project">
                        <input type="hidden" name="project_id" value="<?php echo $project['project_id']; ?>">
                        <button type="submit" class="btn btn-danger">Delete Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="container pt-3 mt-4 text-body-secondary border-top">
        <p>© 2025. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>