<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <style>
        body {
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-color: #f0f0f0; /* Optional: Set a background color */
        }

        .video-container {
            width: 100%;
        }

        video {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="video-container">
        <video controls autoplay loop>
            <source src="video1.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
</body>
</html>
