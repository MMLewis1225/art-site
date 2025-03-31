<?php
require_once("src/ArtData.php");

class ArtChallengeController {
    private $db;
    private $input;
    
    //Constructor
    public function __construct($input) {
        $this->db = new Database();
        $this->input = $input;
    }
    
    /**
     * Run the server
     * 
     * Given the input (usually $_GET), then it will determine
     * which command to execute based on the given "command"
     * parameter. Default is the home page.
     */
    public function run() {
        // Get the command
        $command = "home";
        if (isset($this->input["command"]))
            $command = $this->input["command"];
            
        switch($command) {
            case "home":
                $this->showHome();
                break;
            case "login":
                $this->showLogin();
                break;
            case "login_handler":
                $this->handleLogin();
                break;
            case "signup":
                $this->showSignup();
                break;
            case "signup_handler":
                $this->handleSignup();
                break;
            case "logout":
                $this->handleLogout();
                break;
            case "dashboard":
                $this->showDashboard();
                break;
            case "generator":
                $this->showGenerator();
                break;
            case "generate_prompt":
                $this->generatePrompt();
                break;
            case "save_prompt":
                $this->savePrompt();
                break;
            case "delete_prompt":
                $this->deletePrompt();
                break;
            case "challenges":
                $this->showChallenges();
                break;
            case "challenge_search":
                $this->showChallengeSearch();
                break;
            case "challenge_details":
                $this->showChallengeDetail();
                break;
            case "complete_challenge":
                $this->completeChallenge();
                break;
            case "suggest_challenge":
                $this->suggestChallenge();
                break;
            default:
                $this->showHome();
                break;
        }
    }
    // Show the home page
    public function showHome() {
        include("templates/home.php");
    }
    
    //Handle login form submission
    
    public function handleLogin() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"] ?? "";
            $password = $_POST["password"] ?? "";
            
            // Validate input
            if (empty($email) || empty($password)) {
                $_SESSION["error"] = "Email and password are required";
                header("Location: index.php?command=login");
                exit();
            }
            
            // FIXED: Check if user exists and password is correct
            $users = $this->db->query(
                "SELECT * FROM art_thing_users WHERE email = $1", 
                $email
            );
            
            if ($users && !empty($users)) {
                $user = $users[0];
                if (password_verify($password, $user["password_hash"])) {
                    // Store user info in session
                    $_SESSION["user_id"] = $user["user_id"];
                    $_SESSION["username"] = $user["username"];
                    $_SESSION["email"] = $user["email"];
                    $_SESSION["logged_in"] = true;
                    
                    // Redirect to dashboard
                    header("Location: index.php?command=dashboard");
                    exit();
                }
            }
            
            $_SESSION["error"] = "Invalid email or password";
            header("Location: index.php?command=login");
            exit();
        }
    }

/**
 * Show the generator page
 */
public function showGenerator() {
    // Make sure ArtData is included
    require_once "ArtData.php";
    include("templates/generator.php");
}

/**
 * Generate a prompt based on user input
 */
public function generatePrompt() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $medium = isset($_POST["medium"]) ? $_POST["medium"] : [];
        $mixedMedia = $_POST["mixedMedia"] ?? "No";
        
        $includeTechnique = isset($_POST["includeTechnique"]);
        $includeStyle = isset($_POST["includeStyle"]);
        $includeSubject = isset($_POST["includeSubject"]);
        $subjectType = $_POST["subjectType"] ?? "";
        $subjectCategory = $_POST["subjectCategory"] ?? "";
        
        $includeTheme = isset($_POST["includeTheme"]);
        $themeCategory = $_POST["themeCategory"] ?? "";
        $includeMood = isset($_POST["includeMood"]);
        
        $includeSurface = isset($_POST["includeSurface"]);
        $includeColors = isset($_POST["includeColors"]);
        
        // Generate prompt text
        $prompt = $this->createEnhancedPromptText(
            $medium, 
            $mixedMedia, 
            $includeTechnique, 
            $includeStyle, 
            $includeSubject,
            $subjectType,
            $subjectCategory,
            $includeTheme,
            $themeCategory,
            $includeMood,
            $includeSurface,
            $includeColors
        );
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode([
            "success" => true,
            "prompt" => $prompt
        ]);
        exit();
    }
}

