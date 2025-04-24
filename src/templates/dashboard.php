<?php
// Check if user is logged in
if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
    // Redirect to login page
    header("Location: index.php?command=login");
    exit();
}

// Get user data
$userId = $_SESSION["user_id"];
$username = $_SESSION["username"];

// Get saved prompts
$savedPrompts = $this->db->query(
    "SELECT * FROM art_thing_saved_prompts WHERE user_id = $1 ORDER BY created_at DESC",
    $userId
);
// Get challenge history
$challengeHistory = $this->db->query(
    "SELECT c.title, c.description, uc.completed_at 
     FROM art_thing_user_challenges uc 
     JOIN art_thing_challenges c ON uc.challenge_id = c.challenge_id 
     WHERE uc.user_id = $1 
     ORDER BY uc.completed_at DESC",
    $userId
);

//later-- get user art journals 

$completedChallenges = $challengeHistory ? count($challengeHistory) : 0;
$totalSavedPrompts = $savedPrompts ? count($savedPrompts) : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="styles/main.css">
</head>
<body>
  <header>
    <?php include("nav.php"); ?>
  </header>

  <div class="container py-4">
    <!-- Profile Header -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-md-2 text-center mb-3 mb-md-0">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px">
                  <span style="font-size: 2rem"><?php echo strtoupper(substr($username, 0, 2)); ?></span>
                </div>
              </div>
              <div class="col-md-7 mb-3 mb-md-0">
                <h2 class="mb-1"><?php echo htmlspecialchars($username); ?></h2>
                <p class="text-muted mb-2"><?php echo htmlspecialchars($_SESSION["email"]); ?></p>
                <p>Welcome to your ArtThing dashboard! Track your challenges and saved prompts here.</p>
              </div>
              <div class="col-md-3 text-md-end">
                <a href="index.php?command=logout" class="btn btn-outline-secondary mb-2 mb-md-0">
                  <i class="bi bi-box-arrow-right"></i> Sign Out
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
      <div class="col">
        <div class="card h-100 shadow-sm text-center">
          <div class="card-body">
            <h6 class="card-title text-muted">Challenges Completed</h6>
            <h2 class="card-text"><?php echo $completedChallenges; ?></h2>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 shadow-sm text-center">
          <div class="card-body">
            <h6 class="card-title text-muted">Saved Prompts</h6>
            <h2 class="card-text"><?php echo $totalSavedPrompts; ?></h2>
          </div>
        </div>
      </div>

      
      <div class="col">
        <div class="card h-100 shadow-sm text-center">
          <div class="card-body">
            <h6 class="card-title text-muted">Member Since</h6>
            <h2 class="card-text">
              <?php 
                //  Get current date for now, can change to store user registration date later
                echo date("M Y"); 
              ?>
            </h2>
          </div>
        </div>
      </div>
    </div>
   <!-- Reset Open things -->
    <div class="mb-3 text-end">
      <button id="clearViewBtn" class="btn btn-sm btn-outline-warning">
        Clear View
      </button>
    </div>
    <!-- Tabs for different sections -->
    <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="prompts-tab" data-bs-toggle="tab" data-bs-target="#prompts-tab-pane" type="button" role="tab" aria-controls="prompts-tab-pane" aria-selected="true">
          Saved Prompts
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="challenges-tab" data-bs-toggle="tab" data-bs-target="#challenges-tab-pane" type="button" role="tab" aria-controls="challenges-tab-pane" aria-selected="false">
          Challenge History
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="projects-tab" data-bs-toggle="tab" data-bs-target="#projects-tab-pane" type="button" role="tab" aria-controls="projects-tab-pane" aria-selected="false">
        Art Projects
        </button>
      </li>
    </ul>

    <div class="tab-content" id="profileTabsContent">
      <!-- Saved Prompts Tab -->
      <div class="tab-pane fade show active" id="prompts-tab-pane" role="tabpanel" aria-labelledby="prompts-tab" tabindex="0">
        <h3 class="mb-4">Your Saved Prompts</h3>

        <?php if (empty($savedPrompts)): ?>
          <div class="alert alert-info">
            <p>You haven't saved any prompts yet. Go to the <a href="index.php?command=generator">generator</a> to create and save some prompts!</p>
          </div>
        <?php else: ?>
          <div class="row row-cols-1 row-cols-md-2 g-4">
            <?php foreach ($savedPrompts as $prompt): ?>
              <div class="col">
                <div class="card h-100 shadow-sm">
                  <div class="card-body">
                    <h5 class="card-title">Art Prompt</h5>
                    <p class="card-text">
                      <?php echo htmlspecialchars($prompt["prompt_text"]); ?>
                    </p>
                    <div class="mt-3 d-flex justify-content-between">
                      <a href="index.php?command=generator" class="btn btn-sm btn-outline-primary">
                        Create Art
                      </a>
                      <form method="POST" action="index.php?command=delete_prompt" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this prompt?');">
                          <input type="hidden" name="prompt_id" value="<?php echo $prompt['prompt_id']; ?>">
                          <button type="submit" class="btn btn-sm btn-outline-danger">
                              Remove
                          </button>
                      </form>
                    </div>
                  </div>
                  <div class="card-footer text-muted">
                    Saved on <?php echo date("F j, Y", strtotime($prompt["created_at"])); ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Challenge History Tab -->
      <div class="tab-pane fade" id="challenges-tab-pane" role="tabpanel" aria-labelledby="challenges-tab" tabindex="0">
        <h3 class="mb-4">Challenge History</h3>

        <?php if (empty($challengeHistory)): ?>
          <div class="alert alert-info">
            <p>You haven't completed any challenges yet. Visit the <a href="index.php?command=challenges">challenges page</a> to find challenges!</p>
          </div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">Challenge</th>
                  <th scope="col">Completed Date</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($challengeHistory as $challenge): ?>
                  <tr>
                    <td><?php echo htmlspecialchars($challenge["title"]); ?></td>
                    <td><?php echo date("M j, Y", strtotime($challenge["completed_at"])); ?></td>
                    <td>
                      <button class="btn btn-sm btn-outline-primary">
                        View Details
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>


      <!-- Art Projects Tab -->
