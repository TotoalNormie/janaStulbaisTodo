<?php
class TaskDB {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "task_management";
    private $conn;

    function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function getAllTasks() {
        try {
            $query = $this->conn->query("SELECT * FROM tasks");
            $tasks = $query->fetchAll(PDO::FETCH_ASSOC);
            return $tasks;
        } catch (PDOException $e) {
            return false; // Return an error status or message
        }
    }

    function getTaskById($id) {
        try {
            $query = $this->conn->prepare("SELECT * FROM tasks WHERE id = ?");
            $query->execute([$id]);
            $task = $query->fetch(PDO::FETCH_ASSOC);
            return $task;
        } catch (PDOException $e) {
            return false; // Return an error status or message
        }
    }

    function createTask($title, $description, $due_date, $status) {
        try {
            $query = $this->conn->prepare("INSERT INTO tasks (title, description, due_date, status) VALUES (?, ?, ?, ?)");
            $query->execute([$title, $description, $due_date, $status]);
            return true; // Return a success status or relevant data
        } catch (PDOException $e) {
            return false; // Return an error status or message
        }
    }

    function updateTask($id, $title, $description, $due_date, $status) {
        try {
            $query = $this->conn->prepare("UPDATE tasks SET title = ?, description = ?, due_date = ?, status = ? WHERE id = ?");
            $query->execute([$title, $description, $due_date, $status, $id]);
            return true; // Returno success or relevantu info
        } catch (PDOException $e) {
            return false; // Returno error status or message
        }
    }

    function deleteTask($id) {
        try {
            $query = $this->conn->prepare("DELETE FROM tasks WHERE id = ?");
            $query->execute([$id]);
            return true; // Returno success or relevantu info
        } catch (PDOException $e) {
            return false; // Returno error status or message
        }
    }
}
?>