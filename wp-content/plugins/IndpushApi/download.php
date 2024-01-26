<?php
// Ensure the file parameter is set
if (isset($_GET['file'])) {
    // Define the path to the ZIP file
    $zip_file = plugin_dir_path(__FILE__) . $_GET['file'];

    // Check if the file exists and is readable
    if (file_exists($zip_file) && is_readable($zip_file)) {
        // Set appropriate headers
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . basename($zip_file) . '"');
        header('Content-Length: ' . filesize($zip_file));

        // Read the file and output it to the browser
        readfile($zip_file);

        // Exit script after file download
        exit;
    } else {
        // File not found or not readable
        echo 'Error: File not found or not readable.';
    }
} else {
    // File parameter not set
    echo 'Error: File parameter not set.';
}
?>
