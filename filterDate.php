<?php

// Kiểm tra xem form đã được submit chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Chuyển đổi ngày thành timestamp để so sánh
    $start_timestamp = strtotime($start_date);
    $end_timestamp = strtotime($end_date);

    $filtedTrans = getTransactions($start_timestamp, $end_timestam, $connection);

    // Hiển thị kết quả
    if (!empty($filtered_events)) {
        foreach ($filtered_events as $event) {
            echo "Name: " . htmlspecialchars($event["name"]) . " - Date: " . htmlspecialchars($event["date"]) . "<br>";
        }
    } else {
        echo "No events found within the selected date range.";
    }
} else {
    echo "Please submit the form.";
}
?>
