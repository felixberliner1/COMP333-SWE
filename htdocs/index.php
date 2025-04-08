<?php
header("Content-Type: application/json"); 

session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['user']) && isset($data['pass'])) {
        $user = $data['user'];
        $pass = $data['pass'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            
            if (password_verify($pass, $user_data['password'])) {
                $_SESSION['username'] = $user_data['username'];
                echo json_encode(["message" => "Login successful."]);
                http_response_code(200); 
            } else {
                echo json_encode(["message" => "Username or Password Incorrect."]);
                http_response_code(401);
            }
        } else {
            echo json_encode(["message" => "Username or Password Incorrect."]);
            http_response_code(401);
        }
    } else {
        echo json_encode(["message" => "Username and Password are required."]);
        http_response_code(400);
    }
} else {
    echo json_encode(["message" => "Invalid request method. Use POST."]);
    http_response_code(405);
}
?>
