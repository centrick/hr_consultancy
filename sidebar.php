<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        /* Basic CSS for styling the admin panel */
        body {
            font-family: Arial, sans-serif;
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
            display: flex; /* Use flex layout to fill the height */
        }
        #sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 10px;
            /* Make the sidebar fill the available height */
            height: 100vh;
            position: fixed; /* Fixed position to keep it visible when scrolling */
            transition: width 0.3s; /* Add transition for smooth animation */
        }
        #content {
            margin-left: 250px; /* Adjusted margin-left */
            padding: 20px;
            flex: 1; /* Fill the remaining horizontal space */
            transition: margin-left 0.3s; /* Add transition for smooth animation */
        }
        .menu-item {
            padding: 10px 20px;
            text-decoration: none;
            display: block;
            color: #fff;
        }
        .menu-item:hover {
            background-color: #555;
        }
        .menu-item.collapsed {
            display: none; /* Hide the text when collapsed */
        }
        #collapseButton {
            position: absolute;
            top: 10px;
            right: 28px;
            cursor: pointer;
            color: #fff;
            font-size: 34px; /* Adjust the font size to make the hamburger icon bigger */
        }
        #sidebar.collapsed {
            width: 60px; /* Adjusted width when collapsed */
        }

        #content.collapsed {
            margin-left: 60px; /* Adjusted margin-left when collapsed */
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <h2><a class="menu-item" href="admin_home.php">Admin Panel</a></h2>
        <a class="menu-item" href="plan1_plan_a.php">Plan A</a>
        <a class="menu-item" href="planB.php">Plan B</a>
        <a class="menu-item" href="planC.php">Plan C</a>
        <a class="menu-item" href="planD.php">Plan D</a>
        <a class="menu-item" href="planE.php">Plan E</a>
        <div id="collapseButton" onclick="toggleSidebar()">&#9776;</div>
    </div>



    <!-- JavaScript to handle the sidebar collapsing -->
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const content = document.getElementById("content");
            const menuItems = document.querySelectorAll(".menu-item");

            sidebar.classList.toggle("collapsed");
            content.classList.toggle("collapsed");
            menuItems.forEach(item => item.classList.toggle("collapsed"));
        }
    </script>
</body>
</html>
