<?php
// make http request to https://www2.sepa.org.uk/rainfall/api/Stations?json=true&all=true
$base_url = "https://www2.sepa.org.uk/rainfall/api/";
$station_list = file_get_contents("$base_url/Stations?json=true&all=true", 
    context: stream_context_create([
        "http" => [
            "method" => "GET",
            "header" => "Accept: application/json\r\n"
        ]
    ])
);
// coalesce as json
$station_list = json_decode($station_list, true);
foreach ($station_list as $station => $values) {
    $station_no = $values['station_no'];
    $station_name = strtolower($values['station_name']);
    $station = str_replace(" ", "-", $station_name);
    $station_data = file_get_contents("$base_url/Month/$station_no?csv=true", 
        context: stream_context_create([
            "http" => [
                "method" => "GET",
                "header" => "Accept: text/csv\r\n"
            ]
        ])
    );
    // save to data/$station.csv
    if (!is_dir("data")) {
        mkdir("data", 0777, true);
    }
    file_put_contents("data/$station_name.csv", $station_data);
    // break;
}
?>