/**
 * Create an enhanced prompt text from selected options
 */
private function createEnhancedPromptText(
    $medium, 
    $mixedMedia, 
    $includeTechnique, 
    $includeStyle, 
    $includeSubject,
    $subjectType,
    $subjectCategory,
    $includeTheme,
    $themeCategory,
    $includeMood,
    $includeSurface,
    $includeColors
) {

    // Initialize prompt components
    $mediumText = "any medium of your choice";
    $techniqueText = "";
    $styleText = "";
    $subjectText = "";
    $themeText = "";
    $moodText = "";
    $surfaceText = "";
    $colorText = "";
    
    // Handle medium selection
    if (!empty($medium)) {
        if ($mixedMedia === "Yes" || ($mixedMedia === "Random" && rand(0, 1) === 1)) {
            // Select 2-3 random mediums
            $selectedCount = min(count($medium), rand(2, 3));
            $selectedMediums = array_rand(array_flip($medium), $selectedCount);
            
            if (is_array($selectedMediums)) {
                $mediumText = implode(" and ", $selectedMediums);
            } else {
                $mediumText = $selectedMediums;
            }
            
            $mediumText .= " in a mixed media approach";
        } else {
            // Select a single random medium
            $randomMedium = $medium[array_rand($medium)];
            $mediumText = $randomMedium;
        }
    }
    
    // Handle technique if included
    if ($includeTechnique) {
        // Find compatible techniques for the selected medium(s)
        $compatibleTechniques = [];
        
        foreach (ArtData::$techniques as $category => $techniques) {
            foreach ($techniques as $technique) {
                $compatible = false;
                
                // Check if any selected medium is compatible with this technique
                foreach ($medium as $selectedMedium) {
                    if (in_array($selectedMedium, $technique['compatibleMediums'])) {
                        $compatible = true;
                        break;
                    }
                }
                
                if ($compatible) {
                    $compatibleTechniques[] = $technique['name'];
                }
            }
        }
        
        if (!empty($compatibleTechniques)) {
            $techniqueText = " using the " . $compatibleTechniques[array_rand($compatibleTechniques)] . " technique";
        }
    }
    
    // Handle style if included
    if ($includeStyle) {
        $allStyles = [];
        foreach (ArtData::$styles as $category => $styles) {
            foreach ($styles as $style) {
                $allStyles[] = $style['name'];
            }
        }
        
        if (!empty($allStyles)) {
            $styleText = " in a " . $allStyles[array_rand($allStyles)] . " style";
        }
    }
    
    // Handle subject if included
    if ($includeSubject) {
        if ($subjectType === "Subject/Focus" && !empty($subjectCategory)) {
            if (isset(ArtData::$subjects[$subjectCategory]) && !empty(ArtData::$subjects[$subjectCategory])) {
                $subjects = ArtData::$subjects[$subjectCategory];
                $subjectText = " depicting " . $subjects[array_rand($subjects)];
            }
        } else {
            // Reference source
            $references = ArtData::$references;
            $subjectText = " based on " . $references[array_rand($references)];
        }
    }
    
    // Handle theme if included
    if ($includeTheme && !empty($themeCategory)) {
        if (isset(ArtData::$themes[$themeCategory]) && !empty(ArtData::$themes[$themeCategory])) {
            $themes = ArtData::$themes[$themeCategory];
            $themeText = " exploring the theme of " . $themes[array_rand($themes)];
        }
    }
    
    // Handle mood if included
    if ($includeMood) {
        $moods = ArtData::$moods;
        $moodText = " with a " . $moods[array_rand($moods)] . " mood";
    }
    
    // Handle surface if included
    if ($includeSurface) {
        $compatibleSurfaces = [];
        
        foreach (ArtData::$surfaces as $surface) {
            $compatible = false;
            
            // Check if any selected medium is compatible with this surface
            foreach ($medium as $selectedMedium) {
                if (in_array($selectedMedium, $surface['compatibleMediums'])) {
                    $compatible = true;
                    break;
                }
            }
            
            if ($compatible) {
                $compatibleSurfaces[] = $surface['name'];
            }
        }
        
        if (!empty($compatibleSurfaces)) {
            $surfaceText = " on " . $compatibleSurfaces[array_rand($compatibleSurfaces)];
        }
    }
    
    // Handle color if included
    if ($includeColors) {
        $colors = ArtData::$colors;
        $randomColor = $colors[array_rand($colors)];
        $colorText = " using a " . $randomColor['name'] . " color scheme";
    }
    
    // Construct final prompt
    $prompt = "Create a piece using $mediumText$surfaceText$techniqueText$styleText$subjectText$themeText$moodText$colorText.";
    
    // Add a random additional instruction
  /*  $additionalInstructions = [
        "Focus on creating strong contrast between light and dark.",
        "Pay special attention to composition and negative space.",
        "Try to complete this in under 30 minutes as a warm-up exercise.",
        "Experiment with your mark-making to create interesting textures.",
        "Focus on capturing mood and atmosphere rather than perfecting details."
    ];
    
    $prompt .= " " . $additionalInstructions[array_rand($additionalInstructions)]; */
    
    return $prompt;
}

