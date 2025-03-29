<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Ava Lipshultz & Megan Lewis">
  <meta name="description" content="Sign in to the website">
  <title>Sign in</title>
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
    <?php include("templates/nav.php"); ?>
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
        <form class="form-signin" action="index.php?command=login_handler" method="POST">
          <h1 class="h3 mb-3 fw-normal">Please log in</h1>
          <label for="inputEmail" class="visually-hidden">Email address</label>
          <input
            type="email"
            id="inputEmail"
            name="email"
            class="form-control mb-2"
            placeholder="Email address"
            required
            autofocus
          >
          <label for="inputPassword" class="visually-hidden">Password</label>
          <input
            type="password"
            id="inputPassword"
            name="password"
            class="form-control mb-3"
            placeholder="Password"
            required
          >
          <button class="w-100 btn btn-lg btn-primary" type="submit">
            Sign in
          </button>
        </form>
      </div>
    </div>

    <footer class="container pt-3 mt-4 text-body-secondary border-top">
      <p>© 2025. All rights reserved.</p>
    </footer>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
  </div>
</body>
</html>