<?php
// Check if user is logged in
$isLoggedIn = isset($_SESSION["logged_in"]) && $_SESSION["logged_in"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Art Prompt Generator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="styles/main.css">
</head>
<body>
  <header>
    <?php include("nav.php"); ?>
  </header>

  <div class="container py-4">
    <div class="card mb-4">
      <div class="card-body">
        <h2 class="card-title mb-3">🎨 Art Prompt Generator</h2>
        <p class="card-text text-muted mb-4">
          Select your preferences to generate a personalized art prompt.
        </p>

        <!-- Simplified Form -->
        <form id="promptForm">
          <!-- Medium Selection -->
          <div class="mb-4">
            <h4 class="mb-3">Choose Your Medium</h4>
            <div class="row">
              <div class="col-md-4">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="medium[]" value="watercolor" id="mediumWatercolor">
                  <label class="form-check-label" for="mediumWatercolor">Watercolor</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="medium[]" value="acrylic" id="mediumAcrylic">
                  <label class="form-check-label" for="mediumAcrylic">Acrylic</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="medium[]" value="pencil" id="mediumPencil">
                  <label class="form-check-label" for="mediumPencil">Pencil</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="medium[]" value="ink" id="mediumInk">
                  <label class="form-check-label" for="mediumInk">Ink</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="medium[]" value="digital" id="mediumDigital">
                  <label class="form-check-label" for="mediumDigital">Digital</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="medium[]" value="mixed_media" id="mediumMixed">
                  <label class="form-check-label" for="mediumMixed">Mixed Media</label>
                </div>
              </div>
            </div>
          </div>

          <!-- Subject Selection -->
          <div class="mb-4">
            <h4 class="mb-3">Choose a Subject</h4>
            <div class="row">
              <div class="col-md-4">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="subject[]" value="landscape" id="subjectLandscape">
                  <label class="form-check-label" for="subjectLandscape">Landscape</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="subject[]" value="portrait" id="subjectPortrait">
                  <label class="form-check-label" for="subjectPortrait">Portrait</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="subject[]" value="still_life" id="subjectStillLife">
                  <label class="form-check-label" for="subjectStillLife">Still Life</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="subject[]" value="abstract" id="subjectAbstract">
                  <label class="form-check-label" for="subjectAbstract">Abstract</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="subject[]" value="fantasy" id="subjectFantasy">
                  <label class="form-check-label" for="subjectFantasy">Fantasy</label>
                </div>
                <div class="form-check mb-2">
                  <input class="form-check-input" type="checkbox" name="subject[]" value="nature" id="subjectNature">
                  <label class="form-check-label" for="subjectNature">Nature</label>
                </div>
              </div>
            </div>
          </div>

          <!-- Generate Button -->
          <div class="d-grid gap-2 mt-4">
            <button class="btn btn-primary btn-lg" type="button" id="generateButton">
              Generate Art Prompt
            </button>
          </div>
        </form>

        <!-- Prompt Display -->
        <div class="mt-4 d-none" id="promptDisplay">
          <h4 class="mb-3">✨ Your Art Prompt</h4>
          <div class="card bg-light">
            <div class="card-body">
              <p class="prompt-text fs-5" id="promptText"></p>
              
              <!-- Save Button (Only visible to logged-in users) -->
              <?php if ($isLoggedIn): ?>
              <div class="mt-3">
                <button class="btn btn-outline-primary" id="saveButton">
                  ❤️ Save Prompt
                </button>
                <span id="saveConfirmation" class="text-success ms-2 d-none">
                  <i class="bi bi-check-circle"></i> Prompt saved!
                </span>
              </div>
              <?php else: ?>
              <div class="mt-3">
                <p class="text-muted">
                  <i class="bi bi-info-circle"></i> 
                  <a href="index.php?command=login">Log in</a> to save this prompt.
                </p>
              </div>
              <?php endif; ?>
              
              <div class="mt-2">
                <button class="btn btn-outline-secondary" id="regenerateButton">
                  🔄 Regenerate
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="container pt-3 mt-4 text-body-secondary border-top">
    <p>© 2025. All rights reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Client-side JavaScript for the generator
    document.addEventListener('DOMContentLoaded', function() {
      const generateButton = document.getElementById('generateButton');
      const regenerateButton = document.getElementById('regenerateButton');
      const saveButton = document.getElementById('saveButton');
      const promptDisplay = document.getElementById('promptDisplay');
      const promptText = document.getElementById('promptText');
      const saveConfirmation = document.getElementById('saveConfirmation');
      
      // Function to generate a prompt
      function generatePrompt() {
        // Get form data
        const form = document.getElementById('promptForm');
        const formData = new FormData(form);
        
        // Make AJAX request to server
        fetch('index.php?command=generate_prompt', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          // Display the prompt
          promptText.textContent = data.prompt;
          promptDisplay.classList.remove('d-none');
          
          // Hide save confirmation message if it was shown
          if (saveConfirmation) {
            saveConfirmation.classList.add('d-none');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
      }
      
      // Generate prompt when button is clicked
      generateButton.addEventListener('click', generatePrompt);
      
      // Regenerate prompt when button is clicked
      regenerateButton.addEventListener('click', generatePrompt);
      
      // Save prompt if save button exists and is clicked
      if (saveButton) {
        saveButton.addEventListener('click', function() {
          // Make AJAX request to save the prompt
          fetch('index.php?command=save_prompt', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({
              prompt: promptText.textContent
            })
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              // Show confirmation message
              saveConfirmation.classList.remove('d-none');
            }
          })
          .catch(error => {
            console.error('Error:', error);
          });
        });
      }
    });
  </script>
</body>
</html>