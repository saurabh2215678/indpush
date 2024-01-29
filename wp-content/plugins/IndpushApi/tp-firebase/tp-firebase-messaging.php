<?php
/*
Plugin Name: Tp Firebase Messaging
Description: Firebase messaging integration.
Version: 1.0
Author: Technical Pariwar
*/


global $userId;
global $PluginId;
// global variables start



// global variables end

function initDeviceTokenApi() {
    register_rest_route('tp-firebase', '/api', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'deviceTokenApiFunction',
    ));
    register_rest_route('tp-firebase', '/saveNotification', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'SaveNotificationAPI',
    ));
    register_rest_route('tp-firebase', '/updateSentCountApi', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'updateSentCountNotificationApi',
    ));
    register_rest_route('tp-firebase', '/updateFailedCountApi', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'updateFailedCountNotificationApi',
    ));
    register_rest_route('tp-firebase', '/updateDeliveryCountApi', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'updateDeliveryCountNotificationApi',
    ));
    register_rest_route('tp-firebase', '/updateClickCountApi', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'updateClickCountNotificationApi',
    ));
    register_rest_route('tp-firebase', '/getReport', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'getReport',
    ));
    register_rest_route('tp-firebase', '/importDeviceTokens', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'import_devicetokens',
    ));
    register_rest_route('tp-firebase', '/save-auto-delete-data', array(
        'methods' => array('GET', 'POST'),
        'callback' => 'save_auto_delete_data',
    ));
}

function getDeviceTokens() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'devicetokens';

    // Use the global $wpdb object to query the database
    $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    // Check if there are results and return them as an array
    if ($results) {
        return $results;
    } else {
        // No data found, return an empty array or false, depending on your preference
        return array(); // or return false;
    }
}

