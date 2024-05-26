<?php
// Database connection parameters
require 'db.php';

try {
    $stmt = $conn->prepare("SELECT * FROM reports_t");
    $stmt->execute();

    // Fetch all the rows as an associative array
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the data as JSON
    echo json_encode($reports);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
