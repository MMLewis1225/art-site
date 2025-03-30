<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Ava Lipshultz & Megan Lewis">
  <meta name="description" content="Explore art challenges">
  <title>Art Challenges</title>
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
    <section class="py-5 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="display-4 fw-bold mb-3">Art Challenges</h1>
          <p class="lead text-body-secondary">
            Explore structured challenges to boost your creativity and
            artistic skills.
          </p>
          <a href="index.php?command=challenge_search" class="btn btn-primary px-4 py-2 challenge">View All Challenges</a>
        </div>
      </div>
    </section>
    
    <main class="container py-4">
      <!-- Challenge Categories -->
      <div class="row mb-4">
        <div class="col-12">
          <h2 class="fw-bold mb-4">Challenge Categories</h2>
          <p class="mb-4">
            Our challenges are organized into three main categories, each
            focusing on a different aspect of the artistic process.
          </p>
        </div>
      </div>

      <!-- Material Based -->
      <div class="row mb-5">
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm custom-card">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="display-5 text-primary me-3">
                  <i class="bi bi-tools"></i>
                </div>
                <h3 class="card-title mb-0">Material Based</h3>
              </div>
              <h5 class="mb-3 card-subheading">What is used</h5>
              <p class="card-text">
                Challenges that focus on specific materials or media.
              </p>
              <div class="mt-4">
                <a href="index.php?command=challenge_search&category=material" class="btn btn-outline-primary">View Material Challenges</a>
             </div>       
            </div>
          </div>
        </div>

        <!-- Process Based -->
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm custom-card">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="display-5 text-primary me-3">
                  <i class="bi bi-gear"></i>
                </div>
                <h3 class="card-title mb-0">Process Based</h3>
              </div>
              <h5 class="mb-3 card-subheading">How it's made</h5>
              <p class="card-text">
                Challenges that focus on technique, method, or approach.
              </p>
              <div class="mt-4">
                    <a href="index.php?command=challenge_search&category=process" class="btn btn-outline-primary">View Process Challenges</a>
                </div>
            </div>
          </div>
        </div>

        <!-- Concept Based -->
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm custom-card">
            <div class="card-body">
              <div class="d-flex align-items-center mb-3">
                <div class="display-5 text-primary me-3">
                  <i class="bi bi-lightbulb"></i>
                </div>
                <h3 class="card-title mb-0">Concept Based</h3>
              </div>
              <h5 class="mb-3 card-subheading">Why it's made</h5>
              <p class="card-text">
                Challenges that focus on ideas, themes, or meanings.
              </p>

<div class="mt-4">
  <a href="index.php?command=challenge_search&category=concept" class="btn btn-outline-primary">View Concept Challenges</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Getting Started Guide -->
      <div class="row mb-5">
        <div class="col-12">
          <h3 class="fw-bold mb-4">Getting Started with Challenges</h3>
          <div class="row g-4">
            <div class="col-md-4">
              <div class="p-3 border rounded bg-light text-center h-100">
                <div class="display-5 text-primary mb-3">
                  <i class="bi bi-1-circle"></i>
                </div>
                <h5>Choose a Category</h5>
                <p>
                  Select a challenge type that interests you or matches the
                  materials you have available. Beginners often start with
                  Material challenges.
                </p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="p-3 border rounded bg-light text-center h-100">
                <div class="display-5 text-primary mb-3">
                  <i class="bi bi-2-circle"></i>
                </div>
                <h5>Set a Timeframe</h5>
                <p>
                  Decide how much time you'll dedicate to the challenge. Some
                  challenges are quick exercises, while others may span
                  several days.
                </p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="p-3 border rounded bg-light text-center h-100">
                <div class="display-5 text-primary mb-3">
                  <i class="bi bi-3-circle"></i>
                </div>
                <h5>Document Your Process</h5>
                <p>
                  Track your progress by keeping notes on your experience,
                  challenges, and insights. This will help you reflect on your
                  artistic growth.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <footer class="container pt-3 mt-4 text-body-secondary border-top">
    <p>© 2025. All rights reserved.</p>
  </footer>
  
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"
  ></script>
</body>
</html>