function updateConfigJsFile($configData){
    if(isLocalHost()){
        $APIURI = getProjectName().'/wp-json/tp-firebase/updateDeliveryCountApi';
        $ClickCountURI = getProjectName().'/wp-json/tp-firebase/updateClickCountApi';
    } else{
        $APIURI = '/wp-json/tp-firebase/updateDeliveryCountApi';
        $ClickCountURI = '/wp-json/tp-firebase/updateClickCountApi';
    }
    $destination_path = ABSPATH . 'firebase-messaging-sw.js';
    $configStrpData = stripslashes($configData['config']);
    $jsCode = "
    importScripts('https://www.gstatic.com/firebasejs/10.3.1/firebase-app-compat.js');
    importScripts('https://www.gstatic.com/firebasejs/10.3.1/firebase-messaging-compat.js');
    
    ". $configStrpData ."
    
    const saveDiliveryApiUri = '". $APIURI ."';
    const saveClickCountApiUri = '". $ClickCountURI ."';

    self.addEventListener('install', (event) => {
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
    });

    
    self.addEventListener('push', (event) => {
        event.waitUntil(
            self.registration.getNotifications().then((notifications) => {
                    for (let i = 0; i < notifications.length - 1; i++) {
                        notifications[i].close();
                    }

                    const data = event.data.json();
                    console.log('evntpp>>', data);
                    const lastNotification = notifications[notifications.length - 1];
                    const options = {
                        body: data.notification.body,
                        icon: data.notification.icon,
                        image: data.notification.image,
                        data: data.data
                    };
                    if(data.data.actions){
                        options.actions = JSON.parse(data.data.actions);
                    }
                    updateDeliveryCountFunction(data);
                    self.registration.showNotification(data.notification.title, options)
            })
        );
    
    });

    function updateDeliveryCountFunction(messageData){  
        fetch(saveDiliveryApiUri, {
            method: 'POST',
            body: new URLSearchParams({id: messageData.data.notificationId}),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        })
        .then((response) => response.json())
        .then((data) => {
            console.log('updated>>', data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }

    function updateClickCountFunction(notificationId){  
        fetch(saveClickCountApiUri, {
            method: 'POST',
            body: new URLSearchParams({id: notificationId}),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
        })
        .then((response) => response.json())
        .then((data) => {
            console.log('updatedd click count>>', data);
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
  
    self.addEventListener('notificationclick', function (event) {
        const clickedNotification = event.notification;
        console.log('clickedNotification', clickedNotification);
        const actions = clickedNotification.data.actions;
        const action = event.action;
        if(actions){
            if(JSON.parse(actions).length > 0){
                const actionsArray = JSON.parse(actions);
                const clickedAction = actionsArray.find(a => a.action === action);
                if (clickedAction) {
                    const url = clickedAction.url;
                    event.waitUntil(
                        clients.openWindow(url)
                    );
                }else{
                    clients.openWindow(clickedNotification.data.url);
                }
            }
        }else{
            clients.openWindow(clickedNotification.data.url);
        }
        clients.openWindow(clickedNotification.data.url);
        updateClickCountFunction(clickedNotification.data.notificationId);

        
        event.notification.close();
    
    });
    
    ";
    
    file_put_contents($destination_path, $jsCode);
    if (file_exists($destination_path)) {
        return true;  // File was successfully created and updated
    } else {
        return false; // There was an issue with file creation or update
    }
}

function SaveNotificationAPI($request) {
    if ($request->get_method() === 'GET') {
        $data = array('message'=>'method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();

        if (
            isset($params['title']) && 
            isset($params['description']) && 
            isset($params['icon']) && 
            isset($params['image']) && 
            isset($params['link'])) 
        {
            $response_data = saveNotification($params);
            $response = new WP_REST_Response($response_data, 200);
        }else{
            $response_data = array('message'=>'title, description, image and link fields are required');
            $response = new WP_REST_Response($response_data, 400);
        }

        
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function updateSentCountNotificationApi($request) {
    if ($request->get_method() === 'GET') {
        $data = array('message'=>'method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();

        if (isset($params['id']) && isset($params['count'])){
            $response_data = updateSentCount($params);
            $response = new WP_REST_Response($response_data, 200);
        }else{
            $response_data = array('message'=>'id and count of notification is required');
            $response = new WP_REST_Response($response_data, 400);
        }

        
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function updateFailedCountNotificationApi($request) {
    if ($request->get_method() === 'GET') {
        $data = array('message'=>'method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();

        if (isset($params['id']) && isset($params['count'])){
            $response_data = updateFailedCount($params);
            $response = new WP_REST_Response($response_data, 200);
        }else{
            $response_data = array('message'=>'id and count of notification is required');
            $response = new WP_REST_Response($response_data, 400);
        }

        
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function updateDeliveryCountNotificationApi($request) {
    if ($request->get_method() === 'GET') {
        $data = array('message'=>'method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();

        if (isset($params['id'])){
            $response_data = updateDeliveryCount($params);
            $response = new WP_REST_Response($response_data, 200);
        }else{
            $response_data = array('message'=>'id of notification is required');
            $response = new WP_REST_Response($response_data, 400);
        }

        
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function updateClickCountNotificationApi($request) {
    if ($request->get_method() === 'GET') {
        $data = array('message'=>'method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();

        if (isset($params['id'])){
            $response_data = updateClickCount($params);
            $response = new WP_REST_Response($response_data, 200);
        }else{
            $response_data = array('message'=>'id of notification is required');
            $response = new WP_REST_Response($response_data, 400);
        }

        
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function saveNotification($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_notifications';
    $title = sanitize_text_field($params['title']);
    $description = sanitize_text_field($params['description']);
    $image = sanitize_text_field($params['image']);
    $link = sanitize_text_field($params['link']);

    $wpdb->insert(
        $table_name,
        array(
            'title' => $title,
            'description' => $description,
            'image' => $image,
            'link' => $link,
            'clickCount' => 0,
            'deliveryCount' => 0,
            'sentCount' => 0,
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql')
        )
    );
    $inserted_item_id = $wpdb->insert_id;
    if ($inserted_item_id) {
        $inserted_item = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $inserted_item_id", ARRAY_A);
        return $inserted_item;
    } else {
        return false;
    }
}

function updateSentCount($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_notifications';
    $deviceTokenLength = count(getDeviceTokens());

    $id = sanitize_text_field($params['id']);
    $count = sanitize_text_field($params['count']);

    $notification = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id)
    );
    if ($notification) {
        $wpdb->update(
            $table_name,
            array('sentCount' => $count),
            array('id' => $id),
            array('%d'),
            array('%d')
        );
        $wpdb->update(
            $table_name,
            array('subsCount' => $deviceTokenLength),
            array('id' => $id),
            array('%d'),
            array('%d')
        );

        $allNotifications = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
        return $allNotifications;
    } else {
        return array('message' => 'Notification not found');
    }
}

function updateFailedCount($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_notifications';
    $id = sanitize_text_field($params['id']);
    $count = sanitize_text_field($params['count']);

    $notification = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id)
    );
    if ($notification) {
        $wpdb->update(
            $table_name,
            array('failedCount' => $count),
            array('id' => $id),
            array('%d'),
            array('%d')
        );

        $allNotifications = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
        return $allNotifications;
    } else {
        return array('message' => 'Notification not found');
    }
}

function updateDeliveryCount($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_notifications';
    $id = sanitize_text_field($params['id']);

    $notification = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id)
    );
    if ($notification) {
        $newDelivery = $notification->deliveryCount + 1;
        $wpdb->update(
            $table_name,
            array('deliveryCount' => $newDelivery),
            array('id' => $id),
            array('%d'),
            array('%d')
        );

        $allNotifications = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
        return $allNotifications;
    } else {
        return array('message' => 'Notification not found');
    }
}

function updateClickCount($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_notifications';
    $id = sanitize_text_field($params['id']);

    $notification = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id)
    );
    if ($notification) {
        $newClickCount = $notification->clickCount + 1;
        $wpdb->update(
            $table_name,
            array('clickCount' => $newClickCount),
            array('id' => $id),
            array('%d'),
            array('%d')
        );

        $allNotifications = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
        return $allNotifications;
    } else {
        return array('message' => 'Notification not found');
    }
}

function save_auto_delete_settings($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_settings';
    $existing_data = $wpdb->get_row("SELECT * FROM $table_name", ARRAY_A);

    if ($existing_data) {
        $where = array('id' => $existing_data['id']);

        $table_columns = $wpdb->get_col("DESC $table_name", 0);

        if (!in_array('delete_date', $table_columns)) {
            $wpdb->query("ALTER TABLE $table_name ADD COLUMN `delete_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
        }

        if (!in_array('auto_delete', $table_columns)) {
            $wpdb->query("ALTER TABLE $table_name ADD COLUMN `auto_delete` BOOLEAN DEFAULT FALSE");
        }

        $deleteDate = sanitize_text_field($params['delete-date']);
        $autoDelete = sanitize_text_field($params['auto-delete']);

        $wpdb->update(
            $table_name,
            array(
                'delete_date' => $deleteDate,
                'auto_delete' => $autoDelete,
            ),
            $where
        );

        return array('message' => 'Settings updated successfully');
    }else{
        return array('message'=>'firstly save configs');
    }

}

function deviceTokenApiFunction($request) {
    if ($request->get_method() === 'GET') {
        $data = getDeviceTokens();
        $response = new WP_REST_Response($data, 200);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();
        if (isset($params['device_token']) && !isset($params['id'])) {
            $response_data = saveDeviceTokenWithoutId($params);
            $response = new WP_REST_Response($response_data, 200);
        } elseif(isset($params['device_token']) && isset($params['id'])){
            $response_data = saveDeviceToken($params);
            $response = new WP_REST_Response($response_data, 200);
        } else {
            $response_data = array('message' => 'device_token and id is required.');
            $response = new WP_REST_Response($response_data, 400);
        }
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}
function getReport($request){
    if ($request->get_method() === 'GET') {
        $data = array('message'=>'method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();

        if (isset($params['datetime'])){
            $response_data = getNotificationsByDateTime($params);
            $response = new WP_REST_Response($response_data, 200);
        }else{
            $response_data = array('message'=>'datetime is required');
            $response = new WP_REST_Response($response_data, 400);
        }

        
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function saveDeviceToken($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'devicetokens';
    $id = sanitize_text_field($params['id']);
    $device_token = sanitize_text_field($params['device_token']);

    $existing_row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %s", $id));

    if ($existing_row) {
        $wpdb->update(
            $table_name,
            array('device_token' => $device_token, 'updated_at' => current_time('mysql')),
            array('id' => $id) // WHERE clause
        );
    } else {
        $wpdb->insert(
            $table_name,
            array(
                'device_token' => $device_token,
                'created_at' => current_time('mysql'),
                'updated_at' => current_time('mysql')
            )
        );
    }
    export_devicetokens_to_file(null);
    $result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %s", $id), ARRAY_A);
    return $result;
}
function getNotificationsByDateTime($params) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_notifications';
    $dateTime = sanitize_text_field($params['datetime']);

    $currentDateTime = current_time('mysql');
    
    $countSql = $wpdb->prepare(
        "SELECT
            SUM(clickCount) as totalClickcount,
            SUM(deliveryCount) as totalDeliveryCount,
            SUM(sentCount) as totalSentCount
        FROM $table_name
        WHERE updated_at >= %s",
        $dateTime,
        $currentDateTime
    );

      // Query to retrieve the list of notifications
    $notificationsSql = $wpdb->prepare(
        "SELECT *
        FROM $table_name
        WHERE updated_at >= %s",
        $dateTime,
        $currentDateTime
    );
    $countResult = $wpdb->get_row($countSql, ARRAY_A);
    $notificationsResult = $wpdb->get_results($notificationsSql, ARRAY_A);

    $results = array(
        'totalClickcount' => $countResult['totalClickcount'],
        'totalDeliveryCount' => $countResult['totalDeliveryCount'],
        'totalSentCount' => $countResult['totalSentCount'],
        'notifications' => $notificationsResult
    );
    // $results = array('params' => $dateTime);

    return $results;
}

function saveDeviceTokenWithoutId($params){
    global $wpdb;
    $table_name = $wpdb->prefix . 'devicetokens';
    $device_token = sanitize_text_field($params['device_token']);
    $existing_row = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE device_token = %s", $device_token));
    if($existing_row){
        return $existing_row;
    }
    $wpdb->insert(
        $table_name,
        array(
            'device_token' => $device_token,
            'created_at' => current_time('mysql'),
            'updated_at' => current_time('mysql')
        )
    );
    
    $result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE device_token = %s", $device_token), ARRAY_A);
    return $result;
}

function create_devicetokens_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'devicetokens';
    $charset_collate = $wpdb->get_charset_collate();
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            device_token text NOT NULL,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}

function create_notifications_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_notifications';
    $charset_collate = $wpdb->get_charset_collate();
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            title text NOT NULL,
            description text NOT NULL,
            icon text NOT NULL,
            image text NOT NULL,
            link text NOT NULL,
            clickCount int,
            deliveryCount int,
            sentCount int,
            failedCount int,
            subsCount int,
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }else{
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN `failedCount` int");
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN `subsCount` int");
    }
}

function create_settings_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_settings';
    $charset_collate = $wpdb->get_charset_collate();
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            config text,
            icon text,
            serverkey text,
            vapid text,
            popuptitle text,
            popupimage text,           
            popup_ui BOOLEAN DEFAULT TRUE,
            yes_btn_txt text DEFAULT 'Yes',
            no_btn_txt text DEFAULT 'No',
            yes_btn_color text DEFAULT '#00bc27',
            no_btn_color text DEFAULT '#e93b3b',
            txt_color text DEFAULT '#ffffff',
            created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }else{
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN `popup_ui` BOOLEAN DEFAULT TRUE");
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN `yes_btn_txt` text DEFAULT 'Yes'");
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN `no_btn_txt` text DEFAULT 'No'");
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN `yes_btn_color` text DEFAULT '#00bc27'");
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN `no_btn_color` text DEFAULT '#e93b3b'");
        $wpdb->query("ALTER TABLE $table_name ADD COLUMN `txt_color` text DEFAULT '#ffffff'");
    }
}

function add_plugin_pages() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_settings';
    
    $settingsValue = false;
    $settings = $wpdb->get_row("SELECT config, serverkey, vapid FROM $table_name");

    if ($settings) {
        if (!empty($settings->config) && !empty($settings->serverkey) && !empty($settings->vapid)) {
            $settingsValue = true;
        }
    }

    if ($settingsValue) {
        add_menu_page(
            'Tp Notification',
            'Tp Notification',
            'manage_options',
            'tp-notification',
            'tp_notification_callback',
            'dashicons-megaphone'
        );

        
        add_submenu_page(
            'tp-notification',
            'Send Push',
            'Send Push',
            'manage_options',
            'tp-notification',
            'tp_notification_callback'
        );
    
        add_submenu_page(
            'tp-notification',
            'Push Stats',
            'Push Stats',
            'manage_options',
            'notification-list',
            'notification_list_callback'
        );
        
        add_submenu_page(
            'tp-notification',
            'Overview',
            'Overview',
            'manage_options',
            'reports',
            'reports_callback'
        );
    
        add_submenu_page(
            'tp-notification',
            'Settings',
            'Settings',
            'manage_options',
            'settings',
            'settings_callback'
        );

        add_action('add_meta_boxes', 'custom_publish_sidebar_checkbox');

    }else{
        add_menu_page(
            'Tp Notification',
            'Tp Notification',
            'manage_options',
            'tp-notification',
            'settings_callback',
            'dashicons-megaphone'
        );
    }


}

function notification_list_callback() {
    $plugin_dir = plugin_dir_path(__FILE__);
    include $plugin_dir . 'notificationList.php';
}

function settings_callback() {
    $plugin_dir = plugin_dir_path(__FILE__);
    include $plugin_dir . 'settings.php';
}
function tp_notification_callback(){
    $plugin_dir = plugin_dir_path(__FILE__);
    include $plugin_dir . 'post-notifications.php';
}
function reports_callback(){
    $plugin_dir = plugin_dir_path(__FILE__);
    include $plugin_dir . 'reports.php';
}

function my_plugin_deactivate() {
        global $userId;
        global $PluginId;
        $currentDomainName = $_SERVER['HTTP_HOST']; // Get current domain name
        $extra_data = '{domain=' . urlencode($currentDomainName) .'}'; // Encode domain parameter
        $status = 'deactivated';
    
        // API endpoint URL
        $apiUrl = 'https://indpush.com/wp-json/api/save-plugin-status';
    
        // Data to send in the POST request
        $data = array(
            'status' => $status,
            'extra_data' => $extra_data,
            'userId' => $userId,
            'pluginId' => $PluginId
        );
    
        // Headers for the request
        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded',
        );
    
        // Send POST request to the API endpoint
        $response = wp_remote_post($apiUrl, array(
            'method' => 'POST',
            'headers' => $headers,
            'body' => $data
        ));
    
        // Check if request was successful
        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            // Handle error here
        } else {
            $response_body = wp_remote_retrieve_body($response);
            // Process response body here
        }
    
    
}
function my_plugin_uninstall() {
    $destination_path = ABSPATH . 'firebase-messaging-sw.js';

    // i want to clear localstorage
    if (file_exists($destination_path)) {
        if (unlink($destination_path)) {
            // File deleted successfully
        } else {
            // Error deleting the file
        }
    }

    global $userId;
        global $PluginId;
        $currentDomainName = $_SERVER['HTTP_HOST']; // Get current domain name
        $extra_data = '{domain=' . urlencode($currentDomainName) .'}'; // Encode domain parameter
        $status = 'uninstalled';
    
        // API endpoint URL
        $apiUrl = 'https://indpush.com/wp-json/api/save-plugin-status';
    
        // Data to send in the POST request
        $data = array(
            'status' => $status,
            'extra_data' => $extra_data,
            'userId' => $userId,
            'pluginId' => $PluginId
        );
    
        // Headers for the request
        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded',
        );
    
        // Send POST request to the API endpoint
        $response = wp_remote_post($apiUrl, array(
            'method' => 'POST',
            'headers' => $headers,
            'body' => $data
        ));
    
        // Check if request was successful
        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            // Handle error here
        } else {
            $response_body = wp_remote_retrieve_body($response);
            // Process response body here
        }
    
    
}

function check_and_update_serviceworker(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_settings';
    $existing_data = $wpdb->get_row("SELECT * FROM $table_name", ARRAY_A);
    if ($existing_data) {
        $configValue = stripslashes($existing_data['config']);
        $serverkeyValue = $existing_data['serverkey'];
        $vapidValue = $existing_data['vapid'];
        $iconValue = $existing_data['icon'];
        $popuptitleValue = $existing_data['popuptitle'];
        $popupimageValue = $existing_data['popupimage'];

        $data = array(
            'config' => $configValue,
            'icon' => $iconValue,
            'serverkey' => $serverkeyValue,
            'vapid' => $vapidValue,
            'popuptitle' => $popuptitleValue,
            'popupimage' => $popupimageValue,
        );

        updateConfigJsFile($existing_data);

    }
}

function export_devicetokens_to_file($noReturn) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'devicetokens';
    $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);

    if (!empty($results)) {
        $json_data = json_encode($results, JSON_PRETTY_PRINT);
        $file_path = plugin_dir_path(__FILE__) . 'device_tokens_export.json';

        if (file_put_contents($file_path, $json_data) !== false) {
            if(!isset($noReturn)){
                // echo 'Device tokens have been exported to a file. <a href="' . plugins_url('device_tokens_export.json', __FILE__) . '">Download</a>';
            }
        } else {
            if(!isset($noReturn)){
            echo 'Error: Unable to save the file.';
            }
        }
    } else {
        if(!isset($noReturn)){
        echo 'No device tokens found in the database.';
        }
    }
}

function import_devicetokens($request){
    if ($request->get_method() === 'GET') {
        $data = array('message'=>'method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $file_name = $file['name'];

            $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
            if ($file_extension === 'json') {
                $file_content = file_get_contents($file['tmp_name']);
                $deviceTokens = json_decode($file_content, true);

                if (is_array($deviceTokens)) {
                    $validTokens = [];
                    foreach ($deviceTokens as $token) {
                        if (isset($token['device_token'], $token['created_at'], $token['updated_at'])) {
                            // Add the valid token to the array for further processing
                            $validTokens[] = $token;
                        }
                    }

                    if (!empty($validTokens)) {
                        saveValidTokens($validTokens);
                        $response_data = array('message' => 'File uploaded and processed successfully');
                    } else {
                        $response_data = array('message' => 'File does not contain valid device tokens');
                    }

                } else {
                    $response_data = array('message' => 'Invalid JSON format');
                }

            } else {
                $response_data = array('message' => 'Invalid file format. Only JSON files are allowed.');
            }

        }else{
            $response_data = array('message'=>'file not found');
        }
        

        $response = new WP_REST_Response($response_data, 200);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}
function save_auto_delete_data($request){
    if ($request->get_method() === 'GET') {
        $data = array('message'=>'method not allowed');
        $response = new WP_REST_Response($data, 400);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    } elseif ($request->get_method() === 'POST') {
        $params = $request->get_params();

        if (isset($params['delete-date']) && isset($params['auto-delete'])){
            $response_data = save_auto_delete_settings($params);
            $response = new WP_REST_Response($response_data, 200);
        }else{
            $response_data = array('message'=>'delete-date and auto-delete is required');
            $response = new WP_REST_Response($response_data, 400);
        }

        
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }
}

function saveValidTokens($validTokens){
    global $wpdb; // Access the WordPress database

    $table_name = $wpdb->prefix . 'devicetokens';
    foreach ($validTokens as $token) {
        $data = array(
            'device_token' => $token['device_token'],
            'created_at' => $token['created_at'],
            'updated_at' => $token['updated_at']
        );
        $format = array('%s', '%s', '%s');
        $existing_token = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE device_token = %s", $token['device_token']));
        if ($existing_token) {
            // If the token exists, update the record
            $wpdb->update($table_name, $data, array('device_token' => $token['device_token']), $format);
        } else {
            // If the token doesn't exist, insert a new record
            $wpdb->insert($table_name, $data, $format);
        }
    }
    export_devicetokens_to_file('noreturn');
}

function custom_publish_sidebar_checkbox() {
    add_meta_box(
        'custom_publish_sidebar_checkbox',
        'Notify',
        'render_custom_checkbox',
        'post',
        'side',
        'core'
    );
}
function render_custom_checkbox($post) {
    ?>
    <label><input type="checkbox" name="notifier" id="notifier_checkbox"/> Send Notification After Post Publish</label>
    <input type="text" style="width: 100%; margin-bottom: 6px; margin-top: 7px;" name="notifier_title" id="notifier_title" placeholder="notifier title" />
    <textarea name="notifier_desc" style="width: 100%;" id="notifier_desc" placeholder="notifier description"></textarea>
    <?php
}

function custom_api_endpoint() {
    if (isset($_POST['action']) && $_POST['action'] === 'getpostdetailbypostid') {
        $post_id = intval($_POST['post_id']); // Sanitize and convert to an integer

        // Get the post object
        $post = get_post($post_id);

        if ($post) {
            // Get the post title
            $post_title = $post->post_title;

            // Get the post description (post content)
            $post_description = $post->post_content;

            // Get the featured image URL
            $featured_image_url = get_the_post_thumbnail_url($post_id);

            // Customize the response as needed
            $response = array(
                'post_id' => $post_id,
                'post_title' => $post_title,
                'post_description' => $post_description,
                'featured_image' => $featured_image_url,
                // Add more data as needed
            );

            echo json_encode($response);

            // Make sure to exit to prevent WordPress from outputting additional content
            exit();
        } else {
            // Post not found, return an error response
            $error_response = array(
                'error' => 'Post not found',
            );

            echo json_encode($error_response);

            // Make sure to exit to prevent WordPress from outputting additional content
            exit();
        }
    }
}




$plugin_dir = plugin_dir_path(__FILE__);
include $plugin_dir . '/utils/common-functions.php';

function checkAndDeleteNotifications() {
    global $wpdb;

    $settings_table = $wpdb->prefix . 'tp_settings';
    $notifications_table = $wpdb->prefix . 'tp_notifications';

    // Check if the required fields exist in the settings_table
    $required_fields = array('delete_date', 'auto_delete');
    $existing_fields = $wpdb->get_col("DESC $settings_table", 0);


    if (count(array_diff($required_fields, $existing_fields)) !== 0) {
        // Required fields are missing, do not proceed
        return;
    }
    
    // Select the first row from settings_table
    $settings_row = $wpdb->get_row("SELECT * FROM $settings_table LIMIT 1");

    if ($settings_row && $settings_row->auto_delete == 1 && $settings_row->delete_date) {
        // Auto-delete is enabled and delete-date has a timestamp value

        // Get the current date in MySQL format
        $current_date = current_time('mysql');

        // print_r($current_date);
        // print_r('|');
        // print_r($settings_row->delete_date);
        // die();

        // Delete notifications that are not between today and delete-date

        $wpdb->query($wpdb->prepare(
            "DELETE FROM $notifications_table WHERE created_at < %s",
            $settings_row->delete_date,
            $current_date
        ));
    }
}


function getNotificationss() {
    global $wpdb;

    $settings_table = $wpdb->prefix . 'tp_settings';
    $notifications_table = $wpdb->prefix . 'tp_notifications';

    $settings_row = $wpdb->get_row("SELECT * FROM $settings_table LIMIT 1");
    $current_date = current_time('mysql');

    echo 'Current Date: ' . $current_date . '<br>';
    echo 'Delete Date from Settings: ' . $settings_row->delete_date . '<br>';

    $notifications = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $notifications_table WHERE created_at < %s",
        $settings_row->delete_date,
        $current_date
    ));

    echo 'Notifications: <pre>';
    print_r($notifications);
    echo '</pre>';
    die();
}
function my_plugin_activate(){
    global $userId;
    global $PluginId;
    $currentDomainName = $_SERVER['HTTP_HOST']; // Get current domain name
    $extra_data = '{"domain"="' . urlencode($currentDomainName) .'"}'; // Encode domain parameter
    $status = 'activated';

    // API endpoint URL
    $apiUrl = 'https://indpush.com/wp-json/api/save-plugin-status';

    // Data to send in the POST request
    $data = array(
        'status' => $status,
        'extra_data' => $extra_data,
        'userId' => $userId,
        'pluginId' => $PluginId
    );

    // Headers for the request
    $headers = array(
        'Content-Type' => 'application/x-www-form-urlencoded',
    );

    // Send POST request to the API endpoint
    $response = wp_remote_post($apiUrl, array(
        'method' => 'POST',
        'headers' => $headers,
        'body' => $data
    ));

    // Check if request was successful
    if (is_wp_error($response)) {
        $error_message = $response->get_error_message();
        // Handle error here
    } else {
        $response_body = wp_remote_retrieve_body($response);
        // Process response body here
    }
}



register_activation_hook(__FILE__, 'create_devicetokens_table');
register_activation_hook(__FILE__, 'create_notifications_table');
register_activation_hook(__FILE__, 'create_settings_table');
register_activation_hook(__FILE__, 'check_and_update_serviceworker');
register_activation_hook(__FILE__, 'my_plugin_activate');
register_deactivation_hook(__FILE__, 'my_plugin_deactivate');
register_uninstall_hook(__FILE__, 'my_plugin_uninstall');
add_action('rest_api_init', 'initDeviceTokenApi');
add_action('admin_menu', 'add_plugin_pages');
add_action('init', 'custom_api_endpoint');
add_action('init', 'checkAndDeleteNotifications');

?>
