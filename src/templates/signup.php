<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Ava Lipshultz & Megan Lewis">
  <meta name="description" content="Create an account">
  <title>Signup</title>
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
    <div class="card mt-5 offset-md-3 col-md-6 col-sm-9 offset-sm-2">
      <div class="card-body p-5 m">
        <?php if (isset($_SESSION["error"])): ?>
          <div class="alert alert-danger">
            <?php echo $_SESSION["error"]; ?>
            <?php unset($_SESSION["error"]); ?>
          </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION["errors"]) && !empty($_SESSION["errors"])): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach ($_SESSION["errors"] as $error): ?>
                <li><?php echo $error; ?></li>
              <?php endforeach; ?>
            </ul>
            <?php unset($_SESSION["errors"]); ?>
          </div>
        <?php endif; ?>
        
        <form class="form-signin" method="POST" action="index.php?command=signup_handler">
          <h1 class="h3 mb-3 fw-normal">Create an Account</h1>          
          <div class="mb-3">
            <div class="alert alert-danger" id="usernameError"></div>
            <label for="inputUsername" class="form-label">Username</label>
            <input
              type="text"
              id="inputUsername"
              name="username"
              class="form-control"
              placeholder="Username"
              required
              autofocus
            >
            <div class="form-text">Username must be 3-20 characters, letters and numbers only.</div>
          </div>
          
          <div class="mb-3">
            <label for="inputEmail" class="form-label">Email address</label>
            <input
              type="email"
              id="inputEmail"
              name="email"
              class="form-control"
              placeholder="Email address"
              required
            >
          </div>
          
          <div class="mb-3">
            <div class="alert alert-danger" id="passwordError"></div>
            <label for="inputPassword" class="form-label">Password</label>
            <input
              type="password"
              id="inputPassword"
              name="password"
              class="form-control"
              placeholder="Password"
              required
            >
            <div class="form-text">Password must be at least 8 characters with at least one uppercase letter, one lowercase letter, and one number.</div>
          </div>
          
          <div class="mb-3">
            <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
            <input
              type="password"
              id="inputConfirmPassword"
              name="confirm_password"
              class="form-control"
              placeholder="Confirm Password"
              required
            >
          </div>
          
          <button class="w-100 btn btn-lg btn-primary" type="submit">
            Sign Up
          </button>
          
          <p class="mt-3 text-center">
            Already have an account? <a href="index.php?command=login">Log in</a>
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
  <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

    <script>
      //ref: https://stackoverflow.com/questions/9862761/how-to-check-if-character-is-a-letter-in-javascript
      function isLetter(char) {
        return char.toLowerCase() != char.toUpperCase();
      }

      function isUpperCase(char){
        return char === char.toUpperCase();
      }

      function isNumeric(char) {
        return char.match(/[0-9]/);
      }

      $(document).ready(function(){
        $("#usernameError").hide();
        $("#passwordError").hide();

        $(".form-signin").on("submit", function(event){
          const username = $("#inputUsername").val()

          if (username.length < 3){
            event.preventDefault(); //don't submit
            $("#usernameError").text("Username too short. Must be at least 3 characters").show();
            return;
          }

          if (username.length > 20){
            event.preventDefault();
            $("#usernameError").text("Username too long. Must be under 20 characters").show();
            return;
          }

          for (const char of username){
            if (!isLetter(char) && !isNumeric(char)){
              event.preventDefault();
              $("#usernameError").text("Username may only contain letters and numbers").show();
              return;
            }
          }

          //if no error in the username, hide any previous error
          $("#usernameError").hide();

          const inputPassword = $("#inputPassword").val();
          const confirmPassword = $("#inputConfirmPassword").val();

          console.log(inputPassword);
          console.log(confirmPassword);


          if (inputPassword !== confirmPassword){
            event.preventDefault();
            $("#passwordError").text("Passwords do not match").show();
            return;
          }

          if (inputPassword.length < 8){
            event.preventDefault();
            $("#passwordError").text("Passwords too short. Must be at least 8 characters").show();
            return;
          }

          let containsUppercase = false;
          let containsLowercase = false;
          let containsNumber = false;
          for (const char of inputPassword){
            if (isNumeric(char)){
              containsNumber = true;
            } else if (isLetter(char)){
              if (isUpperCase(char)){
                containsUppercase = true;
              } else {
                containsLowercase = true;
              }
            }
          }

          if (!containsNumber){
            event.preventDefault();
            $("#passwordError").text("Passwords must contain a number").show();
            return;
          }

          if (!containsUppercase){
            event.preventDefault();
            $("#passwordError").text("Passwords must contain an uppercase letter").show();
            return;
          }

          if (!containsLowercase){
            event.preventDefault();
            $("#passwordError").text("Passwords must contain a lowercase letter").show();
            return;
          }

          //if no error in the username, hide any previous error
          $("#passwordError").hide();

        }) 
      });
    </script>
</body>
</html>