<?php
// Get the values of the GET parameters
$slackName = $_GET['slack_name'] ?? '';
$day = $_GET['day'] ?? '';
$track = $_GET['track'] ?? '';
$fileUrl = $_GET['file_url'] ?? '';
$sourceCodeUrl = $_GET['source_code_url'] ?? '';
$statusCode = $_GET['status_code'] ?? '';

// Validate the 'day' parameter
$validDays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
if (!in_array($day, $validDays)) {
    echo json_encode(['error' => 'Invalid day parameter.']);
    exit;
}

// Get the current UTC time
$currentUtcTime = gmdate('Y-m-d H:i:s', time());

// Validate the time within +/-2 hours
$currentTime = strtotime($currentUtcTime);
$twoHoursAgo = strtotime('-2 hours');
$twoHoursLater = strtotime('+2 hours');

if ($currentTime < $twoHoursAgo || $currentTime > $twoHoursLater) {
    echo json_encode(['error' => 'Current time is not within +/-2 hours of UTC time.']);
    exit;
}

// Prepare the response
$response = [
    'slack_name' => $slackName,
    'day' => $day,
    'current_utc_time' => $currentUtcTime,
    'track' => $track,
    'file_url' => $fileUrl,
    'source_code_url' => $sourceCodeUrl,
    'status_code' => $statusCode,
];

// Set the content type to JSON
header('Content-Type: application/json');

// Output the JSON response
echo json_encode($response);
