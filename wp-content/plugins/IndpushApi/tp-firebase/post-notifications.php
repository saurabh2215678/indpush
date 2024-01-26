<style>
.notification_wrapper { display: flex; }
.notification_wrapper * {margin: 0; padding: 0; box-sizing: border-box;}
.notification_list { width: 55%; }
.notification_sender { width: 45%; }
ul.post_list { padding: 1rem 0; }
.post_list li span { font-size: 1.4em; font-weight: 600; display: grid; place-items: center; background-color: #fff; border-radius: 5px 0 0 5px; padding: 0.5em 0.5em 0.5em 0.75em; }
.middle_item { display: flex; align-items: center; padding: 0.5em 0; background-color: #fff;     flex-grow: 1;}
.middle_item h3 { overflow: hidden; display: -webkit-box; -webkit-line-clamp: 1; line-clamp: 1; -webkit-box-orient: vertical; }
.select_btn { border: none; background-color: #409fec; font-size: 1.2em; font-weight: 600; color: #fff; padding: 0 1.3em; border-radius: 0 5px 5px 0; line-height: 2.5; cursor: pointer;     width: 7em;}
.notification_sender form { padding: 1.3em; margin: 1.2em 1.5em; background-color: #fff; border-radius: 8px; box-shadow: -2px 4px 8px #00000026; }
.post_list li { display: flex; box-shadow: -2px 4px 8px #00000026; border-radius: 4px; margin-bottom: 1em; position: relative; overflow: hidden;}
.form_group { display: flex; flex-direction: column; margin-bottom: 1em;}
.form_group label { font-weight: 600; margin-bottom: 0.2em; }
.form_group input, .form_group textarea { padding: 0.1em 0.7em; border: 1px solid #c5c5c5; min-height: 2.4em; }
.image_sec img { height: 6em; margin-left: 2em; }
.img_input_box { display: flex; flex-direction: column; flex-grow: 1; }
.image_sec { flex-direction: row; }
.form_group button { margin-bottom: 0; border: none; padding: 1em; font-size: 1.2em; font-weight: 600; text-transform: uppercase; border-radius: 5px; background-color: #409fec; color: #fff; cursor: pointer; }
.post_list li.active span, .post_list li.active .middle_item { background-color: honeydew; }
.post_list li.active .select_btn { background-color: #129912; }
.sending .notification_wrapper button { background-color: #c5c5c5; pointer-events: none; }
.sending .notification_wrapper li.active button { background-color: #9d9d9d; }
span.progress_count { background-color: transparent!important; width: fit-content; padding: 0.3em 1em!important; font-size: 1.15em!important; height: 100%; position: relative; z-index: 2; }
.progress_bar { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: #ffffffc4; z-index: 4; border-radius: 4px; overflow: hidden; backdrop-filter: blur(1px); transform: translateY(100%); transition: transform 0.5s; will-change: transform; }
.progress_box { position: absolute; top: 0; left: 0; height: 100%; width: var(--progress, 0%); background-image: linear-gradient(45deg,rgba(255,255,255,.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,.15) 50%,rgba(255,255,255,.15) 75%,transparent 75%,transparent); background-color: #5eb7ff8f; background-size: 1em 1em; }
.sending .notification_wrapper .progress_bar{transform: translateY(0%);}

.pagination { display: inline-flex; box-shadow: -2px 2px 7px #0000003b; border-radius: 5px; } .pagination>* { padding: 0.6em 1em; background-color: #fff; text-decoration: none; font-weight: 500; } .pagination>*:first-child { border-radius: 5px 0 0 5px; } .pagination>*:last-child { border-radius: 0 5px 5px 0; } .pagination .current { background-color: #409fec; color: #fff; } .pagination>a:hover { background-color: #eaf5ff; }
#add_action_btn { margin-bottom: 2em; background-color: #8f8f8f; border: none; color: #fff; padding: 0.6em 1em; font-weight: 600; border-radius: 5px; margin-top: 1em; cursor: pointer; }
 #add_action_btn { margin-bottom: 2em; background-color: #8f8f8f; border: none; color: #fff; padding: 0.6em 1em; font-weight: 600; border-radius: 5px; margin-top: 1em; cursor: pointer; } .action_group { display: flex; margin: 0.5em 0; } input.action-url { flex-grow: 1; margin: 0 0.3em; } .action_delete_btn { background-color: red; border: none; width: 35px; border-radius: 5px; color: #fff; cursor: pointer; } 
</style>
<?php

function get_post_list_in_plugin_with_url_pagination() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_settings';
    $settings_data = $wpdb->get_row("SELECT * FROM $table_name", ARRAY_A);

    if ($settings_data) {
        $configValue = stripslashes($settings_data['config']);
        $serverkeyValue = $settings_data['serverkey'];
        $vapidValue = $settings_data['vapid'];
        $iconValue = $settings_data['icon'];
        $popuptitleValue = $settings_data['popuptitle'];
        $popupimageValue = $settings_data['popupimage'];
    }else{
        $configValue = '';
        $serverkeyValue = '';
        $vapidValue = '';
        $iconValue = '';
        $popuptitleValue = '';
        $popupimageValue = '';
    }

    $count = 0;
    $posts_per_page = 10;
    $paged = isset($_GET['pageno']) ? max(1, intval($_GET['pageno'])) : 1; // Get the page number from the URL parameter

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
    );

    $query = new WP_Query($args);
    if ($query->have_posts()) {
?>
<div class="notification_wrapper">
    <div class="notification_list">
        <ul class="post_list">
        <?php while ($query->have_posts()) {  
            $count++;
            $query->the_post(); 
            $post_number = $query->current_post + 1;
            $post_count = (($paged - 1) * $posts_per_page ) + $post_number;
        ?>
                <li data-id="<?php echo $count;?>" class="<?php echo $count == 1 ? 'active' : ''; ?>">
                    <script type="application/json">
                    <?php
                        // Get post data and encode it as JSON
                        $post_data = array(
                            'post_count' => $post_count,
                            'post_title' => get_the_title(),
                            'post_url' => get_permalink(), // Get the post URL
                            'post_description' => get_the_excerpt(), // Get the post excerpt/content
                            'featured_image' => get_the_post_thumbnail_url(get_the_ID(), 'full'), // 'full' can be replaced with the image size you prefer
                            // Add more data as needed
                        );
                        echo json_encode($post_data);
                        ?>
                    </script>
                    <span><?php echo $post_count; ?></span>
                    <div class="middle_item">
                        <h3><?php echo get_the_title(); ?></h3>
                    </div>
                    <button class="select_btn"><?php echo $count == 1 ? 'selected' : 'select'; ?></button>
                    <div class="progress_bar">
                        <span class="progress_count">0%</span>
                        <div class="progress_box"></div>
                    </div>
                </li>
        <?php } ?>
        </ul>
        <?php
            echo "<div class='pagination'>";
            echo paginate_links(array(
                'base' => add_query_arg('pageno', '%#%'), // Add the page parameter to pagination links
                'format' => '?pageno=%#%', // Format the URL parameter
                'current' => max(1, $paged),
                'total' => $query->max_num_pages,
            ));
            echo "</div>";
    
            wp_reset_postdata();
        } else {
            echo "No posts found.";
        }?>
    
    </div>
    <div class="notification_sender">
        <form class="sendNotification_form">
            <div class="form_group">
                <label>Title</label>
                <input type="text" name="title" placeholder="title" required>
            </div>
            <div class="form_group">
                <label>Descrption</label>
                <textarea name="description"  placeholder="description" required></textarea>
            </div>
            <div class="form_group image_sec">
                <div class="img_input_box">
                    <label>Image</label>
                    <input type="text" name="image" required>
                </div>
                <img class="notification_img" src="<?php echo plugins_url('images/default_notification_image.jpeg', __FILE__);?>" />
            </div>
            <div class="form_group">
                <label>Link</label>
                <input type="text" name="link" placeholder="Link" required>
            </div>
            <div class="click_actions_box">
                <div class="click_actions_list"></div>
                <button id="add_action_btn" type="button">Add Click Actions</button>
            </div>
            <div class="form_group">
               <button type="submit">Send</button>
            </div>

        </form>
    </div>
</div>
<script>
document.getElementById('add_action_btn').addEventListener('click', function() {
    const actionItemHtml = `
        <input type="text" class="action-label" placeholder="Action Label" required>
        <input type="text" class="action-url" placeholder="Action Url" required>
        <button class="action_delete_btn" onClick="deleteMe(event)" type="button"><span class="dashicons dashicons-trash"></span></button>
    `;

    const div = document.createElement('div');
    div.className = 'action_group';
    div.innerHTML = actionItemHtml;

    document.querySelector('.click_actions_list').appendChild(div);
});

</script>
<script>
function getActions() {
    const actions = [];
    const actionItems = document.querySelectorAll('.click_actions_list .action_group');

    actionItems.forEach(function(actionItem) {
        const labelValue = actionItem.querySelector('.action-label').value;
        const urlValue = actionItem.querySelector('.action-url').value;
        const actionName = labelValue.replaceAll(' ', '-');

        actions.push({
            action: actionName,
            title: labelValue,
            url: urlValue
        });
    });

    return actions;
}
function deleteMe(e) {
    console.log(e);
    const target = e.target;
    const actionGroup = findClosestActionGroup(target);
    if (actionGroup) {
        actionGroup.parentNode.removeChild(actionGroup);
    }
}

function findClosestActionGroup(element) {
    while (element && !element.classList.contains('action_group')) {
        element = element.parentElement;
    }
    return element;
}


var selectedPostElement = document.querySelector('.post_list > li.active');
var scriptElement = selectedPostElement.querySelector('script');
var selectedPostString = scriptElement.textContent;
const selectedPost = JSON.parse(selectedPostString.trim());
let notificationObj = null;
populatePostForm(selectedPost);
function populatePostForm(postData) {
    var notificationSender = document.querySelector('.notification_sender');
    var titleInput = notificationSender.querySelector('[name=title]');
    var descriptionInput = notificationSender.querySelector('[name=description]');
    var imageInput = notificationSender.querySelector('[name=image]');
    var notificationImg = notificationSender.querySelector('.notification_img');
    var linkInput = notificationSender.querySelector('[name=link]');
    const postImgUrl = postData.featured_image || '<?php echo plugins_url('images/default_notification_image.jpeg', __FILE__);?>';
    titleInput.value = postData.post_title;
    descriptionInput.value = postData.post_description;
    imageInput.value = postImgUrl;
    notificationImg.setAttribute('src', postImgUrl);
    linkInput.value = postData.post_url;
}


var selectButtons = document.querySelectorAll('.select_btn');
selectButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var closestDataIdElement = this.closest('[data-id]');
        closestDataIdElement.classList.add('active');
        var siblingsWithDataId = closestDataIdElement.parentElement.querySelectorAll('[data-id]');
        siblingsWithDataId.forEach(function(sibling) {
            if (sibling !== closestDataIdElement) {
                sibling.classList.remove('active');
            }
        });
        var selectedPostItem = closestDataIdElement.querySelector('script').textContent;
        const selectedPostItemObj = JSON.parse(selectedPostItem.trim());
        populatePostForm(selectedPostItemObj);
    });
});

let mainDeviceTokens = [
            {"device_token":"f_g_3LjWzRQLvSGrEe_RJe:APA91bFpOtaYZcPS4jasFHogA82EGNOtNFnvTn6TwiWOaBnaS3YbPFUKjR7ZI3466XUx1c7ZNFMMgf8Y7v2nJ7xG-_jzjHpxwhqEppnXosurGYhgI9E6EaNFY_QkZtNNfCJ4f4G4w-uY","created_at":"2023-09-17 07:09:14"},
            {"device_token":"dPxKK2ZrN8hKOQQWoA4jRx:APA91bG2lZgb-6j40k7aYzc4erl9rBmt7DNM8HA_hyr8QDt5ut9I4qJlvilKwcQKSi5FMzRKAfWZ2kJamc7lp4wQxfzqW-aJThED_cwK5LHEgZmw83RxxEW7XUeGMgnAfyBH7FhHj7dq","created_at":"2023-09-17 07:09:14"},
];

<?php if(isLocalHost()){ ?>
    const URI = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/api";
<?php } else{ ?>
    const URI = "/wp-json/tp-firebase/api";
<?php } ?>
function getDeviceTokens() {
    fetch(URI)
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            mainDeviceTokens = data;
            
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}
getDeviceTokens();
let sending = false;

window.onbeforeunload = function() {
    if (sending) {
        return "Are you sure you want to leave?";
    }
};

let totalsent = 0;
let totalfail = 0;

const sendNotificationForm = document.querySelector('.sendNotification_form');
sendNotificationForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    sending = true;
    const titleInputValue = document.querySelector('[name=title]').value;
    const urlInputValue = document.querySelector('[name=link]').value;
    const imageInputValue = document.querySelector('[name=image]').value;
    const descriptionInputValue = document.querySelector('[name=description]').value;
    const iconValue = '<?php echo  $iconValue; ?>';




    const fcmEndpoint = 'https://fcm.googleapis.com/fcm/send';
    const serverKey = '<?php echo $serverkeyValue; ?>';
    const message = {
        notification: {
            title: titleInputValue,
            body: descriptionInputValue,
            image: imageInputValue,
            icon: iconValue,
            link: urlInputValue,
            click_action: urlInputValue,
            data: {
                url: urlInputValue,
            },
            
        },
        data: {
            url: urlInputValue,
            click_action: urlInputValue,
            link: urlInputValue,
            fcm_options: {
                link: urlInputValue
            },
            actions: getActions(),
        },
        fcm_options: {
            link: urlInputValue
        },
    };
    const savedNotification = await saveNotificationToDatabase(message);
    message.notification.notificationId = savedNotification.id;
    message.data.notificationId = savedNotification.id;
    const headers = {
        'Content-Type': 'application/json',
        Authorization: `key=${serverKey}`,
    };
    const requestBody = {
        registration_ids: mainDeviceTokens,
        notification: message.notification,
        data: message.data,
        fcm_options: {
            link: urlInputValue
        },
        link: urlInputValue,
        click_action: urlInputValue,
    };

    const chunkSize = 150;
    const totalBatches = Math.ceil(mainDeviceTokens.length / chunkSize);
    let batchesSent = 0;
    let progress = 0;

    async function sendBatches() {
        for (let i = 0; i < mainDeviceTokens.length; i += chunkSize) {
            const tokensChunk = mainDeviceTokens.slice(i, i + chunkSize);
            const tokens = [];
            tokensChunk.forEach(item =>{
                tokens.push(item.device_token);
            });
            
            const requestBody = {
                registration_ids: tokens,
                notification: message.notification,
                data: message.data,
            };
            
            await sendBatchNotification({ fcmEndpoint, headers, requestBody });
            batchesSent++;
            progress = (batchesSent / totalBatches) * 100;
            updateProgress(progress);

            updateSentCount(totalsent);
            updateFailedCount(totalfail);
            if (batchesSent === totalBatches) {
                totalsent = 0;
                totalfail = 0;
                sending = false;
                alert('Notification sent successfully.');
            }
        }
    }
    sendBatches();
});

function updateProgress(progressValue) {
    if (progressValue > 0 && progressValue < 100) {
        document.body.classList.add('sending');
    } else {
        document.body.classList.remove('sending');
    }

    if(progressValue == 100){
        progressValue = 0;
    }

    const activePost = document.querySelector('.post_list > .active');
    if (activePost) {
        const progressCount = activePost.querySelector('.progress_count');
        if (progressCount) {
            progressCount.textContent = `${Math.floor(progressValue)}%`;
        }
        activePost.style.setProperty('--progress', `${progressValue}%`);
    }
}


async function sendBatchNotification({ fcmEndpoint, headers, requestBody }) {
    try {
        const response = await fetch(fcmEndpoint, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(requestBody),
        });
        const responseData = await response.json();

        totalsent = totalsent + responseData.success;
        totalfail = totalfail + responseData.failure;

        console.log('sentMessage',responseData);
        if (response.ok) {
            console.log('Successfully sent notification');
        } else {
            console.error('Failed to send notification:', response.statusText);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}
<?php if(isLocalHost()){ ?>
    const saveNotificationApi = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/saveNotification";
<?php } else{ ?>
    const saveNotificationApi = "/wp-json/tp-firebase/saveNotification";
<?php } ?>
async function saveNotificationToDatabase(messageData) {
    const messageParams = {
        title: messageData.notification.title,
        description: messageData.notification.body,
        icon: messageData.notification.icon,
        image: messageData.notification.image,
        link: messageData.notification.link,
    }

    try {
        const response = await fetch(saveNotificationApi, {
            method: "POST",
            body: new URLSearchParams(messageParams),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        notificationObj = data;
        return data;
    } catch (error) {
        console.error("Error:", error);
        throw error; // You can choose to handle or rethrow the error as needed.
    }
}

<?php if(isLocalHost()){ ?>
    const updateSentCountApi = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/updateSentCountApi";
    const updateFailedCountApi = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/updateFailedCountApi";
<?php } else{ ?>
    const updateSentCountApi = "/wp-json/tp-firebase/updateSentCountApi";
    const updateFailedCountApi = "/wp-json/tp-firebase/updateFailedCountApi";
<?php } ?>
function updateSentCount(count){
        fetch(updateSentCountApi, {
            method: "POST",
            body: new URLSearchParams({id: notificationObj.id, count}),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
        })
        .then((response) => response.json())
        .then((data) => {
            console.log('updated>>', data);
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

function updateFailedCount(count){
        fetch(updateFailedCountApi, {
            method: "POST",
            body: new URLSearchParams({id: notificationObj.id, count}),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
        })
        .then((response) => response.json())
        .then((data) => {
            console.log('updated failed count>>', data);
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

</script>
<?php
}

get_post_list_in_plugin_with_url_pagination();
?>
