<?php

try {
    $now = date('Y-m-d H:i:s');
    echo "script started at $now".PHP_EOL;
    $conn = new mysqli("localhost", "root", "root", "weather_site");

    // Check connection
    if ($conn->connect_error)
        die("Connection failed: " . $conn->connect_error);

    if ($conn) {
        $tbl = $conn->query("SELECT DeviceID,SensorFeatureID,SensorFeatureValue,SensorFeatureDate FROM sensor_feature_values ORDER BY id");

        $datetime = "";
        $deviceId = 0;
        $result = "";
        $i = 0;
        $inserts = 0;

        while($item = $tbl->fetch_assoc()) {
            $i++;
            if ($item["SensorFeatureValue"] != (-100)) {
                if ($datetime == $item["SensorFeatureDate"] && $deviceId == $item["DeviceID"]) {
                    $result .= ("!" . $item["SensorFeatureID"] . "&" . $item["SensorFeatureValue"]);
                } else {
                    $conn->query("INSERT INTO sensor_feature_values_compact(device_id,parameters_values,date_time) VALUES('$deviceId','$result','$datetime')");
                    $inserts++;

                    $result = $item["SensorFeatureID"] . "&" . $item["SensorFeatureValue"];
                    $datetime = $item["SensorFeatureDate"];
                    $deviceId = $item["DeviceID"];
                }
            }
        }

        $now = date('Y-m-d H:i:s');
        echo "script ended with $i iterations and $inserts inserts at $now.".PHP_EOL;
    }
} catch (Exception $exception) {
    echo $exception->getMessage();
}
