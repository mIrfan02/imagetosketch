<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image to Sketch</title>
  <style>
    /* Adjusted CSS */
body {
    background-color: #e0e0e0;
    font-family: Arial, sans-serif;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
}

h1 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 1rem;
}

form {
    background: #e0e0e0;
    border-radius: 20px;
    box-shadow: 20px 20px 60px #bebebe, -20px -20px 60px #ffffff;
    padding: 2rem;
    margin-bottom: 2rem;
    width: 300px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

input[type="file"] {
    background: #e0e0e0;
    border: none;
    border-radius: 10px;
    box-shadow: inset 5px 5px 10px #bebebe, inset -5px -5px 10px #ffffff;
    padding: 0.5rem;
    margin-bottom: 1rem;
    outline: none;
    color: #333;
    width: 100%;
    text-align: center;
}

button {
    background: #e0e0e0;
    border: none;
    border-radius: 10px;
    box-shadow: 5px 5px 10px #bebebe, -5px -5px 10px #ffffff;
    padding: 0.5rem 1rem;
    cursor: pointer;
    transition: box-shadow 0.3s ease;
}

button:hover {
    box-shadow: inset 5px 5px 10px #bebebe, inset -5px -5px 10px #ffffff;
}

#result {
    width: 80%;
    text-align: center;
}

#result h2 {
    color: #333;
    margin-bottom: 1rem;
}

#result div {
    display: flex;
    justify-content: center;
    margin-bottom: 1rem;
}

/* Adjusted image size */
#images-container img {
    max-width: 100%; /* Set maximum width to fit container */
    max-height: 300px; /* Limit height to avoid oversized images */
    border-radius: 10px;
    margin: 10px;
}

  </style>
</head>
<body>
    <h1>Upload an Image to Generate a Sketch</h1>
    <form id="upload-form" method="post" enctype="multipart/form-data" action="/upload">
        @csrf
        <input type="file" id="image-upload" name="image" accept="image/*">
        <button type="submit">Upload</button>
    </form>
    <div id="result">
        <h2>Uploaded Images:</h2>
        <div id="images-container"></div>
    </div>
    <script>
        document.getElementById('upload-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('/upload', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                const imagesContainer = document.getElementById('images-container');
                imagesContainer.innerHTML = ''; // Clear previous images
                const newImageDiv = document.createElement('div');
                newImageDiv.innerHTML = `
                    <img src="${data.sketch_url.replace('/sketches', '/images')}" alt="Original">
                    <img src="${data.sketch_url}" alt="Sketch">
                `;
                imagesContainer.appendChild(newImageDiv); // Add the new images
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
