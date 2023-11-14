<?php include 'sidebar.php'; ?>
<div id="content">
    <h1>Welcome, Admin!</h1>
    <?php
    // Include your database connection code
    include 'db_connection.php';

    // Check if the connection is successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch card data from the database
    $cardData = [];
    $cardQuery = "SELECT plans.id as plan_id, plans.name as plan_name, SUM(`count`) as people_count 
    FROM plan_counts
    JOIN plans ON plan_counts.plan_id = plans.id
    WHERE plan_counts.client_status = 'subscribed' 
    GROUP BY plan_counts.plan_id";

    $cardResult = $conn->query($cardQuery);

    if ($cardResult) {
        if ($cardResult->num_rows > 0) {
            echo "<div class='card-row'>";
            while ($row = $cardResult->fetch_assoc()) {
                $cardData[] = [
                    "plan_id" => $row["plan_id"],
                    "plan_name" => $row["plan_name"],
                    "people_count" => $row["people_count"],
                ];

                // Output dynamically generated cards with the class name 'plans_card'
                echo "<div class='card plans_card' onclick='showCardDetails(\"" . $row['plan_id'] . "\", \"" . $row['plan_name'] . "\")'>";
                echo "<h2>" . $row['plan_name'] . "</h2>";
                echo "<p>People Count: {$row['people_count']}</p>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No card data available.</p>";
        }
    } else {
        echo "Error: " . $conn->error;
    }

    // Close your database connection
    $conn->close();
    ?>

    <!-- Additional container to display details when a card is clicked -->
    <div id="cardDetailsContainer" style="display: none;">
        <h2 id="cardDetailsTitle"></h2>
        <ul id="cardPlans"></ul>
    </div>
<br><br>
    <!-- Video section -->
    <video class="testimonialvideo" autoplay loop muted>
    <source src="video1.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>

    <br><br>
    <div class="card-container">
        <div class="card">
            <div class="chart-container">
                <div class="chart">
                    <canvas id="planAnalysisChart" width="600" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="chart-container">
                <div class="piechart">
                    <canvas id="planDistributionChart" width="300" height="225"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                    LEFT JOIN clients ON feedback_form.client_id = clients.id
                    WHERE feedback_form.status = 'Unsubscribed'";
                
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
    <style>
        .testvideo-container {
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f0f0; /* Optional: Set a background color */
        }

        .testimonialvideo-container {
            width: 100%;
        }

        .testimonialvideo {
            width: 100%;
            height: auto;
        }
         .card-row {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .card.plans_card {
            cursor: pointer;
            width: 200px;
            padding: 10px;
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease;
        }

        .card.plans_card:hover {
            background-color: #f5f5f5;
        }
    ##feedbackTable {
    margin-top: 20px;
    overflow-x: auto; /* Add horizontal scroll if needed */
}

#feedbackTable table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

#feedbackTable th, #feedbackTable td {
    border: 1px solid #ddd;
    padding: 8px; /* Adjust padding as needed */
    text-align: left;
    /* Add the following line to prevent text overflow */
    word-wrap: break-word;
    max-width: 300px; /* Set a maximum width for the cells */
    overflow: hidden;
    text-overflow: ellipsis; /* Add ellipsis for text overflow */
}

#feedbackTable th {
    background-color: #f2f2f2;
}
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        /* Add the following line to prevent text overflow */
        word-wrap: break-word;
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

        .card-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .card {
            width: 48%;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .chart-container {
            display: flex;
            justify-content: space-between;
            height: 300px;
        }

        .chart,
        .piechart {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #planAnalysisChart,
        #planDistributionChart {
            max-width: 100%;
            max-height: 100%;
        }
        #feedbackTable {
            margin-top: 20px;
        }

        #feedbackTable table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        #feedbackTable th, #feedbackTable td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        #feedbackTable th {
            background-color: #f2f2f2;
        }
    </style>
<script>
    // Get a reference to the canvas elements
    const planAnalysisCanvas = document.getElementById("planAnalysisChart");
    const planDistributionCanvas = document.getElementById("planDistributionChart");

    // Fetch combined data from the database
    fetch('client_data.php')
        .then(response => response.json())
        .then(data => {
            // Data is available in the 'data' variable, create your charts and table here
            createCharts(data.chartData);
            updateFeedbackTable(data.feedbackData);
        })
        .catch(error => console.error('Error fetching data:', error));

    // Create the analysis chart
    const planAnalysisChart = new Chart(planAnalysisCanvas, {
        type: 'bar',
        data: getDefaultData(),
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Create the distribution chart
    const planDistributionChart = new Chart(planDistributionCanvas, {
        type: 'doughnut',
        data: getDefaultData()
    });

    function getDefaultData() {
        return {
            labels: ["Plan A", "Plan B", "Plan C", "Plan D", "Plan E"],
            datasets: [{
                label: 'Number of People',
                data: [30, 45, 20, 15, 50], // Default data
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderWidth: 1
            }]
        };
    }

    function createCharts(data) {
        // Use the fetched data to create your charts
        const planLabels = data.map(item => item.plan);
        const planCounts = data.map(item => item.count);

        // Update the data for the bar chart
        planAnalysisChart.data.labels = planLabels;
        planAnalysisChart.data.datasets[0].data = planCounts;
        planAnalysisChart.update();

        // Update the data for the doughnut chart
        planDistributionChart.data.labels = planLabels;
        planDistributionChart.data.datasets[0].data = planCounts;
        planDistributionChart.update();
    }
     // Function to redirect to the corresponding plan page when a card is clicked
     function showCardDetails(planId, planName) {
            // Create a URL-friendly version of the plan name
            const urlFriendlyPlanName = planName.toLowerCase().replace(/\s+/g, '_');
            
            // Construct the URL for the plan page
            const planPageURL = `http://localhost/admin_panel/plan${planId}_${urlFriendlyPlanName}.php`;
            
            // Redirect to the plan page
            window.location.href = planPageURL;
        }
    


</script>
