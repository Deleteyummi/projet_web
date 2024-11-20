
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Culture Hub</title>
    <style>
        /* Corps du site */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            transition: background-color 0.3s ease; /* Transition douce pour la couleur de fond */
        }

        /* Header */
        header {
            background-color: #FF6F61; /* Couleur vive pour l'en-tête */
            color: white;
            text-align: center;
            padding: 20px 0;
            position: relative;
            animation: fadeIn 2s ease-in-out;
        }

        header h1 {
            font-size: 36px;
            text-transform: uppercase;
            letter-spacing: 2px;
            animation: slideIn 1s ease-out;
        }

        /* Formulaire de sélection de région */
        .region-select {
            position: absolute;
            top: 10px;
            right: 20px;
            background-color: #fff;
            color: #333;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            border: 1px solid #ddd;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .region-select:hover {
            background-color: #FF6F61;
            color: white;
        }

        /* Barre de connexion/déconnexion */
        .login-container a {
            color: white;
            text-decoration: none;
            margin-left: 10px;
            padding: 5px;
            font-weight: bold;
            border-radius: 5px;
            background-color: #1D72B8;
            transition: background-color 0.3s ease;
        }

        .login-container a:hover {
            background-color: #FF6F61;
        }

        /* Contenu principal */
        .content {
            margin: 20px;
            animation: fadeIn 2s ease-out;
        }

        /* Section des pays */
        .country-section {
            display: flex;
            margin-bottom: 40px;
            justify-content: space-between;
            opacity: 0;
            animation: fadeInUp 1s ease-in-out forwards;
        }

        .country-description {
            width: 60%;
            font-size: 16px;
            color: #666;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .country-image {
            width: 35%;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .country-image:hover {
            transform: scale(1.05); /* Zoom léger lors du survol de l'image */
        }

        .country-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
            animation: fadeIn 1s ease-out;
        }

        /* Formulaire de contact */
        .contact-form {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border 0.3s ease;
        }

        .contact-form input:focus, .contact-form textarea:focus {
            border-color: #FF6F61; /* Bordure rouge lors de la saisie */
        }

        .contact-form button {
            background-color: #FF6F61;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .contact-form button:hover {
            background-color: #D55B4C;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            animation: fadeIn 2s ease-in-out;
        }

        footer p {
            font-size: 14px;
        }

        footer a {
            color: #FF6F61;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            color: #fff;
        }

        /* Animation keyframes */
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(0);
            }
        }

    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diversité Culturelle</title>
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1 class="title">🌍 Diversité Culturelle</h1>
            <p class="subtitle">Explorez les cultures uniques du monde entier</p>
        </div>
    </header>

    </header>

    <section class="content">
    <!-- Section France -->
    <div class="country-section" data-region="Europe">
        <div class="text-and-image">
            <div class="country-description">
                <h2 class="country-title">🇫🇷 Culture de la France</h2>
                <p>La France est un pays riche en histoire, en art et en gastronomie. Sa culture est profondément marquée par l'impact des grandes périodes historiques comme la Renaissance et la Révolution française. La cuisine française, le vin, ainsi que des monuments emblématiques comme la Tour Eiffel et le Louvre sont des symboles culturels importants.</p>
                <a href="#france" class="learn-more">En savoir plus</a>
            </div>
            <div class="image-container">
                <img src="france.jpg" alt="La Tour Eiffel, France" class="country-image">
            </div>
        </div>
    </div>

    <!-- Section Japon -->
    <div class="country-section" data-region="Asie">
        <div class="text-and-image reverse">
            <div class="country-description">
                <h2 class="country-title">🇯🇵 Culture du Japon</h2>
                <p>Le Japon est connu pour sa fusion unique entre tradition et modernité. Des arts anciens comme le théâtre Noh et la cérémonie du thé coexistent avec des avancées technologiques remarquables. Les festivals comme le Hanami et les traditions telles que la calligraphie et la couture sont au cœur de la culture japonaise.</p>
                <a href="#japan" class="learn-more">En savoir plus</a>
            </div>
            <div class="image-container">
                <img src="japon.jpg" alt="Temples au Japon" class="country-image">
            </div>
        </div>
    </div>

    <!-- Section Brésil -->
    <div class="country-section" data-region="Amérique">
        <div class="text-and-image">
            <div class="country-description">
                <h2 class="country-title">🇧🇷 Culture du Brésil</h2>
                <p>Le Brésil est un mélange vibrant de cultures indigènes, africaines et européennes. Le carnaval de Rio, la samba et le football sont des éléments clés de l'identité brésilienne. La musique et la danse occupent une place centrale dans la vie brésilienne, et la diversité de ses paysages, des plages aux forêts tropicales, influence également sa culture.</p>
                <a href="#brazil" class="learn-more">En savoir plus</a>
            </div>
            <div class="image-container">
                <img src="brazil.jpg" alt="Carnaval du Brésil" class="country-image">
            </div>
        </div>
    </div>

    <!-- Section Maroc -->
    <div class="country-section" data-region="Afrique">
        <div class="text-and-image reverse">
            <div class="country-description">
                <h2 class="country-title">🇲🇦 Culture du Maroc</h2>
                <p>Le Maroc, avec ses influences berbères, arabes et françaises, offre une culture riche et diversifiée. La médina de Fès, les marchés animés et les plats épicés comme le couscous et le tajine sont des éléments incontournables. Les mosaïques, les tapis et les arts traditionnels ont une grande importance dans la culture marocaine.</p>
                <a href="#morocco" class="learn-more">En savoir plus</a>
            </div>
            <div class="image-container">
                <img src="maroc.jpg" alt="Médina de Fès, Maroc" class="country-image">
            </div>
        </div>
    </div>
</section>


        <!-- Formulaire de contact -->
        <div class="contact-form">
            <h3>Contactez-nous</h3>
            <p>Pour toute question ou suggestion, veuillez remplir le formulaire ci-dessous :</p>
            <form action="mailto:contact@culturehub.com" method="post" enctype="text/plain">
                <input type="text" name="nom" placeholder="Votre nom" required>
                <input type="email" name="email" placeholder="Votre email" required>
                <textarea name="message" rows="4" placeholder="Votre message" required></textarea>
                <button type="submit">Envoyer</button>
            </form>
        </div>
    </div>

    <footer class="site-footer">
    <div class="footer-container">
        <!-- About Section -->
        <div class="footer-about">
            <h3>🌍 Diversité Culturelle</h3>
            <p>Explorez, apprenez et célébrez la richesse des cultures du monde entier. Découvrez les traditions, festivals, et trésors culturels qui nous unissent.</p>
        </div>

        <!-- Quick Links Section -->
        <div class="footer-links">
            <h4>Liens rapides</h4>
            <ul>
                <li><a href="#france">France</a></li>
                <li><a href="#japan">Japon</a></li>
                <li><a href="#brazil">Brésil</a></li>
                <li><a href="#morocco">Maroc</a></li>
            </ul>
        </div>

        <!-- Social Media Section -->
        <div class="footer-social">
            <h4>Restez connectés</h4>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2024 Diversité Culturelle | Tous droits réservés</p>
    </div>
</footer>


</body>
</html>
