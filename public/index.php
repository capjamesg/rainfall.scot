<!DOCTYPE html>
<html lang="en">
<?php include "includes/head.html" ?>
<body>
    <?php $title = "All Stations";
        include "../includes/nav.php"; ?>
    <section id="home">
        <h1>rainfall.scot</h1>
        <p>Search for rainfall by month at your nearest station:</p>
        <search>
            <form action="rainfall.php" method="get">
                <input type="text" id="station" name="station" placeholder="e.g. Harelaw">
                <input type="submit" value="Search">
            </form>
        </search>
    </section>
</body>
</html>