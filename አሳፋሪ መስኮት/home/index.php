<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Resizer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        form {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        img {
            margin-top: 20px;
            border: 2px solid #000;
            border-radius: 10px;
        }
        .download-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .download-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>አሳፋሪ መስኮት</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['url'])) {
        $url = $_POST['url'];
        $resizeType = $_POST['resize_type'];

        // Initialize cURL to fetch the image from the URL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Fetch the content
        $data = curl_exec($ch);
        curl_close($ch);

        if ($data !== false) {
            // Encode the image data to base64
            $base64 = base64_encode($data);
            $image_src = 'data:image/jpeg;base64,' . $base64;

            // Determine new width and height based on user input
            if ($resizeType == 'percent') {
                $percent = (int)$_POST['percent'];
                $style = "width: $percent%; height: auto;";
            } elseif ($resizeType == 'pixels') {
                $new_width = (int)$_POST['width'];
                $new_height = (int)$_POST['height'];
                $style = "width: {$new_width}px; height: {$new_height}px;";
            }

            // Output the resized image using HTML/CSS
            echo "<img src='$image_src' style='$style' alt='Resized Image'>";

            // Add a download button
            echo "<a href='$image_src' download='resized_image.jpg' class='download-btn'>Download Image</a>";
        } else {
            echo '<p>Failed to fetch the URL.</p>';
        }
    } else {
        ?>
        <form method="post">
            <label for="url">Enter Image URL:</label>
            <input type="text" id="url" name="url" required><br><br>

            <label>Select Resize Option:</label><br>
            <input type="radio" id="percent" name="resize_type" value="percent" checked>
            <label for="percent">Resize by Percentage</label><br>
            <label for="percent">Percentage (1-100):</label>
            <input type="number" id="percent" name="percent" min="1" max="100" value="50"><br><br>

            <input type="radio" id="pixels" name="resize_type" value="pixels">
            <label for="pixels">Resize by Pixels</label><br>
            <label for="width">Width (px):</label>
            <input type="number" id="width" name="width" min="1"><br>
            <label for="height">Height (px):</label>
            <input type="number" id="height" name="height" min="1"><br><br>

            <button type="submit">Fetch and Resize Image</button>
        </form>
        <?php
    }
    ?>

</body>
</html>
