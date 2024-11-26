<?php


include '../config.php';

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_styles.css">
    <link rel="stylesheet" href="css/style_modif.css">
    <!-- Custom admin CSS file link -->
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
        /* Ensure the body takes up full height and has no margins */
        body, html {
            height: 110%;
            margin: 0;
        }

        /* Flexbox centering for the chart container */
        #chartContainer {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60%; /* Ensure it takes full height of the screen */
            margin-top: 60px;
        }

        /* Smaller chart size */
        #loginChart {
            width: 300px;  /* Adjust the width as needed */
            height: 300px;  /* Adjust the height as needed */
        }
    </style>
</head>
<body>
<?php include 'admin_header.php'; ?>

    <!-- Container for the chart -->
    <div id="chartContainer">
        <canvas id="loginChart"></canvas>
    </div>

    <script>
        // Fetch login data from the server
        fetch('../models/get_login_data.php')
            .then(response => response.json())
            .then(data => {
                const hours = [];
                const loginCounts = [];

                data.forEach(item => {
                    hours.push(`${item.hour}:00`);
                    loginCounts.push(item.count);
                });

                const ctx = document.getElementById('loginChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: hours,
                        datasets: [{
                            label: 'Logins per Hour',
                            data: loginCounts,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: {
                                    display: true,
                                    text: 'Hours of the Day'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Logins'
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching login data:', error));
    </script>
</body>
</html>
