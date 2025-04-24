<?php
// Check if user is logged in
if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
    header("Location: index.php?command=login");
    exit();
}

// Get user projects
$userId = $_SESSION["user_id"];
$projects = $projects ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ava Lipshultz & Megan Lewis">
    <title>My Art Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
    <header>
        <?php include("nav.php"); ?>
    </header>

    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold mb-3">My Art Projects</h1>
                <p class="lead">View and manage your documented artwork.</p>
            </div>
            <div class="col-md-4 text-md-end d-flex align-items-center justify-content-md-end mt-3 mt-md-0">
                <a href="index.php?command=create_art" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Create New Project
                </a>
            </div>
        </div>

        <?php if (isset($_SESSION["success"])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION["success"]; ?>
                <?php unset($_SESSION["success"]); ?>
            </div>
        <?php endif; ?>

        <?php if (empty($projects)): ?>
            <div class="alert alert-info">
                <p>You haven't created any art projects yet. <a href="index.php?command=create_art">Create your first project</a> to document your art journey!</p>
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($projects as $project): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                          <!--  <?php if (!empty($project['image_url'])): ?>
                                <img 
                                    src="<?php echo htmlspecialchars($project['image_url']); ?>" 
                                    class="card-img-top" 
                                    alt="<?php echo htmlspecialchars($project['title']); ?>"
                                    style="height: 200px; object-fit: cover;"
                                    onerror="this.onerror=null; this.src='data:image/svg+xml;charset=UTF-8,%3Csvg width=\'100%\' height=\'200\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'100%\' height=\'100%\' fill=\'%23f8f9fa\'/%3E%3Ctext x=\'50%\' y=\'50%\' font-size=\'14\' text-anchor=\'middle\' alignment-baseline=\'middle\' fill=\'%23adb5bd\'%3EImage unavailable%3C/text%3E%3C/svg%3E';"
                                >
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <div class="text-center text-muted">
                                        <i class="bi bi-image" style="font-size: 3rem;"></i>
                                        <p class="mt-2">No image provided</p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            -->      
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($project['title']); ?></h5>
                                
                                <?php if (!empty($project['notes'])): ?>
                                    <p class="card-text small text-truncate">
                                        <?php echo htmlspecialchars(substr($project['notes'], 0, 100)); ?>
                                        <?php echo strlen($project['notes']) > 100 ? '...' : ''; ?>
                                    </p>
                                <?php endif; ?>
                                
                                <?php if (!empty($project['challenge_title'])): ?>
                                    <div class="mb-2">
                                        <span class="badge bg-dark">Challenge</span>
                                        <small><?php echo htmlspecialchars($project['challenge_title']); ?></small>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted">
                                        <?php echo date("M j, Y", strtotime($project['created_at'])); ?>
                                    </small>
                                    <div class="btn-group btn-group-sm">
                                        <a href="index.php?command=view_project&project_id=<?php echo $project['project_id']; ?>" class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="index.php?command=edit_project&project_id=<?php echo $project['project_id']; ?>" class="btn btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger delete-project-btn" data-bs-toggle="modal" data-bs-target="#deleteProjectModal" data-project-id="<?php echo $project['project_id']; ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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
                    <form id="deleteProjectForm" method="POST" action="index.php?command=delete_project">
                        <input type="hidden" id="deleteProjectId" name="project_id" value="">
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
    <script>
        // Handle delete project button clicks
        document.querySelectorAll('.delete-project-btn').forEach(button => {
            button.addEventListener('click', function() {
                const projectId = this.getAttribute('data-project-id');
                document.getElementById('deleteProjectId').value = projectId;
            });
        });
    </script>
</body>
</html>
