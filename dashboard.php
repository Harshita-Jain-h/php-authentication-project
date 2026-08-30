<?php

session_start();

// If the user is not logged in, send them to login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">

        <h2>Welcome! 🎉</h2>

        <div class="dashboard-info">

            <p>
                Hello,
                <strong>
                    <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
                </strong>
            </p>

            <p>
                Email:
                <strong>
                    <?php echo htmlspecialchars($_SESSION["user_email"]); ?>
                </strong>
            </p>

        </div>

        <a href="logout.php" class="logout-button">
            Logout
        </a>

    </div>


</body>

</html>
