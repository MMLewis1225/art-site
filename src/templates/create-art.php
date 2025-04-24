<?php
// Check if user is logged in
if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
    header("Location: index.php?command=login");
    exit();
}

// Get any saved prompts for this user
$userId = $_SESSION["user_id"];
$savedPrompts = $savedPrompts ?? [];

// Get challenges for user to link
$challenges = $challenges ?? [];

// Get any prompt or challenge IDs passed in the URL
$promptId = isset($_GET["prompt_id"]) ? $_GET["prompt_id"] : null;
$challengeId = isset($_GET["challenge_id"]) ? $_GET["challenge_id"] : null;

// If editing existing project
$editing = isset($_GET["project_id"]);
$project = $project ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ava Lipshultz & Megan Lewis">
    <title><?php echo $editing ? 'Edit Art Project' : 'Create New Art Project'; ?></title>
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
            <div class="col-12">
                <h1 class="display-5 fw-bold mb-3"><?php echo $editing ? 'Edit Art Project' : 'Create New Art Project'; ?></h1>
                <p class="lead">Document your artistic creation to keep track of your progress and inspiration.</p>
            </div>
        </div>

        <?php if (isset($_SESSION["error"])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION["error"]; ?>
                <?php unset($_SESSION["error"]); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION["success"])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION["success"]; ?>
                <?php unset($_SESSION["success"]); ?>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="index.php?command=<?php echo $editing ? 'update_project&project_id=' . $_GET['project_id'] : 'save_project'; ?>">
                    <!-- Project Title -->
                    <div class="mb-3">
                        <label for="projectTitle" class="form-label">Project Title *</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="projectTitle" 
                            name="projectTitle" 
                            required
                            value="<?php echo $editing && $project ? htmlspecialchars($project['title']) : ''; ?>"
                        >
                    </div>

                    <!-- Project Notes -->
                    <div class="mb-3">
                        <label for="projectNotes" class="form-label">Notes</label>
                        <textarea 
                            class="form-control" 
                            id="projectNotes" 
                            name="projectNotes" 
                            rows="5" 
                            placeholder="Describe your art project, your process, techniques used, or any other notes..."
                        ><?php echo $editing && $project ? htmlspecialchars($project['notes']) : ''; ?></textarea>
                    </div>

                    <!-- Image URL -->
                    <div class="mb-3">
                        <label for="imageUrl" class="form-label">Image URL</label>
                        <input 
                            type="url" 
                            class="form-control" 
                            id="imageUrl" 
                            name="imageUrl" 
                            placeholder="https://example.com/your-image.jpg"
                            value="<?php echo $editing && $project ? htmlspecialchars($project['image_url']) : ''; ?>"
                        >
                        <div class="form-text">
                            Add a link to your artwork image on any hosting service, social media, or cloud storage.
                        </div>
                    </div>

                    <!-- Associated Prompt Section -->
                    <div class="mb-3">
                        <label class="form-label">Connected Prompt</label>
                        
                        <?php if (empty($savedPrompts)): ?>
                            <div class="alert alert-info">
                                You don't have any saved prompts. <a href="index.php?command=generator">Generate and save a prompt</a> to connect it to your artwork.
                            </div>
                        <?php else: ?>
                            <select class="form-select" name="promptId">
                                <option value="">-- No prompt selected --</option>
                                <?php foreach ($savedPrompts as $prompt): ?>
                                    <option 
                                        value="<?php echo $prompt['prompt_id']; ?>"
                                        <?php echo ($editing && $project && $project['prompt_id'] == $prompt['prompt_id']) || (!$editing && $promptId == $prompt['prompt_id']) ? 'selected' : ''; ?>
                                    >
                                        <?php echo htmlspecialchars(substr($prompt['prompt_text'], 0, 100) . (strlen($prompt['prompt_text']) > 100 ? '...' : '')); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>

                    <!-- Associated Challenge Section -->
                    <div class="mb-3">
                        <label class="form-label">Connected Challenge</label>
                        
                        <?php if (empty($challenges)): ?>
                            <div class="alert alert-info">
                                <a href="index.php?command=challenge_search">Browse challenges</a> to connect one to your artwork.
                            </div>
                        <?php else: ?>
                            <select class="form-select" name="challengeId">
                                <option value="">-- No challenge selected --</option>
                                <?php foreach ($challenges as $challenge): ?>
                                    <option 
                                        value="<?php echo $challenge['challenge_id']; ?>"
                                        <?php echo ($editing && $project && $project['challenge_id'] == $challenge['challenge_id']) || (!$editing && $challengeId == $challenge['challenge_id']) ? 'selected' : ''; ?>
                                    >
                                        <?php echo htmlspecialchars($challenge['title']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="index.php?command=my_projects" class="btn btn-outline-secondary me-md-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <?php echo $editing ? 'Update Project' : 'Save Project'; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="container pt-3 mt-4 text-body-secondary border-top">
        <p>© 2025. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview image when URL is entered
        const imageUrlInput = document.getElementById('imageUrl');
        const previewContainer = document.createElement('div');
        previewContainer.className = 'mt-2 d-none';
        previewContainer.innerHTML = '<div class="card"><div class="card-body p-2"><p class="card-text small mb-1">Image Preview:</p><img src="" class="img-fluid rounded" style="max-height: 200px;"></div></div>';
        imageUrlInput.parentNode.appendChild(previewContainer);
        
        imageUrlInput.addEventListener('input', function() {
            const imgUrl = this.value.trim();
            const img = previewContainer.querySelector('img');
            
            if (imgUrl && (imgUrl.startsWith('http://') || imgUrl.startsWith('https://'))) {
                img.src = imgUrl;
                previewContainer.classList.remove('d-none');
                
                // Handle image load errors
                img.onerror = function() {
                    previewContainer.classList.add('d-none');
                };
            } else {
                previewContainer.classList.add('d-none');
            }
        });
        
        // Trigger preview for existing URLs (when editing)
        if (imageUrlInput.value) {
            imageUrlInput.dispatchEvent(new Event('input'));
        }
    </script>
</body>
</html>