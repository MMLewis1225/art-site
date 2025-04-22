<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Ava Lipshultz & Megan Lewis">
  <meta name="description" content="Make art happen">
  <title>Art Thing - Inspire Your Creativity</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/main.css">
</head>

<body class="homepage">
  <header>
    <?php include("nav.php"); ?>
  </header>
  
  <div class="container">
    <div class="container py-5">
      <div class="container p-5 pb-md-4 mx-auto text-center">
        <h1 class="display-5 fw-normal text-body-emphasis">
          Need an art idea?
        </h1>
        <p class="fs-5 text-body-secondary">
          Boost your creativity with personalized art prompts and structured challenges. 
          Perfect for breaking through artist's block and developing your skills.
        </p>
      </div>

      <!--cards -->
      <div class="row align-items-md-stretch">
        <div class="col-md-6 mb-3">
          <div class="h-100 p-5 text-bg-dark rounded-3">
            <h2>Generate a Prompt</h2>
            <p>
              Choose your medium and preferences to get a random art prompt.
              Simple as that.
            </p>
            <a href="index.php?command=generator" class="btn btn-outline-light">
                Try Generator
            </a>
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <div class="h-100 p-5 bg-body-tertiary border rounded-3">
            <h2>Try a Challenge</h2>
            <p>
              Pick from different types of art challenges. Materials,
              techniques, or themes
            </p>
            <a href="index.php?command=challenges" class="btn btn-outline-secondary">
                View Challenges
            </a>
          </div>
        </div>
      </div>
      <div class="text-center my-4">
        <button id="confettiBtn" class="btn btn-lg ">
          🎉 Celebrate Creativity!
        </button>
      </div>

      <footer class="container pt-3 mt-4 text-body-secondary border-top">
        <p>© 2025. All rights reserved.</p>
      </footer>
    </div>

    <!-- Canvas-Confetti from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script>
      document
        .getElementById('confettiBtn')
        .addEventListener('click', () => {
          confetti({
            particleCount: 150,
            spread: 60,
            origin: { x: 0.5, y: 0 },
          });
        });
    </script>

  </div>
</body>
</html>