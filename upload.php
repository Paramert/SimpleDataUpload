<?php

// Getting parameters from the request
// You can change the number or name of requests
//type: GET. You can change on the POST
$nick = $_GET['nick'];
$UID = $_GET['UID'];
$id = $_GET['id'];
$data = $_GET['data'];
$used_massage = isset($_GET['used_massage']) ? $_GET['used_massage'] : '';
$city = $_GET['city'];

// Creating a data object
// Synchronize with the parameters above
$data_object = array(
    'Session' => uniqid(),
    'nick' => $nick,
    'UID' => $UID,
    'id' => $id,
    'data' => $data,
    'used_massage' => $used_massage,
    'city' => $city
);

// Reading the current data from the file
$current_data = file_get_contents('database.json');

// Decode the JSON string into an array
$current_data_array = json_decode($current_data, true);

// Looking for a data object with the same ID
$existing_data = null;
foreach ($current_data_array as $index => $item) {
    if ($item['id'] == $id) {
        $existing_data = $item;
        break;
    }
}

// If a data object with the same ID is found, add a new used_massage to the used_massage_2 array
if ($existing_data) {
    if (isset($existing_data['used_massage_2'])) {
        $existing_data['used_massage_2'][] = $used_massage;
    } else {
        $existing_data['used_massage_2'] = array($used_massage);
    }
    $current_data_array[$index] = $existing_data;
} else {
    // Adding a new data object to the array
    $current_data_array[] = $data_object;
}

// Encoding the array into a JSON string with indents and line breaks
$json_data = json_encode($data_object['Session']);

// Writing data to a file
file_put_contents('database.json', json_encode($current_data_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// We return the response with the generated UID
echo $json_data;

?>