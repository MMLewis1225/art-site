<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Ava Lipshultz & Megan Lewis">
  <meta name="description" content="Sign in to the website">
  <title>Log In</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    crossorigin="anonymous"
  >
  <link rel="stylesheet" href="styles/main.css">
</head>

<body>
  <header>
    <?php include("nav.php"); ?>
  </header>
  
  <div class="container">
    <div class="card mt-5 col-6 offset-md-3 col-md-6 col-sm-9 offset-sm-2">
      <div class="card-body p-5 m">
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
        
        <form class="form-signin" method="POST" action="index.php?command=login_handler">
          <h1 class="h3 mb-3 fw-normal">Please log in</h1>
          
          <div class="mb-3">
            <label for="inputEmail" class="form-label">Email address</label>
            <input
              type="email"
              id="inputEmail"
              name="email"
              class="form-control"
              placeholder="Email address"
              required
              autofocus
            >
          </div>
          
          <div class="mb-3">
            <label for="inputPassword" class="form-label">Password</label>
            <input
              type="password"
              id="inputPassword"
              name="password"
              class="form-control"
              placeholder="Password"
              required
            >
          </div>
          
          <button class="w-100 btn btn-lg btn-primary" type="submit">
            Log in
          </button>
          
          <p class="mt-3 text-center">
            Don't have an account? <a href="index.php?command=signup">Sign up</a>
          </p>
        </form>
      </div>
    </div>

    <footer class="container pt-3 mt-4 text-body-secondary border-top">
      <p>© 2025. All rights reserved.</p>
    </footer>
  </div>
  
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"
  ></script>
</body>
</html>