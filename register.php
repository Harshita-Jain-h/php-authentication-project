<?php

require_once "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {

        $message = "Please fill in all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";

    } elseif ($password !== $confirm_password) {

        $message = "Passwords do not match.";

    } elseif (strlen($password) < 6) {

        $message = "Password must be at least 6 characters.";

    } else {

        // Check whether email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {

            $message = "An account with this email already exists.";

        } else {

            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
            );

            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {

                $message = "Registration successful! You can now login.";

            } else {

                $message = "Something went wrong. Please try again.";

            }

            $stmt->close();
        }

        $check->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <h2>Create Account</h2>

        <?php if (!empty($message)): ?>
            <p class="message">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <form method="POST" action="register.php" id="registerForm">

            <div class="form-group">
                <label for="name">Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter your name"
                    required
                >
            </div>

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

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="confirm_password"
                        name="confirm_password"
                        placeholder="Confirm your password"
                        required
                    >

                    <button
                        type="button"
                        class="toggle-password"
                        data-target="confirm_password"
                    >
                        Show
                    </button>

                </div>
            </div>

            <button type="submit">Register</button>

        </form>

        <p class="link">
            Already have an account?
            <a href="login.php">Login</a>
        </p>

    </div>

    <script src="script.js"></script>

</body>

</html>
