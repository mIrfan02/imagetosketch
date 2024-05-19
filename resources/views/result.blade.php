<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image to Sketch - Result</title>
    <!-- Add your CSS styling here -->
    <style>
        /* General styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f5f5f5;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

h1 {
    color: #333;
}

h2 {
    color: #666;
}

/* Index page styling */
#upload-form {
    margin-bottom: 20px;
}

#images-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

#images-container img {
    max-width: 200px;
    margin: 10px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

#images-container img:hover {
    transform: scale(1.05);
}

/* Result page styling */
#result {
    text-align: center;
}

#images-container {
    margin-top: 20px;
}

#images-container img {
    max-width: 100%;
}

    </style>
</head>
<body>
    <h1>Uploaded Image Result</h1>
    <div id="result">
        <h2>Uploaded Image:</h2>
        <div id="images-container">
            <img src="{{ $sketch_url }}" alt="Sketch">
        </div>
    </div>
</body>
</html>
