<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow: hidden; /* Prevents unnecessary scrollbars */
        }

        /* Fullscreen Spline Viewer */
        .spline-viewer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0; /* Background layer */
        }

        /* Events container styling */
        .events-container {
    position: relative;
    z-index: 1; /* Foreground layer */
    background-color: rgba(255, 255, 255, 0.9); /* Légèrement plus opaque pour une meilleure lisibilité */
    padding: 30px; /* Plus d'espace à l'intérieur */
    border-radius: 15px; /* Coins légèrement plus arrondis */
    max-width: 85%; /* Réduit légèrement pour un meilleur design */
    margin: 20px auto; /* Diminue la marge supérieure pour rapprocher les éléments */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); /* Ombre plus douce et subtile */
    display: flex; /* Flexbox layout */
    flex-wrap: wrap; /* Les éléments passent à la ligne si nécessaire */
    justify-content: space-evenly; /* Répartit uniformément les cartes */
    gap: 25px; /* Plus d'espacement entre les éléments */
    text-align: center;
}

/* Event styling */
.event {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    padding: 15px;
    max-width: 300px; /* Limit individual event size */
    flex: 1 1 calc(33.333% - 40px); /* Responsive layout: 3 items per row */
    box-sizing: border-box;
}

.event h3 {
    margin: 0 0 10px;
    color: #333;
}

.event p {
    margin: 5px 0;
    color: #555;
}

.event img {
    max-width: 100%;
    border-radius: 5px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
}


        /* Reservation form styling */
        #reservation-form-container {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 2;
            text-align: left;
        }

        #reservation-form label {
            display: block;
            margin-bottom: 5px;
        }

        #reservation-form input {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .reserve-btn {
            display: inline-block;
            background: linear-gradient(45deg, #ff7e5f, #feb47b);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .reserve-btn:hover {
            background: linear-gradient(45deg, #feb47b, #ff7e5f);
            transform: scale(1.05);
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.4);
        }

        .reserve-btn:active {
            transform: scale(0.98);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

 

    </style>
</head>
<body>
    <div class="spline-viewer">
    <spline-viewer url="https://prod.spline.design/SaNh02kzxXVHZOvI/scene.splinecode"></spline-viewer>
    </div>

    <div class="events-container">
        <h2>Upcoming Events</h2>

        <?php
        // Fetch events from the database
        try {
            $db = "mysql:host=localhost;dbname=event";
            $user = "root";
            $password = "";
            $connect = new PDO($db, $user, $password);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT * FROM event";
            $stmt = $connect->query($query);
            $events = $stmt->fetchAll();

            foreach ($events as $event) {
                echo "<div class='event'>
                        <h3>{$event['nom']}</h3>
                        <p>Date: {$event['date']}</p>
                        <p>Place: {$event['lieu']}</p>
                        <img src='{$event['photo']}' alt='Event Image'>
                        <a href='../view/front/Reserve.html?event_id={$event['id']}' class='reserve-btn'>Reserve</a>
                      </div>";
            }
        } catch (PDOException $e) {
            echo "Problem: " . $e->getMessage();
        }
        ?>
    </div>

    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.48/build/spline-viewer.js"></script>
    <script>
        // Remove Spline logo
        window.onload = function () {
            const shadowRoot = document.querySelector('spline-viewer').shadowRoot;
            if (shadowRoot) {
                const logo = shadowRoot.querySelector('#logo');
                if (logo) logo.remove();
            }
        };

        // Show reservation form on button click
        document.querySelectorAll('.reserve-btn').forEach(button => {
            button.addEventListener('click', function () {
                const eventId = this.getAttribute('data-event-id');
                document.getElementById('event-id').value = eventId;
                document.getElementById('reservation-form-container').style.display = 'block';
            });
        });
    </script>
</body>
</html>

