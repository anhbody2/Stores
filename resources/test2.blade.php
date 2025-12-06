<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test 2 - Chữ Huy</title>
    <style>
        .huy-container {
            text-align: center;
            padding: 50px;
        }
        
        .huy {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 120px;
            font-weight: 900;
            background: linear-gradient(45deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bff, #7a00ff, #ff00c8, #ff0000);
            background-size: 400% 400%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient 3s ease infinite, glow 1.5s ease-in-out infinite alternate;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes glow {
            from { filter: drop-shadow(0 0 5px #fff) drop-shadow(0 0 10px #fff) drop-shadow(0 0 15px #ff00ff); }
            to { filter: drop-shadow(0 0 10px #fff) drop-shadow(0 0 20px #fff) drop-shadow(0 0 30px #ff00ff); }
        }
        
        .subtitle {
            font-size: 24px;
            color: #666;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="huy-container">
        <div class="huy">HUY</div>
        <div class="subtitle">Chào mừng đến với trang của Huy!</div>
    </div>
</body>
</html>