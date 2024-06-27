<?php

if (isset($_GET['tid'])) {
    try  {

        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT *
                        FROM trip
                        WHERE tid = :tid";

        $tid = $_GET['tid'];

        $statement = $connection->prepare($sql);
        $statement->bindValue(':tid', $tid);
        $statement->execute();

        $trip = $statement->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>


<?php require "templates/header.php"; ?>

<?php
    if ($trip) { ?>
        <h2>Trip Details</h2>
        <p><b>User ID</b>: <?php echo escape($trip["tid"]); ?></p>
        <p><b>Current Location</b>: <?php echo escape($trip["currentlocation"]); ?></p>
        <p><b>Distance (KM) </b>: <?php echo escape($trip["distance"]); ?></p>
        <p><b>Trip Date </b>: <?php echo escape($trip["date"]); ?></p>

    <?php } else { ?>
        <blockquote>No results found for <?php echo escape($_GET['tid']); ?>.</blockquote>
    <?php }
?>

<a href="edittrip.php?tid=<?php echo escape($trip["tid"]); ?>">Edit Trip</a><br>
<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
