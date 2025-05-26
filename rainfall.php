<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rainfall.scot</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
    if (isset($_GET['station'])) {
        $station = htmlspecialchars($_GET['station']);
        if (($handle = fopen("stations.csv", "r")) !== FALSE) {
            $found = false;
            while (($data = fgetcsv($handle, 1000, ",", escape: "")) !== FALSE) {
                if (strtolower($data[0]) == strtolower($station)) {
                    $found = true;
                    break;
                }
            }
            fclose($handle);
        }
        if (!$found) {
            header("Location: /");
            exit();
        } else {
            $station = htmlspecialchars($data[0]);
        }
    } else {
        header("Location: /");
        exit();
    }
    $title = "Rainfall Data for " . $station;
    include "includes/nav.php";
    echo "<h1>$title</h1>";
    ?>
    <main>
    <?php
    # https://www2.sepa.org.uk/rainfall/api/Stations?csv=true
    # Timestamp,Value
    # 19/05/2025 10:00:00,0
    $row = 0;
    $rows = array();
    $results_by_month = array();
    $station_file_name = strtolower(str_replace(" ", "-", $station));

    if (($handle = fopen("data/$station_file_name.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",", escape: "")) !== FALSE) {
            if ($row++ == 0) {
                // Skip the header row
                continue;
            }
            $row++;
            // Process each row of data
            // For example, you can print the station name and item date
            // $rain_mm = floatval($data[1]);
            // $rain_mm_bar = $rain_mm * 1;
            // split
            $date_parts = explode(" ", $data[0]);
            $month = $date_parts[0];
            $year = $date_parts[1];

            $results_by_month[$month][$year] = $data[1];
        }
        $current_month = date("M");
        $months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

        // reverse every list in results by month
        foreach ($months as $month) {
            $years = $results_by_month[$month];
            $full_month_name = date("F", strtotime($month));
            $color = "white";
            if ($month == $current_month) {
                $color = "#cfc";
            }
            echo "<div style='padding: 0.25rem;'" . ($color != "white" ? "class='current-month'" : "") . "><h2>$full_month_name</h2>";
            echo "<table><thead><tr><th>Year</th><th>Rainfall (mm)</th></tr></thead><tbody>";
            $years = array_reverse($years, preserve_keys: true);
            $years = array_slice($years, 0, 3, preserve_keys: true);
            foreach ($years as $year => $value) {
                $value_px = floatval($value) / 1.5;
                echo "<tr><td>$year</td><td><span class='result-bar' style='width: $value_px" . "px; background-color: royalblue; height: 10px; display: inline-block;'></span> $value</td></tr>";
            }
            echo "</tbody></table></div>";
        }
        fclose($handle);
    }
    ?>
    </main>
    <footer>
        <p>Data sourced from the <a href="https://www2.sepa.org.uk/rainfall/DataDownload">Scottish Environment Protection Agency</a>.</p>
        <p>Made with 💜 by <a href="https://jamesg.blog">capjamesg</a>. <a href="https://github.com/capjamesg/rainfall.scot">View source</a>.</p>
    </footer>
</body>
</html>