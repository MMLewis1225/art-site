<nav class="navbar navbar-expand-md bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Art Thing</a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarCollapse"
      aria-controls="navbarCollapse"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="nav-item">
          <a class="nav-link <?php echo (!isset($_GET["command"]) || $_GET["command"] == 'home') ? 'active' : ''; ?>" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET["command"]) && $_GET["command"] == 'generator') ? 'active' : ''; ?>" href="index.php?command=generator">Generate</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET["command"]) && ($_GET["command"] == 'challenges' || $_GET["command"] == 'challenge_search')) ? 'active' : ''; ?>" href="index.php?command=challenges">Challenges</a>
        </li>
        <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]): ?>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET["command"]) && $_GET["command"] == 'dashboard') ? 'active' : ''; ?>" href="index.php?command=dashboard">My Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo (isset($_GET["command"]) && ($_GET["command"] == 'my_projects' || $_GET["command"] == 'create_art' || $_GET["command"] == 'view_project' || $_GET["command"] == 'edit_project')) ? 'active' : ''; ?>" href="index.php?command=my_projects">My Art</a>
        </li>
        <?php endif; ?>
      </ul>

      <div class="d-flex flex-row flex-md-row gap-2">
        <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]): ?>
          <!-- Logged in: show user info and logout -->
          <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px">
                <span><?php echo strtoupper(substr($_SESSION["username"], 0, 2)); ?></span>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end text-small" aria-labelledby="dropdownUser1">
              <li><a class="dropdown-item" href="index.php?command=dashboard">Dashboard</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="index.php?command=logout">Sign out</a></li>
            </ul>
          </div>
        <?php else: ?>
          <!-- Not logged in: show login/signup buttons -->
          <a href="index.php?command=login" class="btn btn-sm btn-outline-primary">Log in</a>
          <a href="index.php?command=signup" class="btn btn-sm btn-primary">Sign up</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>