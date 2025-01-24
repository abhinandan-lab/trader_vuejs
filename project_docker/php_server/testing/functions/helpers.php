<?php


function createMd5OfRandomString($length = 16) {
    // Generate a random string
    $randomString = bin2hex(random_bytes($length / 2));

    // Return the MD5 hash of the random string
    return md5($randomString);
}



?>