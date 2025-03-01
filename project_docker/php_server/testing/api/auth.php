<?php

class Auth
{

    private $conn;
    public function __construct()
    {

        // Include the connection file
        require_once __DIR__ . '/../config/connection.php';
        require_once __DIR__ . '/../functions/Utils.php';
        require_once __DIR__ . '/../functions/helpers.php';

        $this->conn = $conn;
    }

    public function login()
    {
        // Check if required POST fields are present
        if (!isset($_POST['email'], $_POST['password'])) {
            return [
                'status' => 'error',
                'message' => 'Email and password are required.'
            ];
        }

        // Sanitize the input to prevent XSS
        $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8');

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => 'error',
                'message' => 'Invalid email format.'
            ];
        }

        // Fetch user from the database
        $result = RunQuery($this->conn, 'SELECT * FROM user WHERE email = ?', [$email]);

        // Check if user exists
        if (empty($result)) {
            return [
                'status' => 'error',
                'message' => 'User not found.'
            ];
        }

        $userRow = $result[0];

        // Verify the password
        // Assuming passwords are hashed using `password_hash()` when stored in the database
        if (!password_verify($password, $userRow['password'])) {
            return [
                'status' => 'error',
                'message' => 'Incorrect password.'
            ];
        }


        // Return a successful login response
        return [
            'status' => 'success',
            'message' => 'Login successful.',
            'user' => [
                'id' => $userRow['id'],
                'email' => $userRow['email']
            ],
            'token' => $userRow['cookie_token'] // Include token if using session-based or token-based auth
        ];
    }


    public function register()
    {
        // Ensure required POST fields are present
        if (!isset($_POST['username'], $_POST['email'], $_POST['password'])) {
            return [
                'status' => 'error',
                'message' => 'Username, email, and password are required.'
            ];
        }

        // Sanitize input to prevent XSS
        $username = htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
        $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8');

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => 'error',
                'message' => 'Invalid email format.'
            ];
        }

        // Validate password strength
        if (strlen($password) < 4) {
            return [
                'status' => 'error',
                'message' => 'Password must be at least 4 characters long.'
            ];
        }

        // Check if email already exists
        $existingUser = RunQuery($this->conn, 'SELECT * FROM user WHERE email = ?', [$email]);
        if (!empty($existingUser)) {
            return [
                'status' => 'error',
                'message' => 'Email is already registered.'
            ];
        }

        // Handle file upload for profile picture
        $profilePicPath = null;
        if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../uploads/profile_pics/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Create directory if it doesn't exist
            }

            $fileName = uniqid('profile_', true) . '.' . pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
            $targetFilePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetFilePath)) {
                $profilePicPath = 'uploads/profile_pics/' . $fileName; // Relative path for storage
            } else {
                return [
                    'status' => 'error',
                    'message' => 'Failed to upload profile picture.'
                ];
            }
        }

        // Hash the password securely
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        try {


            $token = createMd5OfRandomString();




            RunQuery($this->conn, 'INSERT INTO user (email, password, username, profilePic, cookie_token) VALUES (?, ?, ?, ?, ?)', [
                $email,
                $hashedPassword,
                $username,
                $profilePicPath,
                $token,
            ]);

            return [
                'status' => 'success',
                'message' => 'User registered successfully, please log in.',
                // 'profilePic' => $profilePicPath,
                // 'token' => $token,
            ];
        } catch (PDOException $e) {
            return [
                'status' => 'error',
                'message' => 'Error registering user: ' . $e->getMessage()
            ];
        }
    }



    public function userDetailBySession($routeParams, $body)
    {
        // Validate session input

        $session = $routeParams['session'];

        if (empty($session)) {
            return [
                'status' => 'error',
                'message' => 'Session token is required.'
            ];
        }

        // Sanitize the session token
        $sessionToken = htmlspecialchars(trim($session), ENT_QUOTES, 'UTF-8');

        // Fetch user details from the database using the session token
        $result = RunQuery($this->conn, 'SELECT id, email, username, profilePic, theme FROM user WHERE cookie_token = ?', [$sessionToken]);

        // Check if the user exists
        if (empty($result)) {
            return [
                'status' => 'error',
                'message' => 'Invalid session token or user not found.'
            ];
        }

        $user = $result[0];

        // Return user details
        return [
            'status' => 'success',
            'message' => 'User details retrieved successfully.',
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'username' => $user['username'],
                'profilePic' => $user['profilePic'],
                'theme' => $user['theme'],
            ]
        ];
    }


    // public function updateUser($routeParams, $body) {

    //     // just for security purposes
    //     $session = $routeParams['session'];

    //     if (empty($session)) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Session token is required.'
    //         ];
    //     }
    //     $sessionToken = htmlspecialchars(trim($session), ENT_QUOTES, 'UTF-8'); // Sanitize the session token




    //     // funcion logic
    //     // Fetch user details from the database using the session token
    //     $result = RunQuery($this->conn, 'SELECT id, email, username, profilePic, theme FROM user WHERE cookie_token = ?', [$sessionToken]);

    //     // Check if the user exists
    //     if (empty($result)) {
    //         return [
    //             'status' => 'error',
    //             'message' => 'Invalid session token or user not found.'
    //         ];
    //     }

    //     $user = $result[0];

    //     // Return user details
    //     return [
    //         'status' => 'success',
    //         'message' => 'User details retrieved successfully.',
    //         'user' => [
    //             'id' => $user['id'],
    //             'email' => $user['email'],
    //             'username' => $user['username'],
    //             'profilePic' => $user['profilePic'],
    //             'theme' => $user['theme'],
    //         ]
    //     ];
    // }



    public function updateUser($routeParams)
    {

        // just for security purposes
        $session = $routeParams['session'];

        if (empty($session)) {
            return [
                'status' => 'error',
                'message' => 'Session token is required.'
            ];
        }
        $sessionToken = htmlspecialchars(trim($session), ENT_QUOTES, 'UTF-8'); // Sanitize the session token

        // funcion logic
        // Fetch user details from the database using the session token
        $result = RunQuery($this->conn, 'SELECT * FROM user WHERE cookie_token = ?', [$sessionToken]);

        // Check if the user exists
        if (empty($result)) {
            return [
                'status' => 'error',
                'message' => 'Invalid session token or user not found.'
            ];
        }

        $user = $result[0];


        return [
            'status' => 'error',
            'message' => 'sss',
            'd' => $user,
        ];
    }
}
