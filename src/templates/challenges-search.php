<?php
// Get the challenges
$category = isset($_GET["category"]) ? $_GET["category"] : null;
$challenges = $challenges ?? []; // Use the challenges passed from the controller
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="Ava Lipshultz & Megan Lewis">
  <meta name="description" content="Art challenges to inspire creativity">
  <title>Art Challenges Search</title>
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
    <div class="row mb-4">
      <div class="col">
        <h1 class="display-5 fw-bold mb-4">Art Challenges</h1>
        <p class="lead">
          Explore structured challenges to boost your creativity and artistic
          skills.
        </p>
      </div>
    </div>

       <!-- Challenge Type Filter -->
<form id="filterForm" method="GET" action="index.php">
  <input type="hidden" name="command" value="challenge_search">
  
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
          <h5 class="mb-3 fw-bold">Type</h5>
          <div class="container text-center">
            <div class="row">
              <div class="col">
                <input
                  type="checkbox"
                  class="btn-check filter-type"
                  id="btn-check-material"
                  value="material"
                  name="category[]"
                  <?php echo (is_array($category) && in_array('material', $category)) || $category === 'material' ? 'checked' : ''; ?>
                >
                <label
                  class="btn btn-outline-secondary"
                  for="btn-check-material"
                >Material</label>
              </div>
              <div class="col">
                <input
                  type="checkbox"
                  class="btn-check filter-type"
                  id="btn-check-process"
                  value="process"
                  name="category[]"
                  <?php echo (is_array($category) && in_array('process', $category)) || $category === 'process' ? 'checked' : ''; ?>
                >
                <label
                  class="btn btn-outline-secondary"
                  for="btn-check-process"
                >Process</label>
              </div>
              <div class="col">
                <input
                  type="checkbox"
                  class="btn-check filter-type"
                  id="btn-check-concept"
                  value="concept"
                  name="category[]"
                  <?php echo (is_array($category) && in_array('concept', $category)) || $category === 'concept' ? 'checked' : ''; ?>
                >
                <label
                  class="btn btn-outline-secondary"
                  for="btn-check-concept"
                >Concept</label>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Duration filters -->
        <div class="d-flex gap-2 mt-3 mt-md-0">
            <div class="dropdown">
              <button
                class="btn btn-outline-secondary dropdown-toggle"
                type="button"
                id="filterDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="bi bi-funnel me-1"></i> Filter
              </button>
              <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li><h6 class="dropdown-header">Duration</h6></li>
                <li>
                  <div class="dropdown-item">
                    <div class="form-check">
                      <input
                        class="form-check-input filter-duration"
                        type="checkbox"
                        value="quick"
                        id="durationQuick"
                        checked
                      >
                      <label class="form-check-label" for="durationQuick"
                        >Quick (&lt; 15 min)</label
                      >
                    </div>
                  </div>
                </li>
                <li>
                  <div class="dropdown-item">
                    <div class="form-check">
                      <input
                        class="form-check-input filter-duration"
                        type="checkbox"
                        value="medium"
                        id="durationMedium"
                        checked
                      >
                      <label class="form-check-label" for="durationMedium"
                        >Medium (15-30 min)</label
                      >
                    </div>
                  </div>
                </li>
                <li>
                  <div class="dropdown-item">
                    <div class="form-check">
                      <input
                        class="form-check-input filter-duration"
                        type="checkbox"
                        value="long"
                        id="durationLong"
                        checked
                      >
                      <label class="form-check-label" for="durationLong"
                        >Long (&gt; 30 min)</label
                      >
                    </div>
                  </div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <div class="dropdown-item">
                    <button class="btn btn-sm btn-primary w-100" id="applyFilters">
                      Apply Filters
                    </button>
                  </div>
                </li>
              </ul>
            </div>

            <div class="dropdown">
              <button
                class="btn btn-outline-secondary dropdown-toggle"
                type="button"
                id="sortDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                <i class="bi bi-sort-down me-1"></i> Sort
              </button>
              <ul
                class="dropdown-menu dropdown-menu-end"
                aria-labelledby="sortDropdown"
              >
                <li>
                  <a class="dropdown-item active" href="#">Most Popular</a>
                </li>
                <li><a class="dropdown-item" href="#">Newest</a></li>
                <li><a class="dropdown-item" href="#">Oldest</a></li>
              </ul>
            </div>
          </div>
      </div>
    </div>
  </div>
