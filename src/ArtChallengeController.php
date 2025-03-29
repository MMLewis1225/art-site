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
            case "challenges":
                $this->showChallenges();
                break;
            case "challenge_search":
                $this->showChallengeSearch();
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
        include("templates/index.php");
    }
    
    /**
     * Show the login page
     */
    public function showLogin() {
        include("templates/login.php");
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
}
?>