<div class="tab-pane fade" id="projects-tab-pane" role="tabpanel" aria-labelledby="projects-tab" tabindex="0">
  <h3 class="mb-4">Your Art Projects</h3>
  
  <div class="text-end mb-4">
    <a href="index.php?command=create_art" class="btn btn-primary">
      <i class="bi bi-plus-circle me-1"></i> Create New Project
    </a>
  </div>
  
  <?php
  // Get a few recent projects
  $recentProjects = $this->db->query(
    "SELECT p.project_id, p.title, p.image_url, p.created_at 
     FROM art_thing_user_projects p
     WHERE p.user_id = $1
     ORDER BY p.created_at DESC
     LIMIT 3",
    $userId
  );
  ?>
  
  <?php if (empty($recentProjects)): ?>
    <div class="alert alert-info">
      <p>You haven't created any art projects yet. <a href="index.php?command=create_art">Create your first project</a> to document your art journey!</p>
    </div>
  <?php else: ?>
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
      <?php foreach ($recentProjects as $project): ?>
        <div class="col">
          <div class="card h-100 shadow-sm">
            <?php if (!empty($project['image_url'])): ?>
              <img 
                src="<?php echo htmlspecialchars($project['image_url']); ?>" 
                class="card-img-top" 
                alt="<?php echo htmlspecialchars($project['title']); ?>"
                style="height: 150px; object-fit: cover;"
                onerror="this.onerror=null; this.src='data:image/svg+xml;charset=UTF-8,%3Csvg width=\'100%\' height=\'150\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'100%\' height=\'100%\' fill=\'%23f8f9fa\'/%3E%3Ctext x=\'50%\' y=\'50%\' font-size=\'14\' text-anchor=\'middle\' alignment-baseline=\'middle\' fill=\'%23adb5bd\'%3EImage unavailable%3C/text%3E%3C/svg%3E';"
              >
            <?php else: ?>
              <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                <div class="text-center text-muted">
                  <i class="bi bi-image" style="font-size: 2rem;"></i>
                  <p class="mt-2 small">No image</p>
                </div>
              </div>
            <?php endif; ?>
            
            <div class="card-body">
              <h5 class="card-title"><?php echo htmlspecialchars($project['title']); ?></h5>
              <p class="card-text small text-muted">
                Created <?php echo date("M j, Y", strtotime($project['created_at'])); ?>
              </p>
              <a href="index.php?command=view_project&project_id=<?php echo $project['project_id']; ?>" class="btn btn-sm btn-outline-primary">View Project</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    
    <div class="text-center">
      <a href="index.php?command=my_projects" class="btn btn-outline-secondary">View All Projects</a>
    </div>
  <?php endif; ?>
</div>



    </div>
  </div>

  <footer class="container pt-3 mt-4 text-body-secondary border-top">
    <p>© 2025. All rights reserved.</p>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
  // self‑invoking anonymous function
  (() => {
    const btn = document.getElementById('clearViewBtn');
    btn.addEventListener('click', () => {
      document.querySelectorAll('.tab-pane').forEach(pane =>
        pane.classList.remove('show', 'active')
      );
      document.querySelectorAll('.nav-link').forEach(link =>
        link.classList.remove('active')
      );

      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  })();
</script>

</body>
</html>