</form>
    <!-- Challenge Count -->
    <div class="row mb-4">
      <div class="col-12">
        <p class="text-muted">Showing <strong><?php echo count($challenges); ?></strong> challenges</p>
      </div>
    </div>

    <!-- Challenges Grid -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
      <?php if (empty($challenges)): ?>
        <div class="col-12">
          <div class="alert alert-info">
            No challenges found. Try different filter options or <a href="#suggestChallengeModal" data-bs-toggle="modal">suggest a new challenge</a>.
          </div>
        </div>
      <?php else: ?>
        <?php foreach ($challenges as $challenge): ?>
          <div class="col">
            <div class="card h-100 shadow-sm challenge-card">
              <div class="card-body">
                <div class="d-flex gap-2 mb-3">
                  <?php 
                    // Split the type string if it contains multiple types
                    $types = explode(',', $challenge['type']);
                    foreach ($types as $type): 
                  ?>
                    <span class="badge bg-dark text-light"><?php echo ucfirst($type); ?></span>
                  <?php endforeach; ?>
                </div>
                <h5 class="card-title"><?php echo htmlspecialchars($challenge['title']); ?></h5>
                <p class="card-text">
                  <?php echo htmlspecialchars($challenge['description']); ?>
                </p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                  <a href="index.php?command=challenge_details&id=<?php echo $challenge['challenge_id']; ?>" class="btn btn-sm btn-primary">Start Challenge</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- Suggest Challenge Section -->
    <div class="row mb-4">
      <div class="col-12">
        <div class="card bg-light border-0 p-4">
          <div class="card-body text-center">
            <h3 class="mb-3">Have an idea for a challenge?</h3>
            <p class="mb-4">
              Share your creative challenge ideas with the community and help
              others grow!
            </p>
            <button
              class="btn btn-primary"
              data-bs-toggle="modal"
              data-bs-target="#suggestChallengeModal"
            >
              Suggest a Challenge
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Suggest Challenge Modal -->
  <div
    class="modal fade"
    id="suggestChallengeModal"
    tabindex="-1"
    aria-hidden="true"
    >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <header>
        <div class="modal-header">
          <h5 class="modal-title">Add a Challenge</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
      </header>
      <div class="modal-body">
        <form id="suggestChallengeForm" method="POST" action="index.php?command=suggest_challenge">
          <?php if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]): ?>
            <div class="alert alert-warning">
              You need to <a href="index.php?command=login">log in</a> to suggest a challenge.
            </div>
          <?php endif; ?>
          
          <div class="mb-3">
            <label for="challengeTitle" class="form-label">Challenge Title</label>
            <input
              type="text"
              class="form-control"
              id="challengeTitle"
              name="challengeTitle"
              placeholder="Give your challenge a catchy title"
              required
            >
          </div>
          <div class="mb-3">
            <label for="challengeDescription" class="form-label">Challenge Description</label>
            <textarea
              class="form-control"
              id="challengeDescription"
              name="challengeDescription"
              rows="3"
              placeholder="Describe your challenge in detail..."
              required
            ></textarea>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Challenge Type</label>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  name="challengeType[]"
                  value="material"
                  id="typeMaterialSuggest"
                >
                <label class="form-check-label" for="typeMaterialSuggest">Material-focused</label>
              </div>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  name="challengeType[]"
                  value="process"
                  id="typeProcessSuggest"
                >
                <label class="form-check-label" for="typeProcessSuggest">Process-focused</label>
              </div>
              <div class="form-check">
                <input
                  class="form-check-input"
                  type="checkbox"
                  name="challengeType[]"
                  value="concept"
                  id="typeThemeSuggest"
                >
                <label class="form-check-label" for="typeThemeSuggest">Concept-focused</label>
              </div>
            </div>
            <div class="col-md-6">
              <label for="challengeDuration" class="form-label mt-3">Duration</label>
              <select class="form-select" id="challengeDuration" name="challengeDuration">
                <option value="quick">Quick (&lt; 15 min)</option>
                <option value="medium" selected>Medium (15-30 min)</option>
                <option value="long">Long (&gt; 30 min)</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label for="challengeMaterials" class="form-label">Required Materials</label>
            <input
              type="text"
              class="form-control"
              id="challengeMaterials"
              name="challengeMaterials"
              placeholder="What materials will be needed?"
            >
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button
          type="button"
          class="btn btn-secondary"
          data-bs-dismiss="modal"
        >
          Cancel
        </button>
        <button type="button" class="btn btn-primary" id="submitChallengeBtn"
          <?php echo (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) ? 'disabled' : ''; ?>
        >
          Submit Challenge
        </button>
      </div>
    </div>
  </div>
</div>

<footer class="container pt-3 mt-4 text-body-secondary border-top">
  <p>© 2025. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form when a filter is changed
    document.querySelectorAll('.filter-type').forEach(filter => {
      filter.addEventListener('change', function() {
        document.getElementById('filterForm').submit();
      });
    });
    
    // Auto-submit form when duration filters are changed too
    document.querySelectorAll('.filter-duration').forEach(filter => {
      filter.addEventListener('change', function() {
        // Get all selected durations
        const selectedDurations = [];
        document.querySelectorAll('.filter-duration:checked').forEach(f => {
          selectedDurations.push(f.value);
        });
        
        // Create hidden input for duration
        let durationInput = document.querySelector('input[name="duration"]');
        if (!durationInput) {
          durationInput = document.createElement('input');
          durationInput.type = 'hidden';
          durationInput.name = 'duration';
          document.getElementById('filterForm').appendChild(durationInput);
        }
        
        // Set value and submit
        durationInput.value = selectedDurations.join(',');
        document.getElementById('filterForm').submit();
      });
    });
    
    // Submit challenge button
    const submitBtn = document.getElementById('submitChallengeBtn');
    if (submitBtn) {
      submitBtn.addEventListener('click', function() {
        document.getElementById('suggestChallengeForm').submit();
      });
    }
  });
</script>
</body>
</html>