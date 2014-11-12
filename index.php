<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <?php
        session_start();

        define("DB_SERVER", "localhost");
        define("DB_USER", "root");
        define("DB_PASSWORD", "");
        define("DB_NAME", "login");
        $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_SERVER . ';charset=utf8', DB_USER, DB_PASSWORD);



        if (!isset($_SESSION["inloggad"])) {
            echo "<h1>Logga in</h1>";
            echo "<form method='POST'>";
            echo "<p>Username</p>";
            echo "<input type='text' name='username'>";
            echo "<p>Password</p>";
            echo "<input type='password' name='password'>";
            echo "<input type='submit' value='logga in'>";
            echo "</form>";

            echo "<h1>Registrera</h1>";
            echo "<form method='POST'>";
            echo "<p>Username</p>";
            echo "<input type='text' name='username_reg'>";
            echo "<p>Password</p>";
            echo "<input type='password' name='password_reg'>";
            echo "<input type='submit' value='registrera'>";
            echo "</form>";


            if (isset($_POST["username_reg"]) and isset($_POST["password_reg"])) {
                $tmp_usernamereg = filter_input(INPUT_POST, 'username_reg', FILTER_SANITIZE_SPECIAL_CHARS);
                $tmp_passwordreg = filter_input(INPUT_POST, 'password_reg', FILTER_SANITIZE_SPECIAL_CHARS);
                $sql = 'INSERT INTO `users`(`username`, `password`) VALUES ("'. $tmp_usernamereg .'","' . $tmp_passwordreg . '")';
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                header("Location:?");
                echo "Registrering klar";
            }
            if (isset($_POST["username"]) and isset($_POST["password"])) {
                $tmp_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                $tmp_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
                $sql = "SELECT * FROM users WHERE username='" . $tmp_username . "' AND password='" . $tmp_password . "'";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $users = $stmt->fetchAll();

                if (!empty($users)) {
                    $_SESSION["inloggad"] = array();
                    $_SESSION["inloggad"][0] = $_POST["username"];
                    header("Location:?");
                }
            }
        } else {
            echo "inloggad som " . $_SESSION["inloggad"][0];

            echo "<form method='POST'>";
            echo "<input type='hidden' name='loggaut'>";
            echo "<input type='submit' value='logga ut'>";
            echo "</form>";
        }
        if (isset($_POST["loggaut"])) {
            session_destroy();
            header("Location:?");
        }
        ?>




    </body>
</html>
