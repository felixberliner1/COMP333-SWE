<?php
session_start();
include("connection.php");

$database = new Database(); 
$conn = $database->getConnection();  

header("Content-Type: application/json");

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    echo json_encode(["message" => "User is already logged in."]);
    http_response_code(400);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['user'], $data['pass'], $data['confirm_pass'])) {
        $username = $data['user'];
        $password = $data['pass'];
        $confirm_password = $data['confirm_pass'];

        if (strlen($password) < 10) {
            echo json_encode(["message" => "Password must be at least 10 characters long."]);
            http_response_code(400);
            exit();
        }

        if ($password !== $confirm_password) {
            echo json_encode(["message" => "Passwords do not match."]);
            http_response_code(400);
            exit();
        }

        $sql_check = "SELECT * FROM login WHERE username = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $username);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) > 0) {
            echo json_encode(["message" => "Username already taken. Please choose another."]);
            http_response_code(400);
            exit();
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO login (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
            echo json_encode(["message" => "Registration successful! Redirecting to welcome page."]);
            http_response_code(201);
        } else {
            echo json_encode(["message" => "Error: Unable to register. Please try again later."]);
            http_response_code(500);
        }

        mysqli_stmt_close($stmt);
        mysqli_stmt_close($stmt_check);
        mysqli_close($conn);
    } else {
        echo json_encode(["message" => "Username, Password, and Confirm Password are required."]);
        http_response_code(400);
    }
} else {
    echo json_encode(["message" => "Invalid request method. Use POST."]);
    http_response_code(405);
}
?>
