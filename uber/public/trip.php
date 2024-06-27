<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "startlocation" => $_POST['startlocation'],
            "endlocation"  => $_POST['endlocation'],
            "distance"     => $_POST['distance'],
            "currentlocation"  => $_POST['currentlocation']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "trip",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit3']) && $statement) { ?>
    <blockquote><?php echo $_POST['startlocation']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add a trip details</h2>

<form method="post">
    <label for="startlocation">Start location</label>
    <input type="text" name="startlocation" id="startlocation">
    <label for="endlocation">End location</label>
    <input type="text" name="endlocation" id="endlocation">
    <label for="distance">Distance</label>
    <input type="number" name="distance" id="distance">
    <label for="currentlocation">Current Location</label>
    <input type="text" name="currentlocation" id="currentlocation">
    <input type="submit" name="submit" value="Submit3">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
