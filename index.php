<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <?php
        
        //Starta session
        session_start();
        
        //definera databasuppgifter
        define("DB_SERVER", "localhost");
        define("DB_USER", "root");
        define("DB_PASSWORD", "");
        define("DB_NAME", "login");
        $dbh = new PDO('mysql:dbname=' . DB_NAME . ';host=' . DB_SERVER . ';charset=utf8', DB_USER, DB_PASSWORD);


        //Finns inte sessionen inloggad, körs kod nedan
        if (!isset($_SESSION["inloggad"])) {
            //Skapar ett formulär för att logga in.
            echo "<h1>Logga in</h1>";
            echo "<form method='POST'>";
            echo "<p>Username</p>";
            echo "<input type='text' name='username'>";
            echo "<p>Password</p>";
            echo "<input type='password' name='password'>";
            echo "<input type='submit' value='logga in'>";
            echo "</form>";
            
            //skapar ett formulär för att registrera en ny användare
            echo "<h1>Registrera</h1>";
            echo "<form method='POST'>";
            echo "<p>Username</p>";
            echo "<input type='text' name='username_reg'>";
            echo "<p>Password</p>";
            echo "<input type='password' name='password_reg'>";
            echo "<input type='submit' value='registrera'>";
            echo "</form>";

            //Har man skrivit in data i registreringsformuläret, körs koden nedan
            if (isset($_POST["username_reg"]) and isset($_POST["password_reg"])) {
                //Ser till så att man inte sparar js/css/php/sql kod i databasen och sparar värdena i temporära variabler
                $tmp_usernamereg = filter_input(INPUT_POST, 'username_reg', FILTER_SANITIZE_SPECIAL_CHARS);
                $tmp_passwordreg = filter_input(INPUT_POST, 'password_reg', FILTER_SANITIZE_SPECIAL_CHARS);
                //Skapar sql-fråga och kör den, lägger till användare enligt information från formuläret.
                $sql = 'INSERT INTO `users`(`username`, `password`) VALUES ("'. $tmp_usernamereg .'","' . $tmp_passwordreg . '")';
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                //Skickar tillbaks till index.php så att man inte råkar registrera fler av samma nvändare
                header("Location:?");
                echo "Registrering klar";
            }
            //Har man fyllt i logga in formuläret körs koden nedan
            if (isset($_POST["username"]) and isset($_POST["password"])) {
                //Skapar temporära variabler för användarnamn och lösenord
                $tmp_username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
                $tmp_password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
                //Matcher både användarnamn och lösenord någon del i databasen, skickas värden tillbaks till $users variabeln
                $sql = "SELECT * FROM users WHERE username='" . $tmp_username . "' AND password='" . $tmp_password . "'";
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $users = $stmt->fetchAll();
                //Finns det något i $users skapas sessionen "inloggad"
                if (!empty($users)) {
                    //Skapar sessionen "inloggad"
                    $_SESSION["inloggad"] = array();
                    //Sätter sessionens plats 0 till användarnamnet man loggat in med
                    $_SESSION["inloggad"][0] = $_POST["username"];
                    header("Location:?");
                }
            }
            //Finns sessionen körs koden nedan
        } else {
            //Skriver ut vilken användare som är inloggad
            echo "inloggad som " . $_SESSION["inloggad"][0];

            //Skapar ett knapp för att logga ut.
            echo "<form method='POST'>";
            echo "<input type='hidden' name='loggaut'>";
            echo "<input type='submit' value='logga ut'>";
            echo "</form>"; 
        }
        //Har man tryckt på logga ut knappen, körs koden nedan
        if (isset($_POST["loggaut"])) {
            //Sessionen förstårs
            session_destroy();
            header("Location:?");
        }
        ?>




    </body>
</html>
