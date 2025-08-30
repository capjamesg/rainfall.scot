<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.html" ?>
<body>
    <?php $title = "All Stations";
        include "./includes/nav.php"; ?>
    <section id="home">
        <h1>rainfall.scot</h1>
        <p>Search for rainfall by month at your nearest station.</p>
        <p>You can <a href="https://www2.sepa.org.uk/rainfall/RainfallInformation">find your nearest station on the SEPA website.</a></p>
        <search>
            <form action="rainfall.php" method="get">
                <input type="text" id="station" name="station" placeholder="e.g. Harelaw">
                <input type="submit" value="Search">
            </form>
        </search>
        <p>You can also select a station below:</p>
        <ul style="columns: 3;">
            <?php
            if (($handle = fopen("stations.csv", "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",", escape: "")) !== FALSE) {
                    // skip header
                    if ($data[0] == "station_name") {
                        continue;
                    }
                    echo "<li><a href='rainfall.php?station=" . htmlspecialchars($data[0]) . "'>" . htmlspecialchars($data[0]) . "</a></li>";
                }
                fclose($handle);
            }
            ?>
        </ul>
    </section>
    <?php include "./includes/footer.php" ?>
</body>
</html>