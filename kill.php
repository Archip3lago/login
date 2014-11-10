<?php

session_start();
unset($_SESSION["inloggad"]);
echo "mördad";
echo session_status();
