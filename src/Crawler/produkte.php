<?php

require 'config.php';

$db = mysqli_connect(host, user, pass, dbname);

$query = "SELECT * FROM .......";

echo json_encode(mysqli_fetch_array($query));


