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

        foreach ($required_params as $param) {
            //also check that $params[$param] value is not blank or empty string.
            if (!isset($params[$param]) || empty($params[$param])) {
                $response_data = array('message' => $param . ' is required');
                $response = new WP_REST_Response($response_data, 400);
                $response->set_headers(['Content-Type' => 'application/json']);
                return $response;
            }
        }

        $response_data = createUser($params);
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

        foreach ($required_params as $param) {
            if (!isset($params[$param])) {
                $response_data = array('message' => $param . ' is required');
                $response = new WP_REST_Response($response_data, 400);
                $response->set_headers(['Content-Type' => 'application/json']);
                return $response;
            }
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

function createUser($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'indpush_user';

    $user_data = array(
        'name' => sanitize_text_field($params['name']),
        'email' => sanitize_text_field($params['email']),
        'profile_picture' => isset($params['profile-picture']) ? sanitize_text_field($params['profile-picture']) : '',
        'subscription_id' => '',
        'password' => sanitize_text_field($params['password']),
        'domains' => sanitize_text_field($params['domains']),
        'user_domain' => sanitize_text_field($params['your_domain']),
        'status' => 'active',
        'created_at' => current_time('mysql', true),
        'updated_at' => current_time('mysql', true)
    );

    $wpdb->insert($table_name, $user_data);
    
    $user_id = $wpdb->insert_id;

    // Retrieve the saved user
    $saved_user = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $user_id), ARRAY_A);

    return array('message' => 'user created', 'user' => $saved_user);
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
        return array('message' => 'User found', 'user' => $user);
    } else {
        return array('message' => 'User not found');
    }
}




function indpushApi_activate() {
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
        password varchar(255),
        status varchar(20),
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}


function indpushApi_deactivate() {

}

add_action('rest_api_init', 'indpushApi');
register_activation_hook(__FILE__, 'indpushApi_activate');
register_deactivation_hook(__FILE__, 'indpushApi_deactivate');
?>