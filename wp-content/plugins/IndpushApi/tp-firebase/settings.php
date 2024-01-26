<?php
global $wpdb;
global $testCount;
global $userId;
$table_name = $wpdb->prefix . 'tp_settings';
$existing_data = $wpdb->get_row("SELECT * FROM $table_name", ARRAY_A);
if (isset($_POST['submit'])) {
    $config = $_POST['config'];
    $icon = sanitize_text_field($_POST['icon']);
    $serverkey = sanitize_text_field($_POST['serverkey']);
    $vapid = sanitize_text_field($_POST['vapid']);
    $popuptitle = sanitize_text_field($_POST['popuptitle']);
    $popupimage = sanitize_text_field($_POST['popupimage']);
    $popupUI = sanitize_text_field($_POST['popup_ui']);
    $yesBtnTxt = sanitize_text_field($_POST['yes_btn_txt']);
    $noBtnTxt = sanitize_text_field($_POST['no_btn_txt']);
    $yesBtnColor = sanitize_text_field($_POST['yes_btn_color']);
    $noBtnColor = sanitize_text_field($_POST['no_btn_color']);
    $txtColor = sanitize_text_field($_POST['txt_color']);

    $data = array(
        'config' => $config,
        'icon' => $icon,
        'serverkey' => $serverkey,
        'vapid' => $vapid,
        'popuptitle' => $popuptitle ? $popuptitle : 'Notify from this website?',
        'popupimage' => $popupimage ? $popupimage : plugins_url('images/default_notification_image.jpeg', __FILE__),
        'popup_ui' => $popupUI ? 1 : 0,
        'yes_btn_txt' => $yesBtnTxt ? $yesBtnTxt : 'Yes',
        'no_btn_txt' => $noBtnTxt ? $noBtnTxt : 'No',
        'yes_btn_color' => $yesBtnColor ? $yesBtnColor : '#00bc27',
        'no_btn_color' => $noBtnColor ? $noBtnColor : '#e93b3b',
        'txt_color' => $txtColor ? $txtColor : '#ffffff'

    );

    if ($existing_data) {
        $where = array('id' => $existing_data['id']);
        $wpdb->update($table_name, $data, $where);
        
    } else {
        $wpdb->insert($table_name, $data);
    }
    $existing_data = $data;
    updateConfigJsFile($existing_data);
}
if ($existing_data) {
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
    
}else{
    $configValue = '';
    $serverkeyValue = '';
    $vapidValue = '';
    $iconValue = 'the icon';
    $popuptitleValue = 'Do You want recieve notifications?';
    $popupimageValue = plugins_url('images/default_notification_image.jpeg', __FILE__);
    $popupUIValue = 1;
    $yesBtnTxt = 'Yes';
    $noBtnTxt = 'No';
    $yesBtnColor = '#00bc27';
    $noBtnColor = '#e93b3b';
    $txtColor = '#ffffff';
}
if ($existing_data && isset($existing_data['delete_date'])) {
    $delete_date = $existing_data['delete_date'];
}else{
    $delete_date = '';
}