/**
 * Save a prompt for a logged-in user
 */
public function savePrompt() {
    // Check if user is logged in
    if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        header('Content-Type: application/json');
        echo json_encode([
            "success" => false,
            "message" => "You must be logged in to save prompts"
        ]);
        exit();
    }
    
    // Get JSON data from request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    if (isset($data["prompt"])) {
        $prompt = $data["prompt"];
        $userId = $_SESSION["user_id"];
        $promptData = isset($data["promptData"]) ? json_encode($data["promptData"]) : null;
        
        // Insert into database with correct table name
        $result = $this->db->query(
            "INSERT INTO art_thing_saved_prompts (user_id, prompt_text, prompt_data) VALUES ($1, $2, $3)",
            $userId, $prompt, $promptData
        );
        
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode([
                "success" => true,
                "message" => "Prompt saved successfully"
            ]);
            exit();
        }
    }
    
    // If something went wrong: 
    header('Content-Type: application/json');
    echo json_encode([
        "success" => false,
        "message" => "Error saving prompt"
    ]);
    exit();
}

/**
 * Dashboard
 */

//show dashboard page
public function showDashboard() {
    // Check if user is logged in
    if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        // Redirect to login page
        header("Location: index.php?command=login");
        exit();
    }
    
    // Get user data
    $userId = $_SESSION["user_id"];
    
    // Get saved prompts with the correct table name
    $savedPrompts = $this->db->query(
        "SELECT * FROM art_thing_saved_prompts WHERE user_id = $1 ORDER BY created_at DESC",
        $userId
    );
    
    // Get challenge history with the correct table name
    $challengeHistory = $this->db->query(
        "SELECT c.title, c.description, uc.completed_at 
         FROM art_thing_user_challenges uc 
         JOIN art_thing_challenges c ON uc.challenge_id = c.challenge_id 
         WHERE uc.user_id = $1 
         ORDER BY uc.completed_at DESC",
        $userId
    );
    
    // Handle potentially null/false values
    $completedChallenges = $challengeHistory ? count($challengeHistory) : 0;
    $totalSavedPrompts = $savedPrompts ? count($savedPrompts) : 0;
    
    include("templates/dashboard.php");
}
/**
 * Delete a saved prompt
 */
public function deletePrompt() {
    // Check if user is logged in
    if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        $_SESSION["error"] = "You must be logged in to delete prompts";
        header("Location: index.php?command=login");
        exit();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $promptId = $_POST["prompt_id"] ?? null;
        
        if (!$promptId) {
            $_SESSION["error"] = "Invalid prompt";
            header("Location: index.php?command=dashboard");
            exit();
        }
        
        $userId = $_SESSION["user_id"];
        
        // Make sure the prompt belongs to this user
        $result = $this->db->query(
            "DELETE FROM art_thing_saved_prompts WHERE prompt_id = $1 AND user_id = $2",
            $promptId, $userId
        );
        
        if ($result) {
            $_SESSION["success"] = "Prompt deleted successfully";
        } else {
            $_SESSION["error"] = "Error deleting prompt";
        }
        
        // Redirect back to dashboard
        header("Location: index.php?command=dashboard");
        exit();
    }
}



