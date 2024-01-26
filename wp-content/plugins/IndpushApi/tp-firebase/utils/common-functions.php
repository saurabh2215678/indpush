<?php
// common-functions.php
global $wpdb;
$table_name = $wpdb->prefix . 'tp_settings';
$settingsValue = false;
$settings = $wpdb->get_row("SELECT config, serverkey, vapid FROM $table_name");


if ($settings) {
	if (!empty($settings->config) && !empty($settings->serverkey) && !empty($settings->vapid)) {
		$settingsValue = true;
	}
}


function isLocalHost() {
	if ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) {
		return true;
	} else {
		return false;
	}
}

function getProjectName() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $current_url = $protocol . $host . $_SERVER['REQUEST_URI'];
    $parsed_url = parse_url($current_url);

    // Get the path part without the leading and trailing slashes
    $path = trim($parsed_url['path'], '/');

    // Split the path into segments
    $path_parts = explode('/', $path);

    // The project name is the first segment
    $project_name = reset($path_parts);

    return $project_name;
}



function add_custom_script_to_head() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'tp_settings';
	$existing_data = $wpdb->get_row("SELECT * FROM $table_name", ARRAY_A);
	$configValue = stripslashes($existing_data['config']);
	$serverkeyValue = $existing_data['serverkey'];
	$vapidValue = $existing_data['vapid'];
	$iconValue = $existing_data['icon'];
	$popuptitleValue = $existing_data['popuptitle'];
	$popupimageValue = $existing_data['popupimage'];
	?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/10.3.1/firebase-app-compat.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/10.3.1/firebase-messaging-compat.min.js" integrity="sha512-G0FjvLkehmMADmKYeycWJzWPEP431DlO1+L3XBF7PhHpwhZK7DZ3L2qI9XlMof0Tm29fZwHlqEhe0PwLo+2xlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/10.3.1/firebase-messaging-sw.min.js" type="module"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/10.3.1/firebase-firestore-compat.min.js"></script>
	
    <script>
		<?php echo $configValue; ?>
      	const app = firebase.initializeApp(firebaseConfig);
      	const messaging = app.messaging();

	  	const vapidKey = "<?php echo $vapidValue; ?>";

		messaging.onMessage((payload) => {
			console.log("Message received. Data:", payload);
		});
		


	  function listenAndgetToken(){
		
		  console.log("Device token:", 'token');


		messaging.getToken({vapidKey: vapidKey}).then((token) => {
			console.log("Device token:", token);
			document.addEventListener('DOMContentLoaded', function(){
				if(document.querySelector('.token')){
					document.querySelector('.token').innerHTML = token;
				}
			});
			if(document.querySelector('.token')){
				document.querySelector('.token').innerHTML = token;
			}
			saveDeviceToken(token);
		});
	  }

	  function handleNotification(){
		Notification.requestPermission().then((permission) => {
			if (permission === "granted") {
				console.log("Notification permission granted");
				const title = location.hostname;
				const body = document.title;
				const url = location.origin;
				const options = {
						body: body,
						icon: "<?php echo $iconValue; ?>",
						data: {
							url: url,
						},
					};
				const notification = new Notification(title, options);
				listenAndgetToken();	
			}
		});
	  }

	
	var lsNotificationUser = localStorage.getItem('tp-notification-user');

	<?php if(isLocalHost()){ ?>
		const URI = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/api";
	<?php } else{ ?>
		const URI = "/wp-json/tp-firebase/api";
	<?php } ?>
      function saveDeviceToken(token) {
        const deviceToken = token;
		const urlParams = { device_token: deviceToken };
		if(lsNotificationUser){
			var lsNotifyUser = JSON.parse(lsNotificationUser);
			urlParams.id = lsNotifyUser.id;
		}
        fetch(URI, {
            method: "POST",
            body: new URLSearchParams(urlParams),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
				// savetoFirebase(token);
				savetoLocalStorage(data);
            })
            .catch((error) => {
                console.error("Error:", error);
            });
      }

	  function savetoLocalStorage(data){
		localStorage.setItem('tp-notification-user', JSON.stringify(data));
	  }
    </script>
	<?php
}
function add_custom_html_to_body() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'tp_settings';
	$existing_data = $wpdb->get_row("SELECT * FROM $table_name", ARRAY_A);
	$configValue = stripslashes($existing_data['config']);
	$serverkeyValue = $existing_data['serverkey'];
	$vapidValue = $existing_data['vapid'];
	$iconValue = $existing_data['icon'];
	$popuptitleValue = $existing_data['popuptitle'];
	$popupimageValue = $existing_data['popupimage'];
	$popupUIValue = $existing_data['popup_ui'];
	$yesBtnTxt = $existing_data['yes_btn_txt'];
    $noBtnTxt = $existing_data['no_btn_txt'];
    $yesBtnColor = $existing_data['yes_btn_color'];
    $noBtnColor = $existing_data['no_btn_color'];
    $txtColor = $existing_data['txt_color'];
    ?>
    <style>
		#custom-notification-popup { position: fixed; max-width: calc(100% - 2rem); left: 50%;     top: 50%; width: 400px; transform: translateX(-50%) translateY(-50%); background-color: #fff; box-shadow: 0 1px 6px rgba(5,27,44,.06),0 2px 4px rgba(5,27,44,.16)!important; padding: 2rem 1em; border-radius: 8px; z-index: 99999; transition: 0.5s; opacity: 0; pointer-events: none; }
		#custom-notification-popup.active { opacity: 1; pointer-events: all; }
		img.side_img { width: 31px; }
		.notification_top { display: flex; align-items: center; margin-bottom: 1rem; flex-direction: column;}
		.notification_top p {margin-top: 0; margin-bottom: 0; margin-left: 0.5rem; font-size: 20px; line-height: 1.7;}
		.notification_bottom { text-align: right; }
		.notification_bottom .btn, .notification_bottom .btn2 { background-color: #00bc27; box-shadow: 0px 2px 3px #00000024; padding: 0.58rem 4rem; outline: none; border: 0; border-radius: 3PX; color: #fff; cursor: pointer;}
		/* button.btn.btn_blue { background-color: #ba4747; color: #fff; }  */
		.notification_bottom .btn2 {/* background-color: #FFFF; border: 0; padding: 0; margin-right: 29px;*/ }
		.notification_bottom .btn2 { padding-inline: 18px; }
		
	</style>
    <div id="custom-notification-popup">
        <div class="notification_top">
			<img class="side_img" src="<?php echo $popupimageValue; ?>" alt="">
			<p><?php echo $popuptitleValue; ?></p>
		</div>
		<div class="notification_bottom">
			<?php if($noBtnTxt) {?>
			<button class="btn_blue btn2" id="notification-deny-btn" style="background-color: <?php echo $noBtnColor; ?>; color: <?php echo $txtColor; ?>;"><?php echo $noBtnTxt; ?></button>
			<?php } ?>
			<button class="btn" id="notification-allow-btn" style="background-color: <?php echo $yesBtnColor; ?>; color: <?php echo $txtColor; ?>;"><?php echo $yesBtnTxt; ?></button>
		</div>
    </div>
	<script>
		var notificationAllowBtn = document.getElementById('notification-allow-btn');
		var notificationDenyBtn = document.getElementById('notification-deny-btn');
		var notificationPopup = document.getElementById('custom-notification-popup');

		var locatstoragePermission = localStorage.getItem('notification-permission');

		notificationAllowBtn.addEventListener('click', function() {
			handleNotification();
			notificationPopup.classList.remove('active');
		});
		notificationDenyBtn.addEventListener('click', function() {
			localStorage.setItem('notification-permission', 'no');
			notificationPopup.classList.remove('active');
		});

		function checkNotificationPermission() {
			if (Notification.permission === "granted") {
				console.log("Notifications are allowed.");
				listenAndgetToken()
			} else if (Notification.permission === "denied") {
				console.log("Notifications are blocked.");
			} else if(locatstoragePermission != 'no') {
				<?php if($popupUIValue) { ?>
					notificationPopup.classList.add('active');
				<?php } else{?>
					handleNotification();
				<?php } ?>
			}
		}

		// Call the function to check notification permission
		checkNotificationPermission();

	</script>
    <!-- End of your HTML code -->
    <?php
}
function add_notifier() {
    add_meta_box('notifier', 'Notify', 'render_notifier', 'post', 'side', 'high');
}
function render_notifier() {											
    echo '<label><input type="checkbox" name="notifier" id="notifier_checkbox" checked/> Send Notification After Post Publish</label>';
    echo '<input type="text" style="width: 100%; margin-bottom: 6px; margin-top: 7px;" name="notifier_title" id="notifier_title" placeholder="notifier title" />';
    echo '<textarea name="notifier_desc" style="width: 100%;" id="notifier_desc" placeholder="notifier description"></textarea>';
}
function custom_admin_script() {
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

	?>
	<link rel="stylesheet" href="<?php echo plugins_url('css/tp_notify_style.css', __FILE__);?>">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/10.3.1/firebase-app-compat.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/10.3.1/firebase-messaging-compat.min.js" integrity="sha512-G0FjvLkehmMADmKYeycWJzWPEP431DlO1+L3XBF7PhHpwhZK7DZ3L2qI9XlMof0Tm29fZwHlqEhe0PwLo+2xlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/10.3.1/firebase-messaging-sw.min.js" type="module"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/10.3.1/firebase-firestore-compat.min.js"></script>
	<style>
		.progress-container { position: fixed; bottom: 20px; left: 50%; width: 400px; max-width: calc(100% - 60px); background-color: #fff; padding: 16px 24px; box-shadow: 0 0 14px #0000005e; transform: translateX(-50%) translateY(34vh); transition: 0.5s; }
		.progress-container .progress-bar { width: 100%; height: 10px; background-color: #d3d3d3; border-radius: 5rem; position: relative; overflow: hidden; } 
		.progress-container .progress-bar:before { content: ""; position: absolute; left: 0; top: 0; background: #007cba; height: 100%; width: var(--progress); }
		.progress-container.active{transform: translateX(-50%) translateY(0vh);}
		.progress-container:before { content: attr(progress); }
	</style>
	<script type="text/javascript">
let notificationOObj = null;
<?php if(isLocalHost()){ ?>
	const APIURI = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/api";
<?php } else{ ?>
	const APIURI = "/wp-json/tp-firebase/api";
<?php } ?>


let totalsentt = 0;
let totalfaill = 0;
		// Create the progress container and progress bar elements
		const progressContainer = document.createElement('div');
		progressContainer.classList.add('progress-container');

		const progressBar = document.createElement('div');
		progressBar.classList.add('progress-bar');
		progressBar.id = 'progressBar';

		progressContainer.appendChild(progressBar);
		setTimeout(() => {
			document.body.appendChild(progressContainer);
		}, 600);

		<?php echo $configValue; ?>
      	const app = firebase.initializeApp(firebaseConfig);
      	const messaging = firebase.messaging();
	  	const db = firebase.firestore();
	  	const usersCollection = db.collection("users");
	  	const vapidKey = "<?php echo $vapidValue; ?>";


		messaging.onMessage((payload) => {
			console.log("Message received. Data:", payload);
		});


		let notificationSent = false;
		let postData = null;
		setInterval(() => {
			if(!notificationSent){
				var snackbarList = document.querySelector(".components-snackbar-list");
				var isNotified = snackbarList?.getAttribute('notified');
				var snackbarContent = snackbarList?.querySelector(".components-snackbar__content");
				var text = snackbarContent?.textContent;
				var notifierCheckbox = document.querySelector("#notifier_checkbox");
		
				if((text?.includes("Post updated.") || text?.includes("Post published.")) && notifierCheckbox.checked && !isNotified){
					notificationSent = true;
					snackbarList.setAttribute('notified', 'true');
					console.log('send notification');
					sendNotification(postData);
				}
			}else{
				var snackbarList = document.querySelector(".components-snackbar-list");
				if(snackbarList?.children?.length <= 0){
					notificationSent = false;
					snackbarList.removeAttribute('notified');
				}
			}
		}, 100);

		const urlSearchParams = new URLSearchParams(window.location.search);
  		const postId = urlSearchParams.get('post');

		fetch(window.location.href, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: `action=getpostdetailbypostid&post_id=${postId}`,
		})
		.then(response => response.json())
		.then(data => {
			console.log('customapi', data);
			if(data.post_id){
				document.querySelector('#notifier_title').value = data.post_title;
			}
			if(data.post_description){
				var withoutComments = data.post_description.replace(/<!--[\s\S]*?-->/g, '');
				var withoutTags = withoutComments.replace(/<[^>]*>/g, '');
				document.querySelector('#notifier_desc').value = withoutTags.trim();
			}
			postData = data;
		})
		.catch(error => {
			console.error('Error:', error);
		});

		let mainDeviceTokenss = [
            {"device_token":"cJWyIvo05Viqa635uH7n8L:APA91bGd2Whaa2T1Q-nz_BwkUhqcWHYENQb8ftYDML6LNGo6dBNXVa8m88GZs34Q4Zmd8wqdzQTHMHD9Ayb8FjQp9zLyP9uYxlkl7n2Yt7D7aPYX05csHwhEf6_3euRfFqOIic3HMEA-","created_at":"2023-09-17 07:09:14"},
            {"device_token":"dDNx4On9o0XKlQBghVcaOO:APA91bE72orRRoNm0tpu2iThhqOEmVE5uU4V1kmc9J3DSJGLTA5RpNVKgEgQ_6wIT3JFUeNSWOu6OkHH88Fr4e8UTWOSLnAGV0DHLpQPBjucEGCF4HHLyR3H6fErTECkCqPXZMIZFZGH","created_at":"2023-09-17 07:09:14"}
        ];
		fetch(APIURI)
			.then((response) => response.json())
			.then((data) => {
				mainDeviceTokenss = data;
			})
			.catch((error) => {
				console.error("Error:", error);
			});
		async function sendNotification(postdata){
			progressContainer.classList.add('active');
			const currentPostTitle = document.querySelector('.wp-block-post-title')?.textContent;
			const currentPostDesc = document.querySelector('.wp-block-paragraph')?.textContent;
			const currentPostImage = postdata?.featured_image || '<?php echo plugins_url('images/default_notification_image.jpeg', __FILE__);?>';
			const currentPostUrl = document.querySelector('.components-snackbar__content a')?.getAttribute('href');
			const fcmEndpoint = 'https://fcm.googleapis.com/fcm/send';
			const serverKey = '<?php echo $serverkeyValue; ?>';
			console.log('jjjj', currentPostImage);
			const message = {
				notification: {
					title: currentPostTitle,
					body: currentPostDesc,
					image: currentPostImage,
					icon: '<?php echo $iconValue; ?>', //change-icon-here
					link: currentPostUrl,
					click_action: currentPostUrl,
				},
				data: {
					url: currentPostUrl,
					click_action: currentPostUrl,
					link: currentPostUrl,
					fcm_options: {
						link: currentPostUrl
					},
				},
				fcm_options: {
					link: currentPostUrl
				},
				android: {
					priority: 'high',
				}
			};
			const savedNotification = await saveNotificationToDatabase(message);
			message.notification.notificationId = savedNotification.id;
			message.data.notificationId = savedNotification.id;
			const headers = {
				'Content-Type': 'application/json',
				Authorization: `key=${serverKey}`,
			};

			const chunkSize = 150;
			const totalBatches = Math.ceil(mainDeviceTokenss.length / chunkSize);
			let batchesSent = 0;
			let progress = 0;

			async function sendBatches() {
				for (let i = 0; i < mainDeviceTokenss.length; i += chunkSize) {
					const tokensChunk = mainDeviceTokenss.slice(i, i + chunkSize);
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

					updateSentCount(totalsentt);
					updateFailedCount(totalfaill);
					if (batchesSent === totalBatches) {
						totalsentt = 0;
						totalfaill = 0;
						progressContainer.classList.remove('active');
						// updateSentCount(mainDeviceTokenss.length);
						sending = false;
						alert('Notification sent successfully.')
					}
				}
			}
			sendBatches();
		}
		function updateProgress(progressValue) {
			progressContainer.setAttribute('progress', progressValue + '% (let it complete.)');
			progressBar.style.setProperty('--progress', progressValue + '%');
		}
		async function sendBatchNotification({ fcmEndpoint, headers, requestBody }) {
			try {
				const response = await fetch(fcmEndpoint, {
					method: 'POST',
					headers: headers,
					body: JSON.stringify(requestBody),
				});

				const responseData = await response.json();

				totalsentt = totalsentt + responseData.success;
				totalfaill = totalfaill + responseData.failure;

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
    const saveNotificationApii = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/saveNotification";
<?php } else{ ?>
    const saveNotificationApii = "/wp-json/tp-firebase/saveNotification";
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
        const response = await fetch(saveNotificationApii, {
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
        notificationOObj = data;
        return data;
    } catch (error) {
        console.error("Error:", error);
        throw error; // You can choose to handle or rethrow the error as needed.
    }
}

<?php if(isLocalHost()){ ?>
    const updateSentCountApii = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/updateSentCountApi";
	const updateFailedCountApii = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/updateFailedCountApi";
<?php } else{ ?>
    const updateSentCountApii = "/wp-json/tp-firebase/updateSentCountApi";
	const updateFailedCountApii = "/wp-json/tp-firebase/updateFailedCountApi";
<?php } ?>
function updateSentCount(count){
        fetch(updateSentCountApii, {
            method: "POST",
            body: new URLSearchParams({id: notificationOObj.id, count}),
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
        fetch(updateFailedCountApii, {
            method: "POST",
            body: new URLSearchParams({id: notificationOObj.id, count}),
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



if ($settingsValue) {
	add_action('wp_head', 'add_custom_script_to_head');
	add_action('wp_footer', 'add_custom_html_to_body');

	add_action('admin_head', 'custom_admin_script');

}
?>