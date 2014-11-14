<?php

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
?>