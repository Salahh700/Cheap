<?php
$site_name = "Cheap";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page non trouvée | <?php echo $site_name; ?></title>
    <link rel="stylesheet" href="../style/enhanced-styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .error-404 {
            text-align: center;
            color: white;
            z-index: 10;
            animation: fadeInUp 1s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .error-number {
            font-size: 12rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 1rem;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: glitch 2s infinite;
        }

        @keyframes glitch {
            0%, 100% { text-shadow: 0 0 0 transparent; }
            25% { text-shadow: 5px 0 0 rgba(255, 0, 0, 0.7), -5px 0 0 rgba(0, 255, 255, 0.7); }
            50% { text-shadow: -5px 0 0 rgba(255, 0, 0, 0.7), 5px 0 0 rgba(0, 255, 255, 0.7); }
            75% { text-shadow: 2px 2px 0 rgba(255, 0, 0, 0.7), -2px -2px 0 rgba(0, 255, 255, 0.7); }
        }

        .error-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            animation: fadeIn 1.5s ease 0.3s backwards;
        }

        .error-message {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            animation: fadeIn 1.5s ease 0.6s backwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .error-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeIn 1.5s ease 0.9s backwards;
        }

        .btn {
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: white;
            color: #667eea;
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        /* Floating elements animation */
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            z-index: 1;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-100px) rotate(180deg); }
        }

        .circle-1 {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .circle-2 {
            width: 150px;
            height: 150px;
            top: 50%;
            left: 80%;
            animation-delay: 2s;
        }

        .circle-3 {
            width: 80px;
            height: 80px;
            top: 70%;
            left: 15%;
            animation-delay: 4s;
        }

        .circle-4 {
            width: 120px;
            height: 120px;
            top: 20%;
            right: 10%;
            animation-delay: 6s;
        }

        /* Astronaut animation */
        .astronaut {
            font-size: 5rem;
            animation: astronaut-float 5s ease-in-out infinite;
            display: inline-block;
        }

        @keyframes astronaut-float {
            0%, 100% { transform: translateY(0) rotate(-10deg); }
            50% { transform: translateY(-30px) rotate(10deg); }
        }

        @media (max-width: 768px) {
            .error-number {
                font-size: 8rem;
            }

            .error-title {
                font-size: 1.75rem;
            }

            .error-message {
                font-size: 1rem;
            }

            .error-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Elements -->
    <div class="floating-elements">
        <div class="floating-circle circle-1"></div>
        <div class="floating-circle circle-2"></div>
        <div class="floating-circle circle-3"></div>
        <div class="floating-circle circle-4"></div>
    </div>

    <!-- Error Content -->
    <div class="error-404">
        <div class="astronaut">🚀</div>
        <div class="error-number">404</div>
        <h1 class="error-title">Oups ! Page non trouvée</h1>
        <p class="error-message">
            Il semblerait que vous vous soyez perdu dans l'espace...<br>
            Cette page n'existe pas ou a été déplacée.
        </p>
        <div class="error-buttons">
            <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
            <a href="home.php" class="btn btn-secondary">Voir les comptes</a>
        </div>
    </div>

    <script>
        // Easter egg: click on astronaut
        document.querySelector('.astronaut').addEventListener('click', function() {
            this.style.animation = 'none';
            setTimeout(() => {
                this.style.animation = 'astronaut-float 0.5s ease-in-out';
                setTimeout(() => {
                    this.style.animation = 'astronaut-float 5s ease-in-out infinite';
                }, 500);
            }, 10);
        });

        // Add more floating circles on mouse move
        document.addEventListener('mousemove', function(e) {
            if (Math.random() > 0.95) {
                const circle = document.createElement('div');
                circle.className = 'floating-circle';
                circle.style.width = Math.random() * 50 + 30 + 'px';
                circle.style.height = circle.style.width;
                circle.style.left = e.clientX + 'px';
                circle.style.top = e.clientY + 'px';
                document.querySelector('.floating-elements').appendChild(circle);

                setTimeout(() => circle.remove(), 20000);
            }
        });
    </script>
</body>
</html>
