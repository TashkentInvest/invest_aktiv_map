<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get User Info</title>
</head>
<body>
    <h1>User Information</h1>
    <form method="post">
        <button type="submit" name="getInfo">Get My Info</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['getInfo'])) {
        function getUserIP() {
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                return $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                return $_SERVER['HTTP_X_FORWARDED_FOR'];
            } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
                return $_SERVER['REMOTE_ADDR'];
            } else {
                return 'IP address not found';
            }
        }

        echo '<h2>Your IP Address:</h2>';
        echo '<p>' . htmlspecialchars(getUserIP()) . '</p>';
    }
    ?>
</body>
</html>
    