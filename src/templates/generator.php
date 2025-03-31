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

        <form id="promptForm">
          <!-- Accordion for form sections -->
          <div class="accordion mb-4" id="promptAccordion">
            
            <!-- Medium Selection (Required) -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingMedium">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMedium" aria-expanded="true" aria-controls="collapseMedium">
                  Medium (Required)
                </button>
              </h2>
              <div id="collapseMedium" class="accordion-collapse collapse show" aria-labelledby="headingMedium" data-bs-parent="#promptAccordion">
                <div class="accordion-body">
                  <!-- Mediums by category -->
                  <?php foreach (ArtData::$mediums as $category => $mediums): ?>
                  <div class="medium-category">
                    <h6 class="mb-2"><?php echo $category; ?></h6>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                      <?php foreach ($mediums as $medium): ?>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="medium[]" value="<?php echo $medium; ?>" id="medium_<?php echo str_replace(' ', '_', $medium); ?>">
                        <label class="form-check-label" for="medium_<?php echo str_replace(' ', '_', $medium); ?>"><?php echo $medium; ?></label>
                      </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                  <?php endforeach; ?>
                  
                  <!-- Mixed Media Option -->
                  <div class="mt-3">
                    <label class="form-label">Allow Mixed Media?</label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="mixedMedia" id="mixedMediaNo" value="No" checked>
                      <label class="form-check-label" for="mixedMediaNo">No</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="mixedMedia" id="mixedMediaYes" value="Yes">
                      <label class="form-check-label" for="mixedMediaYes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="mixedMedia" id="mixedMediaRandom" value="Random">
                      <label class="form-check-label" for="mixedMediaRandom">Random</label>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Technique Section -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTechnique">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTechnique" aria-expanded="false" aria-controls="collapseTechnique">
                  Technique
                </button>
              </h2>
              <div id="collapseTechnique" class="accordion-collapse collapse" aria-labelledby="headingTechnique" data-bs-parent="#promptAccordion">
                <div class="accordion-body">
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="includeTechnique" id="includeTechnique" value="true">
                    <label class="form-check-label" for="includeTechnique">Include technique in prompt</label>
                    <div class="form-text">The generator will suggest techniques compatible with your selected medium.</div>
                  </div>
                  
   
                </div>
              </div>
            </div>
            
            <!-- Style Section -->
             
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingStyle">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStyle" aria-expanded="false" aria-controls="collapseStyle">
                  Style
                </button>
              </h2>
              <div id="collapseStyle" class="accordion-collapse collapse" aria-labelledby="headingStyle" data-bs-parent="#promptAccordion">
                <div class="accordion-body">
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="includeStyle" id="includeStyle" value="true">
                    <label class="form-check-label" for="includeStyle">Include style in prompt</label>
                  </div>
                  

                  
                  <div class="small-text">
                    <h6>Style categories:</h6>
                    <?php foreach (ArtData::$styles as $category => $styles): ?>
                    <div class="mb-3">
                      <div class="card bg-light">
                        <div class="card-header py-2">
                          <h6 class="mb-0"><?php echo $category; ?></h6>
                        </div>
                        <div class="card-body py-2">
                          <ul class="mb-0 ps-3">
                            <?php foreach ($styles as $style): ?>
                            <li>
                              <strong><?php echo $style['name']; ?></strong> - 
                              <em><?php echo $style['description']; ?></em>
                            </li>
                            <?php endforeach; ?>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Subject/Reference Section -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingSubject">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSubject" aria-expanded="false" aria-controls="collapseSubject">
                  Subject/Reference
                </button>
              </h2>
              <div id="collapseSubject" class="accordion-collapse collapse" aria-labelledby="headingSubject" data-bs-parent="#promptAccordion">
                <div class="accordion-body">
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="includeSubject" id="includeSubject" value="true">
                    <label class="form-check-label" for="includeSubject">Include subject or reference in prompt</label>
                  </div>
                  
                  <div class="mt-3">
                    <h6>Select source type:</h6>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="subjectType" id="subjectTypeFocus" value="Subject/Focus" checked 
                             onchange="document.getElementById('subjectFocusOptions').style.display='block'; document.getElementById('referenceSourceOptions').style.display='none';">
                      <label class="form-check-label" for="subjectTypeFocus">Subject/Focus (what to draw)</label>
                    </div>
                    <div class="form-check mb-3">
                      <input class="form-check-input" type="radio" name="subjectType" id="subjectTypeReference" value="Reference Source"
                             onchange="document.getElementById('subjectFocusOptions').style.display='none'; document.getElementById('referenceSourceOptions').style.display='block';">
                      <label class="form-check-label" for="subjectTypeReference">Reference Source (where to get inspiration)</label>
                    </div>
                    
                    <!-- Subject/Focus Categories -->
                    <div id="subjectFocusOptions">
                      <h6>Select subject category:</h6>
                      <?php foreach (array_keys(ArtData::$subjects) as $category): ?>
                      <div class="form-check">
                        <input class="form-check-input subject-category-radio" type="radio" name="subjectCategory" 
                               id="subject_<?php echo str_replace(' ', '_', $category); ?>" 
                               value="<?php echo $category; ?>" <?php echo $category === 'Person' ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="subject_<?php echo str_replace(' ', '_', $category); ?>"><?php echo $category; ?></label>
                      </div>
                      <?php endforeach; ?>
   
                    <!-- Subject Examples for each category -->
                      <?php foreach (ArtData::$subjects as $category => $examples): ?>
                      <div id="subject_examples_<?php echo str_replace(' ', '_', $category); ?>" class="subject-examples mt-3 <?php echo $category !== 'Person' ? 'd-none' : ''; ?>">
                        <div class="card bg-light">
                          <div class="card-header py-2">
                            <h6 class="mb-0"><?php echo $category; ?> examples:</h6>
                          </div>
                          <div class="card-body small-text py-2">
                           <ul class="mb-0 ps-3">
                              <li><?php echo $examples[0]; ?></li>
                            </ul>

                          </div>
                        </div>
                      </div>
                      <?php endforeach; ?>
                     </div>
                    
                    <!-- Reference Source Options -->
                    <div id="referenceSourceOptions" style="display: none;">
                      <h6>Reference source examples:</h6>
                      <div class="card bg-light">
                        <div class="card-body small-text py-2">
                          <ul class="mb-0 ps-3">
                            <li>Something that starts with the letter B</li>
                            <li>An image from <a href="https://unsplash.com/t/nature" target="_blank">https://unsplash.com/t/nature</a></li>
                            <li>The last photo in your camera roll</li>
                          </ul>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            
            <!-- Theme/Concept/Mood Section -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingTheme">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTheme" aria-expanded="false" aria-controls="collapseTheme">
                  Theme/Concept/Mood
                </button>
              </h2>
              <div id="collapseTheme" class="accordion-collapse collapse" aria-labelledby="headingTheme" data-bs-parent="#promptAccordion">
                <div class="accordion-body">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="includeTheme" id="includeTheme" value="true" 
                               onchange="document.getElementById('themeOptions').style.display=this.checked ? 'block' : 'none';">
                        <label class="form-check-label" for="includeTheme">Include theme/concept</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="includeMood" id="includeMood" value="true"
                               onchange="document.getElementById('moodOptions').style.display=this.checked ? 'block' : 'none';">
                        <label class="form-check-label" for="includeMood">Include mood</label>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Theme Categories -->
                  <div id="themeOptions" style="display: none;">
                    <h6>Select theme category:</h6>
                    <?php foreach (array_keys(ArtData::$themes) as $category): ?>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="themeCategory[]" 
                              id="theme_<?php echo str_replace(' ', '_', $category); ?>" 
                              value="<?php echo $category; ?>">
                        <label class="form-check-label" for="theme_<?php echo str_replace(' ', '_', $category); ?>"><?php echo $category; ?></label>
                      </div>
                    <?php endforeach; ?>
                  </div>
                  
                  <!-- Mood Options -->
                <!--    <div id="moodOptions" style="display: none;">
                    <h6>Possible moods:</h6>
                    <div class="card bg-light">
                      <div class="card-body py-2">
                        <div class="d-flex flex-wrap gap-1">
                          <?php foreach (ArtData::$moods as $mood): ?>
                          <span class="badge bg-white border text-dark"><?php echo $mood; ?></span>
                          <?php endforeach; ?>
                        </div>
                      </div>
                    </div>
                  </div> -->
                </div>
              </div>
            </div>
            
            <!-- Surface & Color Section -->
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOther">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOther" aria-expanded="false" aria-controls="collapseOther">
                  Surface & Color
                </button>
              </h2>
              <div id="collapseOther" class="accordion-collapse collapse" aria-labelledby="headingOther" data-bs-parent="#promptAccordion">
                <div class="accordion-body">
                  <div class="row mb-3">
                    <div class="col-md-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="includeSurface" id="includeSurface" value="true"
                               onchange="document.getElementById('surfaceOptions').style.display=this.checked ? 'block' : 'none';">
                        <label class="form-check-label" for="includeSurface">Include surface</label>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="includeColors" id="includeColors" value="true"
                               onchange="document.getElementById('colorOptions').style.display=this.checked ? 'block' : 'none';">
                        <label class="form-check-label" for="includeColors">Include color scheme</label>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Surface Options -->
                  <div id="surfaceOptions" style="display: none;">
                    <h6>Compatible surfaces:</h6>
                    <p class="small-text text-muted mb-2">
                      The generator will only suggest surfaces compatible with your selected medium.
                    </p>
                      <!-- List of surfaces?? at some point? 
                    <div class="card bg-light">
                      <div class="card-body small-text py-2">
                        <ul class="mb-0 ps-3">
                          <?php foreach (ArtData::$surfaces as $surface): ?>
                          <li title="Compatible with: <?php echo implode(', ', $surface['compatibleMediums']); ?>">
                            <?php echo $surface['name']; ?>
                          </li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    </div> -->
                  </div>
                  
                  <!-- Color Options -->
                  <div id="colorOptions" style="display: none;">
                    <h6>Color schemes:</h6>
                    <div class="card bg-light">
                      <div class="card-body small-text py-2">
                        <ul class="mb-0 ps-3">
                          <?php foreach (ArtData::$colors as $color): ?>
                          <li>
                            <strong><?php echo $color['name']; ?></strong>: 
                            <em><?php echo $color['description']; ?></em>
                          </li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Generate Button -->
          <div class="d-grid gap-2 mt-4">
            <button class="btn btn-primary btn-lg" type="button" id="generateButton">
              <i class="bi bi-shuffle me-2"></i> Generate Art Prompt
            </button>
          </div>
        </form>

        <!-- Prompt Display -->
        <div class="mt-4 d-none" id="promptDisplay">
          <h4 class="mb-3">✨ Your Art Prompt</h4>
          <div class="card bg-light">
            <div class="card-body">
              <p class="prompt-text fs-5" id="promptText"></p>
              
              <div class="d-flex flex-wrap gap-2 mt-3">
                <button class="btn btn-outline-secondary" id="regenerateButton">
                  <i class="bi bi-arrow-clockwise me-1"></i> Regenerate
                </button>
                
                <?php if ($isLoggedIn): ?>
                <button class="btn btn-outline-primary" id="saveButton">
                  <i class="bi bi-heart me-1"></i> Save Prompt
                </button>
                <span id="saveConfirmation" class="text-success ms-2 d-none align-self-center">
                  <i class="bi bi-check-circle"></i> Prompt saved!
                </span>
                <?php else: ?>
                <div class="ms-2 align-self-center">
                  <span class="text-muted">
                    <i class="bi bi-info-circle"></i> 
                    <a href="index.php?command=login">Log in</a> to save this prompt.
                  </span>
                </div>
                <?php endif; ?>
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
    // Show examples for selected subject category
    document.querySelectorAll('.subject-category-radio').forEach(radio => {
      radio.addEventListener('change', function() {
        document.querySelectorAll('.subject-examples').forEach(div => {
          div.classList.add('d-none');
        });
        document.getElementById('subject_examples_' + this.value.replace(' ', '_')).classList.remove('d-none');
      });
    });
    
    // Show examples for selected theme category
   /* document.querySelectorAll('.theme-category-radio').forEach(radio => {
      radio.addEventListener('change', function() {
        document.querySelectorAll('.theme-examples').forEach(div => {
          div.classList.add('d-none');
        });
        document.getElementById('theme_examples_' + this.value.replace(' ', '_')).classList.remove('d-none');
      });
    });*/

    // Generate and save prompt functionality
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
      if (regenerateButton) {
        regenerateButton.addEventListener('click', generatePrompt);
      }
      
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