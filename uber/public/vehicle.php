<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit2'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $new_user = array(
            "vehiclename" => $_POST['vehiclename'],
            "fType"  => $_POST['fType'],
            "ac"     => $_POST['ac'],
            "humancapacity"       => $_POST['humancapacity'],
            "vehiclenumber"  => $_POST['vehiclenumber']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "vehicle",
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

<?php if (isset($_POST['submit2']) && $statement) { ?>
    <blockquote><?php echo $_POST['vehiclenumber']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add a Vehicle Details</h2>

<form method="post">
    <label for="vehiclename">Vehicle Type</label>
    <input type="text" name="vehiclename" id="vehiclename">
    <label for="fType">Feual  Type</label>
    <input type="text" name="fType" id="fType">
    <label for="ac">Air Condition</label>
    <input type="text" name="ac" id="ac">
    <label for="humancapacity">Human capacity</label>
    <input type="number" name="humancapacity" id="humancapacity">
    <label for="vehiclenumber">vehicle Number</label>
    <input type="text" name="vehiclenumber" id="vehiclenumber">
    <input type="submit" name="submit2" value="submit2">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