/**
 * Show the signup page
 */
public function showSignup() {
    include("templates/signup.php");
}

/**
 * Handle signup form submission
 */
public function handleSignup() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"] ?? "";
        $email = $_POST["email"] ?? "";
        $password = $_POST["password"] ?? "";
        $confirm_password = $_POST["confirm_password"] ?? "";
        
        // Validate input with regular expressions
        $errors = [];
        
        // Username validation: alphanumeric, 3-20 chars
        if (!preg_match('/^[a-zA-Z0-9]{3,20}$/', $username)) {
            $errors[] = "Username must be 3-20 characters and contain only letters and numbers";
        }
        
        // Email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Please enter a valid email address";
        }
        
        // Password validation: at least 8 chars, 1 uppercase, 1 lowercase, 1 number
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
            $errors[] = "Password must be at least 8 characters with at least one uppercase letter, one lowercase letter, and one number";
        }
        
        // Password confirmation validation
        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match";
        }
        
        // If there are validation errors
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            header("Location: index.php?command=signup");
            exit();
        }
        
        // Check if user already exists
        $existingUsers = $this->db->query(
            "SELECT COUNT(*) as count FROM art_thing_users WHERE email = $1 OR username = $2",
            $email, $username
        );
        
        if ($existingUsers && isset($existingUsers[0]["count"]) && $existingUsers[0]["count"] > 0) {
            $_SESSION["error"] = "Username or email already in use";
            header("Location: index.php?command=signup");
            exit();
        }
        
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert user into database
        $result = $this->db->query(
            "INSERT INTO art_thing_users (username, email, password_hash) VALUES ($1, $2, $3) RETURNING user_id",
            $username, $email, $password_hash
        );
        
        if ($result && isset($result[0]["user_id"])) {
            $userId = $result[0]["user_id"];
            
            // Auto-login after signup
            $_SESSION["user_id"] = $userId;
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;
            $_SESSION["logged_in"] = true;
            
            // Redirect to dashboard
            header("Location: index.php?command=dashboard");
            exit();
        } else {
            $_SESSION["error"] = "Error creating account";
            header("Location: index.php?command=signup");
            exit();
        }
    }
}

/**
 * Show the login page
 */
public function showLogin() {
    include("templates/login.php");
}
/**
 * Handle user logout
 */
public function handleLogout() {
    // Clear session data
    $_SESSION = array();
    
    // Destroy the session
    session_destroy();
    
    // Redirect to home page
    header("Location: index.php");
    exit();
}

/**
 * Show the challenges main page
 */
public function showChallenges() {
    include("templates/challenges.php");
}

/**
 * Show the challenge search page with filtered challenges
 */
public function showChallengeSearch() {
    // Get filter parameters
    $category = isset($this->input["category"]) ? $this->input["category"] : null;
    $duration = isset($this->input["duration"]) ? $this->input["duration"] : null;
    
    // Build query conditions
    $conditions = [];
    $params = [];
    
    if ($category) {
        // Handle both string and array inputs
        $categories = is_array($category) ? $category : [$category];
        
        $categoryConditions = [];
        foreach ($categories as $cat) {
            $categoryConditions[] = "type LIKE $" . (count($params) + 1);
            $params[] = "%$cat%";
        }
        
        if (!empty($categoryConditions)) {
            // Use AND to require all categories
            $conditions[] = "(" . implode(" AND ", $categoryConditions) . ")";
        }
    }
    
    // Handle duration filter
    if ($duration) {
        $durationArr = explode(',', $duration);
        $durationPlaceholders = [];
        
        foreach ($durationArr as $d) {
            $durationPlaceholders[] = "$" . (count($params) + 1);
            $params[] = $d;
        }
        
        if (!empty($durationPlaceholders)) {
            $conditions[] = "duration IN (" . implode(",", $durationPlaceholders) . ")";
        }
    }
    
      // Build the complete query
      $query = "SELECT * FROM art_thing_challenges";
    
      if (!empty($conditions)) {
          $query .= " WHERE " . implode(" AND ", $conditions);
      }
      
      $query .= " ORDER BY created_at DESC";
      
      // Execute query
      $challenges = $this->db->query($query, ...$params);
      
    // Include template with challenges data
    include("src/templates/challenges-search.php");
}

