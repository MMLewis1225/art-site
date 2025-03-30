<?php
class ArtChallengeController {
    private $db;
    private $input;
    
    /**
     * Constructor
     */
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
            case "challenge_detail":
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
    /**
     * Show the home page
     */
    public function showHome() {
        include("templates/home.php");
    }
    
    /**
     * Handle login form submission
     */
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
            
            // Check if user exists and password is correct
            $users = $this->db->query(
                "SELECT * FROM users WHERE email = $1", 
                $email
            );
            
            if ($users && count($users) > 0) {
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
    
    // Add other methods for signup, logout, dashboard, etc.
    // ...


    /**
 * Show the generator page
 */
public function showGenerator() {
    include("templates/generator.php");
}

/**
 * Generate a prompt based on user input
 */
public function generatePrompt() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $medium = isset($_POST["medium"]) ? $_POST["medium"] : [];
        $subject = isset($_POST["subject"]) ? $_POST["subject"] : [];
        
        // Generate prompt text
        $prompt = $this->createPromptText($medium, $subject);
        
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
 * Create a prompt text from selected options
 */
private function createPromptText($medium, $subject) {
    // Default prompt components
    $mediumText = "any medium of your choice";
    $subjectText = "a subject that inspires you";
    
    // If mediums were selected
    if (!empty($medium)) {
        // Select a random medium
        $randomMedium = $medium[array_rand($medium)];
        $mediumText = $this->formatMedium($randomMedium);
    }
    
    // If subjects were selected
    if (!empty($subject)) {
        // Select a random subject
        $randomSubject = $subject[array_rand($subject)];
        $subjectText = $this->formatSubject($randomSubject);
    }
    
    // Construct final prompt
    $prompt = "Create a piece using $mediumText that depicts $subjectText.";
    
    // Add a random additional instruction
    $additionalInstructions = [
        "Focus on creating strong contrast between light and dark.",
        "Experiment with unusual color combinations.",
        "Try to complete this in less than 30 minutes.",
        "Use only three colors in your composition.",
        "Focus on capturing mood and atmosphere rather than details."
    ];
    
    $prompt .= " " . $additionalInstructions[array_rand($additionalInstructions)];
    
    return $prompt;
}

/**
 * Format medium name for prompt text
 */
private function formatMedium($medium) {
    switch ($medium) {
        case 'watercolor':
            return 'watercolor paint';
        case 'acrylic':
            return 'acrylic paint';
        case 'pencil':
            return 'pencil';
        case 'ink':
            return 'ink';
        case 'digital':
            return 'digital tools';
        case 'mixed_media':
            return 'mixed media';
        default:
            return $medium;
    }
}

/**
 * Format subject name for prompt text
 */
private function formatSubject($subject) {
    switch ($subject) {
        case 'landscape':
            return 'a landscape that evokes emotion';
        case 'portrait':
            return 'a portrait with an interesting expression';
        case 'still_life':
            return 'a still life arrangement of everyday objects';
        case 'abstract':
            return 'an abstract composition based on shapes and colors';
        case 'fantasy':
            return 'a fantasy scene from your imagination';
        case 'nature':
            return 'natural elements like plants or animals';
        default:
            return $subject;
    }
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
        
        // Insert into database
        $result = $this->db->query(
            "INSERT INTO saved_prompts (user_id, prompt_text) VALUES ($1, $2)",
            $userId, $prompt
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
    
    // If we get here, something went wrong
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

 /**
 * Show the dashboard page
 */
public function showDashboard() {
    // Check if user is logged in
    if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        // Redirect to login page
        header("Location: index.php?command=login");
        exit();
    }
    
    include("templates/dashboard.php");
}

/**
 * Delete a saved prompt
 */
public function deletePrompt() {
    // Check if user is logged in
    if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        header('Content-Type: application/json');
        echo json_encode([
            "success" => false,
            "message" => "You must be logged in to delete prompts"
        ]);
        exit();
    }
    
    // Get JSON data from request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    
    if (isset($data["prompt_id"])) {
        $promptId = $data["prompt_id"];
        $userId = $_SESSION["user_id"];
        
        // Make sure the prompt belongs to this user
        $result = $this->db->query(
            "DELETE FROM saved_prompts WHERE prompt_id = $1 AND user_id = $2",
            $promptId, $userId
        );
        
        if ($result) {
            header('Content-Type: application/json');
            echo json_encode([
                "success" => true,
                "message" => "Prompt deleted successfully"
            ]);
            exit();
        }
    }
    
    // If we get here, something went wrong
    header('Content-Type: application/json');
    echo json_encode([
        "success" => false,
        "message" => "Error deleting prompt"
    ]);
    exit();
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
            "SELECT COUNT(*) as count FROM users WHERE email = $1 OR username = $2",
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
            "INSERT INTO users (username, email, password_hash) VALUES ($1, $2, $3) RETURNING user_id",
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
        $conditions[] = "type LIKE $" . (count($params) + 1);
        $params[] = "%$category%";
    }
    
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
    $query = "SELECT * FROM challenges";
    
    if (!empty($conditions)) {
        $query .= " WHERE " . implode(" AND ", $conditions);
    }
    
    $query .= " ORDER BY created_at DESC";
    
    // Execute query
    $challenges = $this->db->query($query, ...$params);
    
    // Include template with challenges data
    include("templates/challenge-search.php");
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
    
    include("templates/challenge-detail.php");
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
        header("Location: index.php?command=challenge_detail&id=" . $challengeId);
        exit();
    }
}

}
?>