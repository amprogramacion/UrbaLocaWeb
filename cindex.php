<?php
$username = 'test';
$password_hash = '$2y$10$gYX3D/TzSabj1b92p7l9Pe/S76I4eYz05YAlyLORuHhQNhWjO.FAi';
$login_token = 'da4b9237bacccdf19c0760cab7aec4a8359010b0';

$user_token = strtoupper(sha1($username.$login_token));
$pwd_token = strtoupper(sha1($password_hash.$login_token));

echo "user token: ".$user_token.'<br>';
echo "pwd token: ".$pwd_token.'<br>';
echo "login token: ".$login_token.'<br>';