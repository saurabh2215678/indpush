<?php
global $wpdb;
$table_name = $wpdb->prefix . 'tp_notifications';
$deviceTokenTable = $wpdb->prefix . 'devicetokens';

// Calculate total clickCount
$total_clickCount = $wpdb->get_var("SELECT SUM(clickCount) FROM $table_name");

// Calculate total deliveryCount
$total_deliveryCount = $wpdb->get_var("SELECT SUM(deliveryCount) FROM $table_name");

// Calculate total sentCount
$total_sentCount = $wpdb->get_var("SELECT SUM(sentCount) FROM $table_name");

$device_token_count_query = $wpdb->prepare("SELECT COUNT(*) FROM $deviceTokenTable");
$device_token_count = $wpdb->get_var($device_token_count_query);

if(!isset($total_clickCount)){
    $total_clickCount = 0;
}
if(!isset($total_deliveryCount)){
    $total_deliveryCount = 0;
}
if(!isset($total_sentCount)){
    $total_sentCount = 0;
}
if(!isset($device_token_count)){
    $device_token_count = 0;
}

?>

<style>
.total_boxes * { margin: 0; padding: 0; box-sizing: border-box; }
.main_wrapper { padding-top: 1.5em; padding-right: 3em;}
.total_boxes { display: flex; align-items: center; margin-bottom: 2.5em;}
.totla_box { min-width: 12em; background-color: #fff; margin-right: 1em; text-align: center; padding: 1em; border-radius: 5px; box-shadow: -1px 3px 6px #00000030; }
.totla_box h4 { font-size: 2em; line-height: 1.5em; }
.graph_box { background-color: #fff; padding: 1em; }
.export_import_box { display: flex; display: none; align-self: stretch; flex-grow: 1; justify-content: space-between; } 
.export_import_box>* { cursor: pointer; width: calc(50% - 0.6em); background-color: #fff; border-radius: 5px; box-shadow: -1px 3px 6px #00000030; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 1.25em; font-weight: 600; color: #409fec; }
 input#import_subscribers { display: none; } 
 .export_import_box>*:hover { color: #2b81c7; }
 .import_subscribers_box label { height: 100%; width: 100%; display: flex; align-items: center; justify-content: center; }
</style>
<div class="main_wrapper">

    <div class="total_boxes">
        <div class="totla_box">
            <h3>Total Clicked</h3>
            <h4><?php echo $total_clickCount; ?></h4>
        </div>
        <div class="totla_box">
            <h3>Total Delivered</h3>
            <h4><?php echo $total_deliveryCount; ?></h4>
        </div>
        <div class="totla_box">
            <h3>Total Sent</h3>
            <h4><?php echo $total_sentCount; ?></h4>
        </div>
        <div class="totla_box">
            <h3>Total Subscribers</h3>
            <h4><?php echo $device_token_count; ?></h4>
        </div>
        <div class="export_import_box">
            <a href="<?php echo plugins_url('device_tokens_export.json', __FILE__); ?>" download>Export Subscribers</a>
            <div class="import_subscribers_box">
                <input type="file" id="import_subscribers">
                <label for="import_subscribers">Import Subscribers</label>
            </div>
        </div>
    </div>
    <div class="graph_box">
        <div class="dateSelector">
            <select name="date_selector" id="date_selector">
                <option value="<?php echo date('Y-m-d 10:00:00'); ?>">Today</option>
                <option value="<?php echo date('Y-m-d 10:00:00', strtotime('yesterday')); ?>">Yesterday</option>
                <option value="<?php echo date('Y-m-d 10:00:00', strtotime('-1 week')); ?>" selected>1 week ago</option>
                <option value="<?php echo date('Y-m-d 10:00:00', strtotime('-1 month')); ?>">1 month ago</option>
            </select>
        </div>
        <div id="chart"></div>
        <div id="chart2"></div>
        <div id="chart3"></div>
    </div>

</div>
<script src="https://unpkg.com/apexcharts@3.44.0/dist/apexcharts.min.js"></script>
<script>
<?php if(isLocalHost()){ ?>
    const ReportURI = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/getReport";
<?php } else{ ?>
    const ReportURI = "/wp-json/tp-firebase/getReport";
<?php } ?>
document.getElementById('date_selector').addEventListener('change', function () {
    var selectedDate = this.value;
    getReport(selectedDate);
});
getReport('<?php echo date('Y-m-d 10:00:00', strtotime('-1 week')); ?>');

function getReport(selectedDate){
    const urlParams = { datetime: selectedDate };
    fetch(ReportURI, {
            method: "POST",
            body: new URLSearchParams(urlParams),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
        })
        .then((response) => response.json())
        .then((data) => {
            // console.log(data);
            const result = getDateAndDataArray(data.notifications, selectedDate);
            updateChartOptions(result, data);
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

function getDateAndDataArray(notifications, selectedDate) {
    const currentDate = new Date();
    const startDate = new Date(selectedDate);
    const datesArray = [];
    const clickCountArray = [];
    const sentCountArray = [];
    const deliveryCountArray = [];
    const notificationsByDate = {};

    while (startDate <= currentDate) {
        const dateStr = startDate.toISOString().split('T')[0];
        datesArray.push(dateStr);

        const filteredNotifications = notifications.filter(notification => {
            const createdAtDate = notification.created_at.split(' ')[0];
            return createdAtDate === dateStr;
        });

        notificationsByDate[dateStr] = filteredNotifications;

        const clickCountSum = notifications
            .filter(notification => {
                const createdAtDate = notification.created_at.split(' ')[0];
                return createdAtDate === dateStr;
            })
            .reduce((sum, notification) => sum + parseInt(notification.clickCount), 0);

        clickCountArray.push(clickCountSum);

        const sentCountSum = notifications
            .filter(notification => {
                const createdAtDate = notification.created_at.split(' ')[0];
                return createdAtDate === dateStr;
            })
            .reduce((sum, notification) => sum + parseInt(notification.sentCount), 0);
        
        sentCountArray.push(sentCountSum);

        const deliveryCountSum = notifications
            .filter(notification => {
                const createdAtDate = notification.created_at.split(' ')[0];
                return createdAtDate === dateStr;
            })
            .reduce((sum, notification) => sum + parseInt(notification.deliveryCount), 0);
        
        deliveryCountArray.push(deliveryCountSum);



        startDate.setDate(startDate.getDate() + 1);
    }

    return {
        dates: datesArray,
        clickCount: clickCountArray,
        sentCount: sentCountArray,
        deliveryCount: deliveryCountArray,
        notificationsByDate: notificationsByDate,
    };
}




var series1 = [{
        name: 'Clicked',
        data: []
    }];
var series2 = [{
        name: 'Sent',
        data: []
    }];
var series3 = [{
        name: 'Delivered',
        data: []
    }];

var options = {
    series: [{
        name: 'Clicked',
        data: []
    }],
    chart: {
        type: 'bar',
        height: 350
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
    },
    xaxis: {
        categories: [],
    },
    fill: {
        opacity: 1
    },
    tooltip: {
        y: {
        formatter: function (val) {
            return val + " Notifications"
        }
        }
    }
};
var chart1 = new ApexCharts(document.querySelector("#chart"), options);
var chart2 = new ApexCharts(document.querySelector("#chart2"), options);
var chart3 = new ApexCharts(document.querySelector("#chart3"), options);

function updateChartOptions(data, resp){
    chart1.updateOptions({
        xaxis: {
            categories: data.dates
        },
        yaxis: {
            title: {
            text: 'Clicks'
            }
        },
        series: [{
            name: `Clicked (${resp.totalClickcount})`,
            data: data.clickCount
        }],
    });


    chart2.updateOptions({
        xaxis: {
            categories: data.dates
        },
        yaxis: {
            title: {
            text: 'Sent'
            }
        },
        series: [{
            name: `Sent (${resp.totalSentCount})`,
            data: data.sentCount
        }],
    });
    chart3.updateOptions({
        xaxis: {
            categories: data.dates
        },
        yaxis: {
            title: {
            text: 'Delivered'
            }
        },
        series: [{
            name: `Delivered (${resp.totalDeliveryCount})`,
            data: data.deliveryCount
        }],
    });

}

chart1.render();
chart2.render();
chart3.render();

<?php if(isLocalHost()){ ?>
    const ImportMemberApi = "/<?php echo getProjectName(); ?>/wp-json/tp-firebase/importDeviceTokens";
<?php } else{ ?>
    const ImportMemberApi = "/wp-json/tp-firebase/importDeviceTokens";
<?php } ?>
    
document.getElementById("import_subscribers").addEventListener("change", function(event) {
  const fileInput = event.target;
  const file = fileInput.files[0]; // Get the selected file

  if (file) {
    const formData = new FormData();
    formData.append("file", file); // Attach the file to a FormData object

    fetch(ImportMemberApi, {
      method: "POST",
      body: formData,
    })
      .then(response => {
        if (response.ok) {
          // Handle a successful response
        //   console.log("Subscribers imported successfully.");
        alert('Subscribers imported successfully.');
        window.location.reload();
        } else {
          // Handle errors
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


</script>