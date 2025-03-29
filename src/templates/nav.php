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
          <a class="nav-link <?php echo ($_GET['command'] == 'home' || !isset($_GET['command'])) ? 'active' : ''; ?>" href="index.php?command=home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($_GET['command'] == 'generator') ? 'active' : ''; ?>" href="index.php?command=generator">Generate</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($_GET['command'] == 'challenges') ? 'active' : ''; ?>" href="index.php?command=challenges">Challenge</a>
        </li>
      </ul>

      <!-- Login & Signup/Logout Buttons -->
      <div class="d-flex flex-row flex-md-row gap-2">
        <?php if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]): ?>
          <span class="navbar-text me-2">Welcome, <?php echo $_SESSION["username"]; ?></span>
          <a href="index.php?command=logout" class="btn btn-sm btn-outline-primary">Sign out</a>
        <?php else: ?>
          <a href="index.php?command=login" class="btn btn-sm btn-outline-primary">Log in</a>
          <a href="index.php?command=signup" class="btn btn-sm btn-primary">Sign-up</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>