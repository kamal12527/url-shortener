<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URL Shortener</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        /* General Page Styling */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Container Card */
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 400px;
        }

        h1 {
            margin-bottom: 15px;
            color: #333;
        }

        /* Input Field */
        input {
            width: calc(100% - 20px);
            padding: 10px;
            margin-top: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
        }

        input:focus {
            border-color: #667eea;
            outline: none;
        }

        /* Shorten Button */
        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #5648a2;
        }

        /* Shortened URL */
        #shortened-url-container {
            display: none;
            margin-top: 20px;
            padding: 10px;
            background: #f8f8f8;
            border-radius: 5px;
        }

        #shortened-url {
            font-weight: bold;
            word-break: break-all;
        }

        /* Copy Button */
        .copy-btn {
            background: #28a745;
            margin-top: 10px;
            display: inline-block;
            padding: 10px 15px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .copy-btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Laravel URL Shortener</h1>
        <form id="shorten-form">
            <input type="url" id="original_url" name="original_url" placeholder="Enter URL" required>
            <button type="submit">Shorten</button>
        </form>

        <div id="shortened-url-container">
            <p>Shortened URL: <a id="shortened-url" href="#" target="_blank"></a></p>
            <button class="copy-btn" id="copy-btn">Copy</button>
        </div>
    </div>

    <script>
        document.getElementById('shorten-form').addEventListener('submit', function(event) {
            event.preventDefault();
            let urlInput = document.getElementById('original_url');
            let url = urlInput.value.trim();
            let button = event.target.querySelector('button');

            if (!isValidUrl(url)) {
                alert('Please enter a valid URL.');
                return;
            }

            button.disabled = true;
            button.innerText = 'Shortening...';

            axios.post('/shorten', { original_url: url })
                .then(response => {
                    let shortUrl = response.data.short_url;
                    document.getElementById('shortened-url').href = shortUrl;
                    document.getElementById('shortened-url').innerText = shortUrl;
                    document.getElementById('shortened-url-container').style.display = 'block';
                })
                .catch(error => {
                    alert('Error: Unable to shorten the URL.');
                })
                .finally(() => {
                    button.disabled = false;
                    button.innerText = 'Shorten';
                });
        });

        document.getElementById('copy-btn').addEventListener('click', function() {
            let shortUrl = document.getElementById('shortened-url').innerText;
            navigator.clipboard.writeText(shortUrl).then(() => {
                alert('Copied to clipboard!');
            });
        });

        function isValidUrl(string) {
            try { return Boolean(new URL(string)); } 
            catch (e) { return false; }
        }
    </script>

</body>
</html>
