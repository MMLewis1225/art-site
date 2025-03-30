<?php
/**
 * Database Class
 *
 * Contains connection information to query PostgresSQL.
 */


class Database {
    private $dbConnector;

    /**
     * Constructor
     *
     * Connects to PostgresSQL
     */
    public function __construct() {
        $host = Config::$db["host"];
        $user = Config::$db["user"];
        $database = Config::$db["database"];
        $password = Config::$db["pass"];
        $port = Config::$db["port"];

        $this->dbConnector = pg_connect("host=$host port=$port dbname=$database user=$user password=$password");
    }

    /**
     * Query
     *
     * Makes a query to posgres and returns an array of the results.
     * The query must include placeholders for each of the additional
     * parameters provided.
     */
    public function query($query, ...$params) {
        $res = pg_query_params($this->dbConnector, $query, $params);
        if ($res === false) {
            $error = pg_last_error($this->dbConnector);
            error_log("Database Error: " . $error);  // This logs to the server error log
            return false;
        }
        return pg_fetch_all($res);
    }
}


/*

<?php
require_once "src/Config.php";

class Database {
    private $dbConnector;
    
    public function __construct() {
        $host = Config::$db["host"];
        $user = Config::$db["user"];
        $database = Config::$db["database"];
        $password = Config::$db["pass"];
        $port = Config::$db["port"];
        
        $connectionString = "host=$host port=$port dbname=$database user=$user password=$password";
        $this->dbConnector = pg_connect($connectionString);
        
        if (!$this->dbConnector) {
            echo "Database Connection Error: " . pg_last_error();
            exit();
        }
    }
    
    public function query($query, ...$params) {
        $result = pg_query_params($this->dbConnector, $query, $params);
        
        if (!$result) {
            echo "Query Error: " . pg_last_error($this->dbConnector);
            return false;
        }
        
        // For INSERT, UPDATE, DELETE
        if (stripos($query, 'INSERT') === 0 || stripos($query, 'UPDATE') === 0 || stripos($query, 'DELETE') === 0) {
            return true;
        }
        
        // For SELECT
        return pg_fetch_all($result) ?: [];
    }
    
    // Get the last inserted ID (for PostgreSQL)
    public function lastInsertId($table, $id_column = 'id') {
        $query = "SELECT LASTVAL() AS id";
        $result = pg_query($this->dbConnector, $query);
        
        if ($result && $row = pg_fetch_assoc($result)) {
            return $row['id'];
        }
        
        return null;
    }
}
?>*/