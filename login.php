<?php

session_start();

require_once "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {

        $message = "Please enter your email and password.";

    } else {

        // Find the user by email
        $stmt = $conn->prepare(
            "SELECT id, name, email, password FROM users WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $user["password"])) {

                // Regenerate session ID for security
                session_regenerate_id(true);

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["user_email"] = $user["email"];

                header("Location: dashboard.php");
                exit;

            } else {

                $message = "Invalid email or password.";

            }

        } else {

            $message = "Invalid email or password.";

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">

        <h2>Login</h2>

        <?php if (!empty($message)): ?>

            <p class="message">
                <?php echo htmlspecialchars($message); ?>
            </p>

        <?php endif; ?>

        <form method="POST" action="login.php" id="loginForm">

            <div class="form-group">

                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                >

            </div>

            <div class="form-group">

                <label for="password">Password</label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        data-target="password"
                    >
                        Show
                    </button>

                </div>


            </div>

            <button type="submit">Login</button>

        </form>

        <p class="link">

            Don't have an account?

            <a href="register.php">Register</a>

        </p>

    </div>

    <script src="script.js"></script>

</body>

</html>
