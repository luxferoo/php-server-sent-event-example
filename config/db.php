<?php

$db_dsn = isset($_ENV['DB_DSN']) ? $_ENV['DB_DSN'] : "mysql:host=localhost;dbname=chatdb;";
$db_user = isset($_ENV['DB_USER']) ? $_ENV['DB_USER'] : "root";
$db_password = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : null;