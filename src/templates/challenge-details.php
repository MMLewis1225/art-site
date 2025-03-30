<?php
// Get challenge data
$challengeId = isset($this->input["id"]) ? $this->input["id"] : null;
$challenge = $challenge ?? null;
$isLoggedIn = isset($_SESSION["logged_in"]) && $_SESSION["logged_in"];
$hasCompleted = $hasCompleted ?? false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Ava Lipshultz & Megan Lewis">
  <meta name="description" content="Art challenge details">
  <title><?php echo $challenge ? htmlspecialchars($challenge['title']) : 'Challenge Details'; ?> - Art Thing</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    crossorigin="anonymous"
  >
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
  >
  <link rel="stylesheet" href="styles/main.css">
</head>

<body>
  <header>
    <?php include("nav.php"); ?>
  </header>

  <div class="container py-4">
    <?php if (!$challenge): ?>
      <div class="alert alert-warning">
        Challenge not found. <a href="index.php?command=challenge_search">View all challenges</a>
      </div>
    <?php else: ?>
      <!-- Challenge Header -->
      <div class="row mb-4">
        <div class="col-12">
          <h1 class="display-5 fw-bold mb-3"><?php echo htmlspecialchars($challenge['title']); ?></h1>
          
          <!-- Challenge Types -->
          <div class="d-flex gap-2 mb-3">
            <?php 
              $types = explode(',', $challenge['type']);
              foreach ($types as $type): 
            ?>
              <span class="badge bg-dark text-light"><?php echo ucfirst($type); ?></span>
            <?php endforeach; ?>
            <span class="badge bg-secondary">
              <?php 
                switch($challenge['duration']) {
                  case 'quick': echo 'Quick (< 15 min)'; break;
                  case 'medium': echo 'Medium (15-30 min)'; break;
                  case 'long': echo 'Long (> 30 min)'; break;
                  default: echo ucfirst($challenge['duration']); break;
                }
              ?>
            </span>
          </div>
        </div>
      </div>

      <!-- Challenge Content -->
      <div class="row">
        <div class="col-md-8">
          <div class="card mb-4 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Description</h5>
              <p class="card-text"><?php echo nl2br(htmlspecialchars($challenge['description'])); ?></p>
              
              <?php if (!empty($challenge['materials'])): ?>
              <h5 class="mt-4">Materials Needed</h5>
              <p class="card-text"><?php echo htmlspecialchars($challenge['materials']); ?></p>
              <?php endif; ?>
              
              <!-- Action Buttons -->
              <div class="mt-4">
                <?php if ($isLoggedIn): ?>
                  <?php if ($hasCompleted): ?>
                    <button class="btn btn-success" disabled>
                      <i class="bi bi-check-circle-fill"></i> Challenge Completed
                    </button>
                  <?php else: ?>
                    <form method="POST" action="index.php?command=complete_challenge">
                      <input type="hidden" name="challenge_id" value="<?php echo $challenge['challenge_id']; ?>">
                      <button type="submit" class="btn btn-primary">
                        <i class="bi bi-trophy"></i> Mark as Completed
                      </button>
                    </form>
                  <?php endif; ?>
                <?php else: ?>
                  <div class="alert alert-info">
                    <a href="index.php?command=login">Log in</a> to track your completed challenges.
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Tips for Success</h5>
              <ul class="list-group list-group-flush">
                <li class="list-group-item bg-transparent">Set aside uninterrupted time for this challenge</li>
                <li class="list-group-item bg-transparent">Focus on the process rather than the outcome</li>
                <li class="list-group-item bg-transparent">Consider taking before/after photos of your work</li>
                <li class="list-group-item bg-transparent">Reflect on what you learned after completing it</li>
              </ul>
            </div>
          </div>
          
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Share This Challenge</h5>
              <div class="d-grid gap-2 mt-3">
                <button class="btn btn-outline-primary btn-sm">
                  <i class="bi bi-facebook"></i> Share on Facebook
                </button>
                <button class="btn btn-outline-info btn-sm">
                  <i class="bi bi-twitter"></i> Share on Twitter
                </button>
                <button class="btn btn-outline-secondary btn-sm" id="copyLinkBtn">
                  <i class="bi bi-link-45deg"></i> Copy Link
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Return to Challenges Button -->
      <div class="row mt-4">
        <div class="col-12">
          <a href="index.php?command=challenge_search" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Challenges
          </a>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <footer class="container pt-3 mt-4 text-body-secondary border-top">
    <p>© 2025. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Copy link functionality
    document.addEventListener('DOMContentLoaded', function() {
      const copyLinkBtn = document.getElementById('copyLinkBtn');
      if (copyLinkBtn) {
        copyLinkBtn.addEventListener('click', function() {
          const url = window.location.href;
          navigator.clipboard.writeText(url).then(function() {
            // Change button text temporarily
            const originalText = copyLinkBtn.innerHTML;
            copyLinkBtn.innerHTML = '<i class="bi bi-check-lg"></i> Link Copied!';
            setTimeout(function() {
              copyLinkBtn.innerHTML = originalText;
            }, 2000);
          });
        });
      }
    });
  </script>
</body>
</html>