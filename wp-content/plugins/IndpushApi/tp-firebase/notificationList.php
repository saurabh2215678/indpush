<?php
function get_total_notifications_count() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_notifications';
    $total_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
    return $total_count;
}


function timeAgo($timestamp) {
    $datetime1 = new DateTime($timestamp);
    $datetime2 = new DateTime(current_time('mysql'));
    $interval = $datetime1->diff($datetime2);

    $format = "";

    if ($interval->y > 0) {
        $format = "%y years ago";
    } elseif ($interval->m > 0) {
        $format = "%m months ago";
    } elseif ($interval->d > 0) {
        $format = "%d days ago";
    } elseif ($interval->h > 0) {
        $format = "%h hours ago";
    } elseif ($interval->i > 0) {
        $format = "%i minutes ago";
    } else {
        return "Just now";
    }

    return $interval->format($format);
}


function getNotificationList() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tp_notifications';

    $results_per_page = 10;
    $total_count = get_total_notifications_count();
    $total_pages = ceil($total_count / $results_per_page);

    $paged = isset($_GET['pageno']) ? max(1, intval($_GET['pageno'])) : 1;
    $offset = ($paged - 1) * $results_per_page;

    // $results = $wpdb->get_results("SELECT * FROM $table_name LIMIT $results_per_page OFFSET $offset", OBJECT);
    $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC LIMIT $results_per_page OFFSET $offset", OBJECT);
    ?>
    <style>
        .notify_list_page h3{font-size:1.5em}
        .notify_list_page *{margin:0;padding:0;box-sizing:border-box}
        .notify_list_page ul{margin:1.2em 0}
        .notify_list_page{padding:1em;padding-top:1.5em}
        .notify_list_page>ul>li{background-color:#fff;margin:.8em 0;border-radius:5px;box-shadow:-2px 2px 2px #00000021;overflow: hidden;}
        .notification_title{padding:.6em 1.2em;cursor:pointer; display: flex; justify-content: space-between; align-self: center;}
        .notification_details{display: grid; grid-template-rows: 0fr; transition: 0.3s;}
        .active .notification_details{grid-template-rows: 1fr;}
        .notification_details > div { overflow: hidden; }
        .notification_details table { width: calc(100% + 2px); border-collapse: collapse; margin: -1px; margin-top: 0;}
        .notification_details table td { border: 1px dashed #dbdbdb; }
        .notify_img{width:4em}
        .notification_details table tr.tbl_head_top td{width:25%;padding: 0.5em;white-space: nowrap;}
        .content_box{padding:1em}
        .link_box{display:flex}
        .link_box span{padding:.5em;width:initial;height:initial;background-color:#409fec;color:#fff}
        .link_box a{display:flex;align-items:center;flex-grow:1;padding:.2em 1.1em;text-decoration:none}
        .notify_list_page td .label{font-size:1.1em}
        .tbl_head_top{text-align:center}
        .notification_details table tr.tbl_head_top td p{font-size:1.5em;font-weight:600}
        .active .notification_title { background-color: #409fec; color: #fff; }
        .pagination { display: inline-flex; box-shadow: -2px 2px 7px #0000003b; border-radius: 5px; } .pagination>* { padding: 0.6em 1em; background-color: #fff; text-decoration: none; font-weight: 500; overflow: hidden;} .pagination>*:first-child { border-radius: 5px 0 0 5px; } .pagination>*:last-child { border-radius: 0 5px 5px 0; } .pagination .current-page { background-color: #409fec; color: #fff; } .pagination>a:hover { background-color: #eaf5ff; }

        @media (max-width: 768px){
            .notification_details > div{
                overflow-x: auto;
                overflow-y: hidden;
            }
        }
    </style>
    <div class="notify_list_page">
        <?php if ($results) { ?>
            <h3>Notification List</h3>
            <ul>
                <?php foreach ($results as $result) { ?>
                    <li>
                        <div class="notification_title">
                            <h4><?php echo $result->title; ?></h4>

                            <p style="margin-left: auto;"><?php echo timeAgo($result->created_at); ?></p>
                        

                            <span class="dashicons dashicons-arrow-down-alt2"></span>
                        </div>
                        <div class="notification_details">
                            <div>
                                <table>
                                    <tr class="tbl_head_top">
                                        <td><h4 class="label">Subs</h4></td>
                                        <td><h4 class="label">Sent</h4></td>
                                        <td><h4 class="label">Failed <small>(may be unsubscribed)</small></h4></td>
                                        <td><h4 class="label">Delivered <small>(Realtime delivered)</small></h4></td>
                                        <td><h4 class="label">Clicked <small>(including action buttons)</small></h4></td>
                                        <td><h4 class="label">Image</h4></td>
                                    </tr>
                                    <tr class="tbl_head_top">
                                        <td><p><?php echo $result->subsCount ? $result->subsCount : $result->sentCount; ?></p></td>
                                        <td><p><?php echo $result->sentCount ?></p></td>
                                        <td><p><?php echo $result->failedCount ? $result->failedCount : 0; ?></p></td>  
                                        <td><p><?php echo $result->deliveryCount; ?></p></td>  
                                        <td><p><?php echo $result->clickCount ?></p></td>
                                        <td><img class="notify_img" src="<?php echo $result->image ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <div class="link_box">
                                                <span class="dashicons dashicons-admin-links"></span>
                                                <a href="<?php echo $result->link ?>" target="_blank"><?php echo $result->link ?></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <div class="content_box">  
                                                <h4 class="content_title"><?php echo $result->title ?></h4>
                                                <p><?php echo $result->description ?></p>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </li>
                <?php  } ?>
            </ul>
        <?php } else {  ?>
            <h4>No notifications found.</h4>
        <?php } ?>
 
        <?php
        if($total_pages > 1){
            echo '<div class="pagination">';
            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $paged) {
                    echo "<span class='current-page'>$i</span>";
                } else {
                    echo "<a href='?page=notification-list&pageno=$i'>$i</a>";
                }
            }
            echo '</div>';

        }
        ?>
    </div>
    <script>
        var notificationTitles = document.querySelectorAll('.notification_title');
        notificationTitles.forEach(function(notificationTitle) {
        notificationTitle.addEventListener('click', function() {
            var li = this.closest('li');
            if (li) {
            li.classList.toggle('active');
            }
        });
        });

    </script>
    <?php
}

getNotificationList();
?>