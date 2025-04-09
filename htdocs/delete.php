<?php
session_start();
include("connection.php");

$database = new Database();
$conn = $database->getConnection();

header("Content-Type: application/json");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['id'])) {
            http_response_code(400);
            echo json_encode(["message" => "ID not provided."]);
            exit;
        }

        if (!isset($_SESSION['username'])) {
            http_response_code(403);
            echo json_encode(["message" => "User not logged in."]);
            exit;
        }

        $id = $data['id'];
        $stmt = $conn->prepare("DELETE FROM ratings WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            http_response_code(200);
            echo json_encode(["message" => "Entry deleted successfully."]);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Entry not found or already deleted."]);
        }

        $stmt->close();
    } else {
        http_response_code(405);
        echo json_encode(["message" => "Invalid request method. Use DELETE."]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Server error.", "error" => $e->getMessage()]);
}
?>