/**
 * Handle challenge suggestion submission
 */
public function suggestChallenge() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if user is logged in
        if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
            $_SESSION["error"] = "You must be logged in to suggest a challenge";
            header("Location: index.php?command=login");
            exit();
        }
        
        // Get form data
        $title = $_POST["challengeTitle"] ?? "";
        $description = $_POST["challengeDescription"] ?? "";
        $types = $_POST["challengeType"] ?? [];
        $duration = $_POST["challengeDuration"] ?? "";
        $materials = $_POST["challengeMaterials"] ?? "";
        
        // Validate input
        $errors = [];
        
        if (empty($title)) {
            $errors[] = "Challenge title is required";
        }
        
        if (empty($description)) {
            $errors[] = "Challenge description is required";
        }
        
        if (empty($types)) {
            $errors[] = "At least one challenge type must be selected";
        }
        
        if (empty($duration)) {
            $errors[] = "Duration is required";
        }
        
        // If there are validation errors
        if (!empty($errors)) {
            $_SESSION["errors"] = $errors;
            header("Location: index.php?command=challenge_search");
            exit();
        }
        
        // Process challenge types
        $typeString = implode(',', $types);
        
        // Insert challenge into database
        $userId = $_SESSION["user_id"];
        
        $result = $this->db->query(
            "INSERT INTO challenges (title, description, type, duration, materials, created_by) VALUES ($1, $2, $3, $4, $5, $6)",
            $title, $description, $typeString, $duration, $materials, $userId
        );
        
        if ($result) {
            $_SESSION["success"] = "Challenge suggested successfully! Thank you for your contribution.";
        } else {
            $_SESSION["error"] = "Error suggesting challenge. Please try again.";
        }
        
        header("Location: index.php?command=challenge_search");
        exit();
    }
}

/**
 * Show a specific challenge detail
 */
public function showChallengeDetail() {
    $challengeId = isset($this->input["id"]) ? $this->input["id"] : null;
    
    if (!$challengeId) {
        header("Location: index.php?command=challenge_search");
        exit();
    }
    
    // Get challenge details
    $challenges = $this->db->query(
        "SELECT * FROM art_thing_challenges WHERE challenge_id = $1",
        $challengeId
    );
    
    if (empty($challenges)) {
        // Challenge not found
        $challenge = null;
    } else {
        $challenge = $challenges[0];
        
        // Check if user has completed this challenge
        $hasCompleted = false;
        if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]) {
            $userId = $_SESSION["user_id"];
            
            $completions = $this->db->query(
                "SELECT * FROM art_thing_user_challenges WHERE user_id = $1 AND challenge_id = $2",
                $userId, $challengeId
            );
            
            $hasCompleted = !empty($completions);
        }
    }
    
    include("templates/challenge-details.php");
}

/**
 * Mark a challenge as completed
 */
public function completeChallenge() {
    // Check if user is logged in
    if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        $_SESSION["error"] = "You must be logged in to complete challenges";
        header("Location: index.php?command=login");
        exit();
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $challengeId = $_POST["challenge_id"] ?? null;
        
        if (!$challengeId) {
            $_SESSION["error"] = "Invalid challenge";
            header("Location: index.php?command=challenge_search");
            exit();
        }
        
        $userId = $_SESSION["user_id"];
        
        // Check if already completed
        $existing = $this->db->query(
            "SELECT * FROM art_thing_user_challenges WHERE user_id = $1 AND challenge_id = $2",
            $userId, $challengeId
        );
        
        if (empty($existing)) {
            // Insert new completion
            $result = $this->db->query(
                "INSERT INTO art_thing_user_challenges (user_id, challenge_id) VALUES ($1, $2)",
                $userId, $challengeId
            );
            
            if ($result) {
                $_SESSION["success"] = "Challenge marked as completed!";
            } else {
                $_SESSION["error"] = "Error recording challenge completion";
            }
        }
        
        // Redirect back to challenge detail
        header("Location: index.php?command=challenge_details&id=" . $challengeId);
        exit();
    }
}

}
?>