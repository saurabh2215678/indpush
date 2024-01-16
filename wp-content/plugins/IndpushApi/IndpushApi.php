<?php
/*
Plugin Name: apiIndpush
Description: This is a description of apiIndpush.
Version: 1.0
Author: Your Name
*/
function indpushApi() {
    register_rest_route('api', '/signup', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'signupFunction',
    ));
    register_rest_route('api', '/login', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'loginFunction',
    ));
    register_rest_route('api', '/update-profile', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'updateProfileApi',
    ));
    register_rest_route('api', '/firebase-data', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'firebasedata',
    ));
    register_rest_route('api', '/firebase-data-upload', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'firebasedataupload',
    ));
    register_rest_route('api', '/verify-otp', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'verifyotp',
    ));
    register_rest_route('api', '/resend-otp', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'resendOtp',
    ));
    register_rest_route('api', '/reset-password-mail', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'resetPasswordMailAPI',
    ));
    register_rest_route('api', '/validate-reset-password-link', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'validateResetPasswordLink',
    ));
    register_rest_route('api', '/reset-password', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'resetPasswordApi',
    ));

}
function signupFunction($request){
    if ($request->get_method() === 'GET') {
        $data = array('message' => 'Method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();

        $required_params = array('name', 'email', 'password', 'domains', 'your_domain');

        $missing_params = array_filter($required_params, function($param) use ($params) {
            return !isset($params[$param]) || empty($params[$param]);
        });

        if (!empty($missing_params)) {
            $data = array('message' => 'Required parameters missing or empty', 'missing_params' => $missing_params);
            $response = new WP_REST_Response($data, 400);
            $response->set_headers(['Content-Type' => 'application/json']);
            return $response;
        }

        $response_data = createUser($params);
        if($response_data['error']){
            $response_data =  $response_data['message'];
        }
        $response = new WP_REST_Response($response_data, 200);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function loginFunction($request){
    if ($request->get_method() === 'GET') {
        $data = array('message' => 'Method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();

        $required_params = array('email', 'password');

        $missing_params = array_filter($required_params, function($param) use ($params) {
            return !isset($params[$param]) || empty($params[$param]);
        });

        if (!empty($missing_params)) {
            $data = array('message' => 'Required parameters missing or empty', 'missing_params' => $missing_params);
            $response = new WP_REST_Response($data, 400);
            $response->set_headers(['Content-Type' => 'application/json']);
            return $response;
        }

        $response_data = findUser($params);
        if($response_data['message'] == 'User not found'){
            $response = new WP_REST_Response($response_data, 400);
        }else{
            $response = new WP_REST_Response($response_data, 200);
        }
        
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function verifyotp($request){
    if ($request->get_method() === 'GET') {
        $data = array('message' => 'Method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();

        $required_params = array('email', 'otp');

        $missing_params = array_filter($required_params, function($param) use ($params) {
            return !isset($params[$param]) || empty($params[$param]);
        });

        if (!empty($missing_params)) {
            $data = array('message' => 'Required parameters missing or empty', 'missing_params' => $missing_params);
            $response = new WP_REST_Response($data, 400);
            $response->set_headers(['Content-Type' => 'application/json']);
            return $response;
        }

        $response_data = verifyOtpForUser($params);
        if($response_data['message'] == 'User not found' || $response_data['message'] == 'Invalid OTP'){
            $response = new WP_REST_Response($response_data, 400);
        }else{
            $response = new WP_REST_Response($response_data, 200);
        }
        
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function resendOtp($request){
    if ($request->get_method() === 'GET') {
        $data = array('message' => 'Method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();

        $required_params = array('email');

        $missing_params = array_filter($required_params, function($param) use ($params) {
            return !isset($params[$param]) || empty($params[$param]);
        });

        if (!empty($missing_params)) {
            $data = array('message' => 'Required parameters missing or empty', 'missing_params' => $missing_params);
            $response = new WP_REST_Response($data, 400);
            $response->set_headers(['Content-Type' => 'application/json']);
            return $response;
        }

        $response_data = resendOtpToUser($params);
        if($response_data['message'] == 'User not found'){
            $response = new WP_REST_Response($response_data, 400);
        }else{
            $response = new WP_REST_Response($response_data, 200);
        }
        
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function resendOtpToUser($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_user';
    $useremail = sanitize_text_field($params['email']);

    $user_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE email = %s", $useremail));
    $user_id = $user_data->id;
    $mailResp = sendOtpForUser($user_id, $params['email']);
    return $mailResp;
}

function createUser($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_user';

    $existing_user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE email = %s", $params['email']), ARRAY_A);
    if ($existing_user) {
        return array('message' => 'User already exists with this email. Please try logging in.', 'error'=>1);
    }

    $user_data = array(
        'name' => sanitize_text_field($params['name']),
        'email' => sanitize_text_field($params['email']),
        'profile_picture' => isset($params['profile-picture']) ? sanitize_text_field($params['profile-picture']) : '',
        'subscription_id' => generateSubscriptionId($params['email']),
        'password' => sanitize_text_field($params['password']),
        'domains' => sanitize_text_field($params['domains']),
        'user_domain' => sanitize_text_field($params['your_domain']),
        'varified' => false,
        'user_type' => 'user',
        'status' => 'active',
        'created_at' => current_time('mysql', true),
        'updated_at' => current_time('mysql', true)
    );

    $wpdb->insert($table_name, $user_data);
    $user_id = $wpdb->insert_id;
    $saved_user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $user_id), ARRAY_A);
    $mailResp = sendOtpForUser($user_id, $params['email']);

    unset($saved_user['password']);
    unset($saved_user['otp']);

    return array('message' => 'user created', 'user' => $saved_user, 'mailsent' => $mailResp);
}

function sendOtpForUser($user_id){
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_user';
    $otp = random_int(1000, 9999);
    $wpdb->update(
        $table_name,
        array('otp' => $otp),
        array('id' => $user_id)
    );
    $user_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $user_id));

    if ($user_data) {
        $email = $user_data->email;
        $subject = 'Your OTP for Verification';
        $message = 'Your OTP is: ' . $otp;

        $mailed = wp_mail($email, $subject, $message);

        if ($mailed) {
            return array('message' => 'Mail sent successfully');
        } else {
            return array('message' => 'Failed to send mail');
        }
    } else {
        return array('message' => 'User not found');
    }
}

function verifyOtpForUser($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_user';
    $otp = sanitize_text_field($params['otp']);
    $user_email = sanitize_text_field($params['email']);

    // Find the user by $user_id
    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE email = %s", $user_email), ARRAY_A);

    $user_id = $user['id'];

    // Check if user exists
    if (!$user) {
        return array('message' => 'User not found');
    }

    // Check if the provided OTP matches the stored OTP
    if ($user['otp'] == $otp) {
        // Update the 'varified' field to 1
        $wpdb->update($table_name, array('varified' => 1), array('id' => $user_id));

        return array('message' => 'OTP verified successfully');
    } else {
        return array('message' => 'Invalid OTP');
    }
}

function generateSubscriptionId($email) {
    return md5($email . uniqid());
}

function findUser($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_user';

    $email = sanitize_text_field($params['email']);
    $password = sanitize_text_field($params['password']);

    // Prepare and execute the query
    $query = $wpdb->prepare(
        "SELECT * FROM $table_name WHERE email = %s AND password = %s",
        $email,
        $password
    );

    $user = $wpdb->get_row($query);
 
    if ($user) {
        unset($user->otp);
        return array('message' => 'User found', 'user' =>  $user);
    } else {
        return array('message' => 'User not found');
    }
}

function sendMail($params) {
    $sendToMailId = $params['email'];
    $subject = isset($params['subject']) ? $params['subject'] : 'Your Subject Here';
    $message = isset($params['message']) ? $params['message'] : 'Your Message Here';
    $headers = array('Content-Type: text/html; charset=UTF-8');

    $is_mail_sent = wp_mail($sendToMailId, $subject, $message, $headers);

    if ($is_mail_sent) {
        return array('message' => 'Mail sent successfully');
    } else {
        return array('message' => 'Error sending mail');
    }
}


function firebasedata($request){
    if ($request->get_method() === 'GET') {
        $data = array('message' => 'Method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();

        $required_params = array('userId');

        $missing_params = array_filter($required_params, function($param) use ($params) {
            return !isset($params[$param]) || empty($params[$param]);
        });

        if (!empty($missing_params)) {
            $data = array('message' => 'Required parameters missing or empty', 'missing_params' => $missing_params);
            $response = new WP_REST_Response($data, 400);
            $response->set_headers(['Content-Type' => 'application/json']);
            return $response;
        }

        $response_data = findFirebaseData($params);
        $response = new WP_REST_Response($response_data, 200);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function firebasedataupload($request){
    if ($request->get_method() === 'GET') {
        $data = array('message' => 'Method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();
    
        $required_params = array('config', 'serverkey', 'vapid', 'userId');
    
        $missing_params = array_filter($required_params, function($param) use ($params) {
            return !isset($params[$param]) || empty($params[$param]);
        });
    
        if (!empty($missing_params)) {
            $data = array('message' => 'Required parameters missing or empty', 'missing_params' => $missing_params);
            $response = new WP_REST_Response($data, 400);
            $response->set_headers(['Content-Type' => 'application/json']);
            return $response;
        }

        $response_data = saveFirebaseData($params);
        $response = new WP_REST_Response($response_data, 200);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function resetPasswordMailAPI($request){
    if ($request->get_method() === 'GET') {
        $data = array('message' => 'Method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();
    
        $required_params = array('email');
    
        $missing_params = array_filter($required_params, function($param) use ($params) {
            return !isset($params[$param]) || empty($params[$param]);
        });
    
        if (!empty($missing_params)) {
            $data = array('message' => 'Required parameters missing or empty', 'missing_params' => $missing_params);
            $response = new WP_REST_Response($data, 400);
            $response->set_headers(['Content-Type' => 'application/json']);
            return $response;
        }

        $response_data = resetPasswordMail($params);
        $response = new WP_REST_Response($response_data, 200);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function resetPasswordMail($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_user';
    $user_email = sanitize_text_field($params['email']);
    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE email = %s", $user_email), ARRAY_A);
    if (!$user) {
        return array('message' => 'User not found');
    }

    $token = bin2hex(random_bytes(32));
    $timestamp = current_time('timestamp');
    $data_to_encrypt = $user_email . '|' . $token . '|' . $timestamp;

    $encrypted_data = base64_encode(encrypt_function($data_to_encrypt));
    $reset_link = 'https://indpush.com/reset-password/' . $encrypted_data;


    $subject = 'Reset your password';
    $message = 'Follow this Link to reset your password: ' . $reset_link;

    $mailed = wp_mail($user_email, $subject, $message);

    if ($mailed) {
        return array('message' => 'Password reset link sent successfully');
    } else {
        return array('message' => 'Failed to send Password reset link');
    }
}

function validateResetPasswordLink($request){
    if ($request->get_method() === 'GET') {
        $data = array('message' => 'Method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();
    
        $required_params = array('password-link', 'email');
    
        $missing_params = array_filter($required_params, function($param) use ($params) {
            return !isset($params[$param]) || empty($params[$param]);
        });
    
        if (!empty($missing_params)) {
            $data = array('message' => 'Required parameters missing or empty', 'missing_params' => $missing_params);
            $response = new WP_REST_Response($data, 400);
            $response->set_headers(['Content-Type' => 'application/json']);
            return $response;
        }

        $response_data = validateLink($params);
        $response = new WP_REST_Response($response_data, 200);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function resetPasswordApi($request){
    if ($request->get_method() === 'GET') {
        $data = array('message' => 'Method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();
    
        $required_params = array('password-link', 'email', 'password');
    
        $missing_params = array_filter($required_params, function($param) use ($params) {
            return !isset($params[$param]) || empty($params[$param]);
        });
    
        if (!empty($missing_params)) {
            $data = array('message' => 'Required parameters missing or empty', 'missing_params' => $missing_params);
            $response = new WP_REST_Response($data, 400);
            $response->set_headers(['Content-Type' => 'application/json']);
            return $response;
        }

        $response_data = resetPassword($params);
        $response = new WP_REST_Response($response_data, 200);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function updateProfileApi($request){
    if ($request->get_method() === 'GET') {
        $data = array('message' => 'Method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();
    
        $required_params = array('email', 'password');
    
        $missing_params = array_filter($required_params, function($param) use ($params) {
            return !isset($params[$param]) || empty($params[$param]);
        });
    
        if (!empty($missing_params)) {
            $data = array('message' => 'Required parameters missing or empty', 'missing_params' => $missing_params);
            $response = new WP_REST_Response($data, 400);
            $response->set_headers(['Content-Type' => 'application/json']);
            return $response;
        }

        $response_data = updateProfile($params);
        $response = new WP_REST_Response($response_data, 200);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function validateLink($params) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_user';
    $resetPasswordLink = sanitize_text_field($params['password-link']);
    $resetPasswordEmail = sanitize_text_field($params['email']);

    // Remove the base URL from the link
    $baseURL = 'https://indpush.com/reset-password/';
    $linkWithoutBaseURL = str_replace($baseURL, '', $resetPasswordLink);

    // Decrypt the data from the modified reset password link
    $decrypted_data = decrypt_function(base64_decode($linkWithoutBaseURL));

    // Extract email, token, and timestamp from decrypted data
    list($storedEmail, $token, $timestamp) = explode('|', $decrypted_data);

    // Compare stored email with the provided email
    if ($storedEmail === $resetPasswordEmail) {
        // Check if the timestamp is within a reasonable timeframe (e.g., link valid for 1 hour)
        $currentTimestamp = current_time('timestamp');
        $linkExpirationTime = 3600; // 1 hour in seconds

        if (($currentTimestamp - $timestamp) <= $linkExpirationTime) {
            return array('message' => 'Password reset link is valid');
        } else {
            return array('message' => 'Password reset link has expired');
        }
    } else {
        return array('message' => 'Invalid password reset link');
    }
}

function updateProfile($params) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_user';
    $email = sanitize_text_field($params['email']);
    $password = sanitize_text_field($params['password']);

    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE email = %s", $email));

    if ($user && $password === $user->password) {
        if (isset($_FILES['profile_picture']) && !empty($_FILES['profile_picture']['name'])) {
            $upload_overrides = array('test_form' => false);
            $file = wp_handle_upload($_FILES['profile_picture'], $upload_overrides);

            if (!empty($file['error'])) {
                return array('error' => $file['error']);
            }
            $profile_picture_url = $file['url'];

            $wpdb->update(
                $table_name,
                array(
                    'profile_picture' => $profile_picture_url,
                ),
                array('id' => $user->id)
            );
        }

        $name = isset($params['name']) ? sanitize_text_field($params['name']) : $user->name;
        $user_domain = isset($params['user_domain']) ? sanitize_text_field($params['user_domain']) : $user->user_domain;
        $domains = isset($params['domains']) ? sanitize_text_field($params['domains']) : $user->domains;


        $wpdb->update(
            $table_name,
            array(
                'name' => $name,
                'user_domain' => $user_domain,
                'domains' => $domains,
            ),
            array('id' => $user->id)
        );
        $wpdb->update(
            $table_name,
            array('updated_at' => current_time('mysql')),
            array('id' => $user->id)
        );

        return array('message' => 'Profile updated successfully');
    } else {
        return array('error' => 'Invalid email or password');
    }
}




function resetPassword($params){
    $resetPasswordLink = sanitize_text_field($params['password-link']);
    $resetPasswordEmail = sanitize_text_field($params['email']);
    $newPassword = sanitize_text_field($params['password']);

    // Remove the base URL from the link
    $baseURL = 'https://indpush.com/reset-password/';
    $linkWithoutBaseURL = str_replace($baseURL, '', $resetPasswordLink);

    // Decrypt the data from the modified reset password link
    $decrypted_data = decrypt_function(base64_decode($linkWithoutBaseURL));

    // Extract email, token, and timestamp from decrypted data
    list($storedEmail, $token, $timestamp) = explode('|', $decrypted_data);

    // Compare stored email with the provided email
    if ($storedEmail === $resetPasswordEmail) {
        // Check if the timestamp is within a reasonable timeframe (e.g., link valid for 1 hour)
        $currentTimestamp = current_time('timestamp');
        $linkExpirationTime = 3600; // 1 hour in seconds

        if (($currentTimestamp - $timestamp) <= $linkExpirationTime) {
            return resetPasswordOfUser($resetPasswordEmail, $newPassword);
        } else {
            return array('message' => 'Password reset link has expired');
        }
    } else {
        return array('message' => 'Invalid password reset link');
    }
}

function resetPasswordOfUser($email, $password) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_user';

    // Update the password field for the user with the provided email
    $result = $wpdb->update(
        $table_name,
        array('password' => $password),
        array('email' => $email)
    );

    if ($result !== false) {
        return array('message' => 'Password reset successfully');
    } else {
        return array('message' => 'Failed to reset password');
    }
}

function encrypt_function($data) {
    $encryption_key = 'ganpati';
    $encryption_iv = 'shivji';
    $encrypted_data = openssl_encrypt($data, 'AES-256-CBC', $encryption_key, 0, $encryption_iv);

    return $encrypted_data;
}

function decrypt_function($encrypted_data) {
    $encryption_key = 'ganpati';
    $encryption_iv = 'shivji';
    $decrypted_data = openssl_decrypt($encrypted_data, 'AES-256-CBC', $encryption_key, 0, $encryption_iv);
    return $decrypted_data;
}

function createUserTable(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_user';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        profile_picture varchar(255),
        subscription_id varchar(255),
        user_domain TEXT,
        domains TEXT,
        user_type varchar(255),
        password varchar(255),
        otp mediumint(9),
        varified BOOLEAN,
        status varchar(20),
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function findFirebaseData($params){
    global $wpdb;

    // Set the table name using WordPress database prefix
    $table_name = $wpdb->prefix . 'indpush_firebase';

    // Extract user ID from the input array
    $userId = $params['userId'];

    // Find Firebase data by user ID
    $firebaseData = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE userId = %d", $userId), ARRAY_A);

    if ($firebaseData) {
        // Firebase data found
        return array('message' => 'Firebase data found.', 'data' => $firebaseData);
    } else {
        // Firebase data not found
        return array('message' => 'Firebase data not found for the given user ID.', 'data' => null);
    }
}
function saveFirebaseData($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_firebase';

    // Extract parameters from the input array
    $config = $params['config'];
    $serverkey = $params['serverkey'];
    $vapid = $params['vapid'];
    $userId = $params['userId'];

    // Check if a row with the given user ID already exists
    $existingRow = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE userId = %d", $userId), ARRAY_A);

    // Prepare the data to be inserted or updated
    $data_to_insert = array(
        'config' => $config,
        'serverkey' => $serverkey,
        'vapid' => $vapid,
        'userId' => $userId,
    );

    // Define the data format for insertion
    $data_format = array(
        '%s', // config is a string
        '%s', // serverkey is a string
        '%s', // vapid is a string
        '%d', // userId is an integer
    );

    if ($existingRow) {
        // Row with the same user ID exists, update the row
        $wpdb->update($table_name, $data_to_insert, array('userId' => $userId), $data_format, array('%d'));
    } else {
        // Row with the user ID doesn't exist, insert a new row
        $wpdb->insert($table_name, $data_to_insert, $data_format);
    }

    // Fetch the inserted or updated row
    $insertedRow = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE userId = %d", $userId), ARRAY_A);

    if ($insertedRow) {
        // Data saved successfully
        return array('message' => 'Data saved successfully.', 'data' => $insertedRow);
    } else {
        // Error occurred during data save
        return array('message' => 'Error saving data to the database.', 'data' => null);
    }
}

function createFirebaseTable(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_firebase';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        config TEXT,
        serverkey TEXT,
        vapid TEXT,
        userId mediumint(9),
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function indpushApi_activate() {
    createUserTable();
    createFirebaseTable();
}


function indpushApi_deactivate() {

}

add_action('rest_api_init', 'indpushApi');
register_activation_hook(__FILE__, 'indpushApi_activate');
register_deactivation_hook(__FILE__, 'indpushApi_deactivate');
?>