<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:description" content="FOX-LEAK is a powerful tool that helps you discover files accessible via internet using the LeakIX engine">
    <meta property="og:title" content="FOX-LEAK">
    <meta property="og:image" content="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRLTdxEKQTm-9fHZaJ0dMHChOGq9wJgt2aDQ&usqp=CAU">
    <title>FOX-LEAK | Advanced File Discovery Tool</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #00ff00;
            --background-dark: #0a0a0a;
            --card-background: #111111;
            --text-color: #ffffff;
            --accent-color: #1a1a1a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: var(--background-dark);
            color: var(--text-color);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 3rem;
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 1rem;
            border: 2px solid var(--primary-color);
            padding: 5px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .description {
            color: #888;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .search-form {
            display: flex;
            gap: 1rem;
            max-width: 600px;
            margin: 0 auto;
            margin-bottom: 3rem;
        }

        .search-input {
            flex: 1;
            padding: 1rem;
            border: none;
            background: var(--accent-color);
            border-radius: 8px;
            color: var(--text-color);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px var(--primary-color);
        }

        .search-button {
            padding: 1rem 2rem;
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            color: var(--background-dark);
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .search-button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .results {
            display: grid;
            gap: 1.5rem;
        }

        .card {
            background: var(--card-background);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid #222;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 255, 0, 0.1);
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            color: var(--primary-color);
        }

        .card-content {
            display: grid;
            gap: 0.5rem;
        }

        .card-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-item i {
            color: var(--primary-color);
            width: 20px;
        }

        .card-link {
            color: var(--primary-color);
            text-decoration: none;
            word-break: break-all;
        }

        .card-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .search-form {
                flex-direction: column;
            }

            .search-button {
                width: 100%;
            }

            .title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRLTdxEKQTm-9fHZaJ0dMHChOGq9wJgt2aDQ&usqp=CAU" alt="FOX-LEAK Logo" class="logo">
            <h1 class="title">FOX-LEAK</h1>
            <p class="description">An advanced file discovery tool powered by LeakIX engine. Search and analyze files accessible through the internet with ease.</p>
        </header>

        <form class="search-form" method="GET">
            <input type="text" name="x" class="search-input" placeholder="Enter filename to search..." required>
            <button type="submit" class="search-button">
                <i class="fas fa-search"></i> Search
            </button>
        </form>

        <div class="results">
            <?php
            if(isset($_GET['x'])) {
                $url = "https://files.leakix.net/json?q=".$_GET['x'];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_USERAGENT, "leakix");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $exec = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($exec, true);

                if ($data && isset($data['data'])) {
                    foreach ($data['data'] as $element) {
                        echo '
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-network-wired"></i>
                                <h2 class="card-title">'.$element['ip'].'</h2>
                            </div>
                            <div class="card-content">
                                <div class="card-item">
                                    <i class="fas fa-server"></i>
                                    <span><strong>Host:</strong> '.$element['host'].'</span>
                                </div>
                                <div class="card-item">
                                    <i class="fas fa-file"></i>
                                    <span><strong>Filename:</strong> '.$element['filename'].'</span>
                                </div>
                                <div class="card-item">
                                    <i class="fas fa-link"></i>
                                    <span><strong>URL:</strong> <a href="'.$element['url'].'" class="card-link" target="_blank">'.$element['url'].'</a></span>
                                </div>
                                <div class="card-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span><strong>Last Updated:</strong> '.$element['last-updated'].'</span>
                                </div>
                            </div>
                        </div>';
                    }
                }
            }
            ?>
        </div>
    </div>
</body>
</html>