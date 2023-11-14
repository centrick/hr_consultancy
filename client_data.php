<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "alena_admin";

// Create a database connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch chart data
$chartData = [];
$chartQuery = "SELECT p.name as plan, COUNT(pc.id) as count
               FROM plans p
               LEFT JOIN plan_counts pc ON p.id = pc.plan_id
               GROUP BY p.id";
$chartResult = $conn->query($chartQuery);

if ($chartResult->num_rows > 0) {
    while ($row = $chartResult->fetch_assoc()) {
        $chartData[] = [
            "plan" => $row["plan"],
            "count" => $row["count"],
        ];
    }
}

// Fetch feedback data
$feedbackData = [];
$feedbackQuery = "SELECT feedback_form.client_id, clients.clientName, feedback_form.email, feedback_form.feedback_text, feedback_form.status
                  FROM feedback_form
                  LEFT JOIN clients ON feedback_form.client_id = clients.id";
$feedbackResult = $conn->query($feedbackQuery);

if ($feedbackResult->num_rows > 0) {
    while ($row = $feedbackResult->fetch_assoc()) {
        $feedbackData[] = [
            "clientName" => $row["clientName"],
            "email" => $row["email"],
            "feedback" => $row["feedback_text"],
            "status" => $row["status"],
        ];
    }
}

// Combine both data sets
$resultData = [
    "chartData" => $chartData,
    "feedbackData" => $feedbackData,
];

// Output the data as JSON
echo json_encode($resultData);

$conn->close();
?>
