<?php include 'sidebar.php'; ?>

<div id="content">
    <h1>Welcome, Admin!</h1>

    <!-- Chart container (you can add your charts here) -->
    <div class="chart-container">
        <!-- Your charts go here -->
    </div>

    <!-- Feedback table -->
    <style>
        #feedbackTable {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .no-feedback {
            font-style: italic;
            color: #888;
        }
    </style>

    <div id="feedbackTable">
        <table>
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Email</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include your database connection code
                include 'db_connection.php';

                // Check if the connection is successful
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch feedback data for unsubscribed clients
                $feedbackData = [];
                $feedbackQuery = "SELECT feedback_form.client_id, clients.clientName, clients.email, feedback_form.feedback_text, feedback_form.status
                FROM feedback_form
                LEFT JOIN clients ON feedback_form.client_id = clients.id";

                $feedbackResult = $conn->query($feedbackQuery);

                if ($feedbackResult) {
                    if ($feedbackResult->num_rows > 0) {
                        while ($row = $feedbackResult->fetch_assoc()) {
                            $feedbackData[] = [
                                "clientName" => $row["clientName"],
                                "email" => $row["email"],
                                "feedback" => $row["feedback_text"],
                                "status" => $row["status"],
                            ];
                        }

                        // Output rows in the table
                        foreach ($feedbackData as $feedback) {
                            echo "<tr>";
                            echo "<td>{$feedback['clientName']}</td>";
                            echo "<td>{$feedback['email']}</td>";
                            echo "<td>{$feedback['feedback']}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No feedback available for unsubscribed clients.</td></tr>";
                    }
                } else {
                    echo "Error: " . $conn->error;
                }

                // Close your database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>
