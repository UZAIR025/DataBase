<?php
    if (isset($_GET['tid'])) {
        require "../config.php";
        require "../common.php";

        try {
            $connection = new PDO($dsn, $username, $password, $options);

            $tid = $_GET['tid'];

            if (isset($_POST['submit'])) {
                $newstartlocation = $_POST['newstartlocation'];
                $newendlocation = $_POST['newendlocation'];
                $newdistance = $_POST['newdistance'];

                $sql = "UPDATE trip
                        SET startlocation = :newstartlocation,
                            endlocation = :newendlocation,
                            distance = :newdistance
                        WHERE tid = :tid";

                $statement = $connection->prepare($sql);
                $statement->bindValue(':newstartlocation', $newstartlocation);
                $statement->bindValue(':newendlocation', $newendlocation);
                $statement->bindValue(':newdistance', $newdistance);
                $statement->bindValue(':tid', $tid);
                $statement->execute();

                header("Location: viewtripdetails.php?tid=$tid");

            }

            $sql = "SELECT * FROM trip WHERE tid = :tid";
            $statement = $connection->prepare($sql);
            $statement->bindValue(':tid', $tid);
            $statement->execute();

            $trip = $statement->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    } else {
        echo "Trip ID not specified.";
        exit;
    }
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['startlocation']; ?> successfully edited.</blockquote>
<?php } ?>

<h2>Edit a Trip</h2>

<form method="post">
    <label for="newstartlocation">Start location</label>
    <input type="text" name="newstartlocation" id="newstartlocation">
    <label for="newendlocation">End location</label>
    <input type="text" name="newendlocation" id="newendlocation">
    <label for="newdistance">Trip Distance</label>
    <input type="number" name="newdistance" id="newdistance">
    <input type="submit" name="submit" value="Save">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>