$auto_delete = isset($existing_data['auto_delete']) ? $existing_data['auto_delete'] : 0 ;
$popupUI = isset($existing_data['popup_ui']) ? $existing_data['popup_ui'] : 0 ;
$plugin_uri = plugins_url('/', __FILE__);
?>
<style>
    .tp_wrapp * { margin: 0; padding: 0; box-sizing: border-box; }
    .settings_form { display: flex; flex-wrap: wrap; justify-content: space-between; padding: 2em; }
    .settings_form>* { padding: 2em; width: calc(50% - 0.5em); background-color: #fff; border: 1px solid #bdbdbd; border-radius: 5px; }
    .settings_form * { box-sizing: border-box; }
    .settings_form h3 { font-size: 1.8em; margin-bottom: 0.6em; font-weight: 700; color: #3b3b3b; }
    .tp_wrapp .form_group { display: flex; flex-direction: column; }
    .tp_wrapp .form_group label { font-size: 1.2em; font-weight: 600; margin-bottom: 0.2em; }
    .tp_wrapp .form_group textarea, .tp_wrapp .form_group input { border-color: #cacaca; margin-bottom: 1.1em; }
    .tp_wrapp .submit_btn input[type="submit"] { margin-bottom: 0; border: none; padding: 1em; font-size: 1.2em; font-weight: 600; text-transform: uppercase; border-radius: 5px; background-color: #409fec; color: #fff; cursor: pointer; }
    .req_span { color: red; }
    .total_boxes * { margin: 0; padding: 0; box-sizing: border-box; }
    .main_wrapper { padding-top: 1.5em; padding-right: 3em;}
    .total_boxes { display: flex; align-items: center; margin-bottom: 2.5em;}
    .totla_box { min-width: 12em; background-color: #fff; margin-right: 1em; text-align: center; padding: 1em; border-radius: 5px; box-shadow: -1px 3px 6px #00000030; }
    .totla_box h4 { font-size: 2em; line-height: 1.5em; }
    .graph_box { background-color: #fff; padding: 1em; }
    .export_import_box { display: flex; align-self: stretch; justify-content: space-between; width: 27rem;}
    .export_import_box>* { cursor: pointer; width: calc(50% - 0.6em); background-color: #fff; border-radius: 5px; box-shadow: -1px 3px 6px #00000030; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.25em; font-weight: 600; color: #409fec; padding: 1em; padding-top: 0.8em;}
    input#import_subscribers { display: none; } 
    .options{padding: 2rem; padding-bottom: 0; display: flex;}
    .export_import_box>*:hover { color: #2b81c7; }
    .import_subscribers_box label { height: 100%; width: 100%; display: flex; align-items: center; justify-content: center; }
    .loader {
        width: 48px;
        height: 48px;
        min-width: 48px;
        min-height: 48px;
        display: inline-block;
        position: relative;
        border: 3px solid;
        border-color:#de3500 #0000 #409fec #0000;
        border-radius: 50%;
        box-sizing: border-box;
        animation: 1s rotate linear infinite;
    }
    .loader:before , .loader:after{
        content: '';
        top: 0;
        left: 0;
        position: absolute;
        border: 10px solid transparent;
        border-bottom-color:#409fec;
        transform: translate(-10px, 19px) rotate(-35deg);
    }
    .loader:after {
        border-color: #de3500 #0000 #0000 #0000 ;
        transform: translate(32px, 3px) rotate(-35deg);
    }
    @keyframes rotate {
        100%{    transform: rotate(360deg)}
    }

    .loader_wrapper{display: none;}
    .importing_txt{display: none;}
    .loader_wrapper { transform: scale(0.5); margin: -17px 0; margin-left: -42px; }

    .import_btn.importing .loader_wrapper,
    .import_btn.importing .importing_txt{display:block;}
    .import_btn.importing .import_subs_txt{display: none;}



    .options .switch{position:relative;display:inline-block;width:60px;height:34px}
    .options .switch input{opacity:0;width:0;height:0}
    .options .slider{position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background-color:#ccc;-webkit-transition:.4s;transition:.4s}
    .options .slider:before{position:absolute;content:"";height:26px;width:26px;left:4px;bottom:4px;background-color:#fff;-webkit-transition:.4s;transition:.4s}
    .options input:checked+.slider{background-color:#2196f3}
    .options input:focus+.slider{box-shadow:0 0 1px #2196f3}
    .options input:checked+.slider:before{-webkit-transform:translateX(26px);-ms-transform:translateX(26px);transform:translateX(26px)}
    .options .slider.round{border-radius:34px}
    .options .slider.round:before{border-radius:50%}

    .select_notification_deletion { flex-grow: 1; padding: 1.3em; margin-left: 1em; background-color: #fff; border-radius: 5px; box-shadow: -1px 3px 6px #00000030; }
    .select_notification_deletion h3 { margin-bottom: 1em; }
    .select_notification_deletion .button { vertical-align: middle; }
    .tp_wrapp .form_group.pop_up_ui_box { flex-direction: row; align-items: center; margin-bottom: 0.5rem; }
    .tp_wrapp .form_group.pop_up_ui_box #popup_ui{margin-bottom: 0;}
    .config_settings { display: none; }
    @media (max-width: 768px){
        .options {
            flex-direction: column;
            padding: 0.5rem;
        }
        .export_import_box>* {
            width: calc(50% - 0.3em);
            margin-bottom: 0.5rem;
            font-size: 0.999rem;
        }
        .select_notification_deletion {
            margin-left: 0;
        }
        .export_import_box{
            width: 100%;
        }
    }
</style>
<div class="plugin-validation-box"></div>

<div class="tp_wrapp">
    <div class="options">
        <div class="export_import_box">
            <a href="<?php echo plugins_url('device_tokens_export.json', __FILE__); ?>" download>Export Subscribers</a>
            <div class="import_subscribers_box">
                <input type="file" id="import_subscribers">
                <label for="import_subscribers" class="import_btn">
                    <div class="loader_wrapper">
                        <span class="loader"></span>
                    </div>
                    <div class="importing_txt">Importing</div>
                    <div class="import_subs_txt">Import Subscribers</div>
                 </label>
            </div>
        </div>
        <form method="post" class="select_notification_deletion">
            <h3>Auto Delete Notification List</h3>
            <label class="switch">
                <input type="checkbox" name="auto-delete" <?php echo ($auto_delete == 1) ? 'checked' : ''; ?>>
                <span class="slider round"></span>
            </label>
            <select name="delete-date">
                <?php
                $options = array(
                    date('Y-m-d', strtotime("-1 week")) => "After 1 week",
                    date('Y-m-d', strtotime("-2 week")) => "After 2 weeks",
                    date('Y-m-d', strtotime("-1 month")) => "After 1 month",
                    date('Y-m-d', strtotime("-1 year")) => "After 1 year"
                );

                foreach ($options as $value => $label) {
                    $selected = ($value == date('Y-m-d', strtotime($delete_date))) ? 'selected' : '';
                    echo "<option value=\"$value\" $selected>$label</option>";
                }
                ?>
            </select>


            <input type="submit" name="submit" value="Submit" class="button" />
        </form>
    </div>
    <form method="post" action="" class="settings_form" id="setting_form">
        <div class="config_settings">
            <div class="top_ui_box">
                <h3>Firebase configuration</h3>
            </div>
            <div class="form_group">
                <label>Configuration<span class="req_span">*</span></label>
                <textarea name="config" cols="30" rows="10"required><?php echo $configValue; ?></textarea>
            </div>
            <div class="form_group">
                <label>Server Key<span class="req_span">*</span></label>
                <input type="text" name="serverkey" placeholder="serverkey" value="<?php echo $serverkeyValue; ?>" required/>
            </div>
            <div class="form_group">
                <label>Vapid<span class="req_span">*</span></label>
                <input type="text" name="vapid" placeholder="vapid" value="<?php echo $vapidValue; ?>" required/>
            </div>
            <div class="form_group submit_btn">
                <input type="submit" name="submit" value="Submit" />
            </div>
        </div>
    
        <div class="notification_ui">
            <h3>Notification <small>this icon will show in push notification</small></h3>
            <div class="form_group">
                <label>Icon</label>
                <input type="text" name="icon" placeholder="Icon" value="<?php echo $iconValue; ?>" required />
            </div>
            <div class="form_group pop_up_ui_box">
                <input type="checkbox" id="popup_ui" name="popup_ui" <?php echo ($popupUI == 1) ? 'checked' : ''; ?>>
                <label for="popup_ui">Enable/disable Customize Popup.</label>
            </div>

            <div class="form_group">
                <label>Title</label>
                <input type="text" name="popuptitle" placeholder="popuptitle" placeholder="" value="<?php echo $popuptitleValue; ?>"/>
            </div>
            <div class="form_group">
                <label>Icon for poup</label>
                <input type="text" name="popupimage" placeholder="popup image url" value="<?php echo $popupimageValue; ?>"/>
            </div>
            <div class="form_group">
                <label>Allow Button Text</label>
                <input type="text" name="yes_btn_txt" placeholder="Yes" value="<?php echo $yesBtnTxt; ?>"/>
            </div>
            <div class="form_group">
                <label>Deny Button Text</label>
                <input type="text" name="no_btn_txt" placeholder="No" value="<?php echo $noBtnTxt; ?>"/>
            </div>
            <div class="form_group">
                <label>Allow Button Color</label>
                <input type="color" name="yes_btn_color" placeholder="#00bc27" value="<?php echo $yesBtnColor; ?>"/>
            </div>
            <div class="form_group">
                <label>Deny Button Color</label>
                <input type="color" name="no_btn_color" placeholder="#e93b3b" value="<?php echo $noBtnColor; ?>"/>
            </div>
            <div class="form_group">
                <label>Both Button Text Color</label>
                <input type="color" name="txt_color" placeholder="currentcolor" value="<?php echo $txtColor; ?>"/>
            </div>
            <div class="form_group submit_btn">
                <input type="submit" name="submit" value="Submit" />
            </div>
        </div>
    </form>
</div>
<script>
    let firebaseData;
    
    async function fetchFirebaseData(){
        const responce = await fetch('https://indpush.com/wp-json/api/firebase-data',{
            method:'post',
            body:new URLSearchParams({'userId' : <?php echo $userId; ?>}),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
                }
        });

        const data = await responce.json();
        let pageParam = getPageParamFromURL(window.location.href);
        
        if(data.data){
            const firebaseData = data.data;
            const configinput = document.querySelector('[name="config"]');
            const serverkeyinput = document.querySelector('[name="serverkey"]');
            const vapidinput = document.querySelector('[name="vapid"]');

            if(configinput.innerHTML !== firebaseData.config ||
                serverkeyinput.value !== firebaseData.serverkey ||
                vapidinput.value !== firebaseData.vapid
                ){
                    pageParam = 'tp-notification';
                }

            configinput.innerHTML = firebaseData.config
            serverkeyinput.value = firebaseData.serverkey
            vapidinput.value = firebaseData.vapid

            if(pageParam == 'tp-notification'){
                document.querySelector('.submit_btn [name="submit"]').click()
                console.log('click submit')
            }
            // document.querySelector('.submit_btn [name="submit"]').click();
            // const settingsForm = document.getElementById('setting_form');
            // console.log('settingsForm', settingsForm);
            // setTimeout(() => {
            //     settingsForm.submit();
            //     console.log('dataaaa', firebaseData);
            // }, 1000);
        
        }else{
            console.error('data not found');
        }
        
    }

    function getPageParamFromURL(url) {
        const urlParams = new URLSearchParams(new URL(url).search);
        return urlParams.get('page');
    }

    fetchFirebaseData();
</script>

<script>
    
<?php if(isLocalHost()){ ?>
    const ImportMemberApii = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/importDeviceTokens";
    const saveAutoDeleteApii = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/save-auto-delete-data";
<?php } else{ ?>
    const ImportMemberApii = "/wp-json/tp-firebase/importDeviceTokens";
    const saveAutoDeleteApii = "/wp-json/tp-firebase/save-auto-delete-data";
<?php } ?>
    
document.getElementById("import_subscribers").addEventListener("change", function(event) {
  const fileInput = event.target;
  const file = fileInput.files[0]; // Get the selected file

  if (file) {
    const formData = new FormData();
    formData.append("file", file); // Attach the file to a FormData object

    var importBtn = document.querySelector('.import_btn');
    if (importBtn) {
        importBtn.classList.add('importing');
    }

    fetch(ImportMemberApii, {
      method: "POST",
      body: formData,
    })
      .then(response => {
        if (response.ok) {
          // Handle a successful response
          //console.log("Subscribers imported successfully.");
            importBtn.classList.remove('importing');
            alert('Subscribers imported successfully.');
            window.location.reload();
        } else {
          // Handle errors
          importBtn.classList.remove('importing');
          importBtn.classList.add('has-error');
          console.error("Error importing subscribers.");
        }
      })
      .catch(error => {
        console.error("Network error:", error);
      });
  } else {
    console.error("No file selected.");
  }
});

document.querySelector('.select_notification_deletion').addEventListener('submit', function(e) {
    e.preventDefault();
    const autoDeleteData = document.querySelector('[name=auto-delete]').checked ? 1 : 0;
    const deleteDateData = document.querySelector('[name=delete-date]').value;


    const deleteDataObj = { 'delete-date': deleteDateData, 'auto-delete': autoDeleteData };
    fetch(saveAutoDeleteApii, {
                method: "POST",
                body: new URLSearchParams(deleteDataObj),
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    alert(data.message);
                    location.reload();
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
});


</script>