<?php

require_once "config.php";

$stmt = mysqli_prepare($link, "SELECT username, password FROM users WHERE username = ?");
$user = "john";
mysqli_stmt_bind_param($stmt, "s", $user);

mysqli_stmt_execute($stmt);

/* bind variables to prepared statement */
mysqli_stmt_bind_result($stmt, $col1, $col2);

/* fetch values */
while (mysqli_stmt_fetch($stmt)) {
    printf("%s %s\n", $col1, $col2);
}
