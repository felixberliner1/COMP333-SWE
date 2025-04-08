<?php
session_start();
include("connection.php");

$database = new Database(); 
$conn = $database->getConnection(); 

header("Content-Type: application/json"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['user']) && isset($data['pass'])) {
        $username = $data['user'];
        $password = $data['pass'];

        $sql = "SELECT password FROM login WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $hashed_password);

        if (mysqli_stmt_num_rows($stmt) === 1) {
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                $_SESSION['loggedin'] = true;

                echo json_encode(["message" => "Login successful."]);
                http_response_code(200);
            } else {
                echo json_encode(["message" => "Incorrect password."]);
                http_response_code(401);
            }
        } else {
            echo json_encode(["message" => "User not found."]);
            http_response_code(404);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo json_encode(["message" => "Username and Password are required."]);
        http_response_code(400);
    }
} else {
    echo json_encode(["message" => "Invalid request method. Use POST."]);
    http_response_code(405);
}
?>
