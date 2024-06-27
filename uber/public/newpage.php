<?php
require "../config.php";
require "../common.php";

$tripSelectOptions = ""; // Initialize the trip options variable
$successMessage = "";   // Initialize the success message variable

try {
    $connection = new PDO($dsn, $username, $password, $options);
    
    // Begin a MySQL transaction
    $connection->beginTransaction();

    // Check if the form has been submitted
    if (isset($_POST['submit'])) {
        // Get form input values
        $title = $_POST['title'];
        $description = $_POST['description'];

        // Insert data into the "albums" table
        $sql = "INSERT INTO albums (title, description) VALUES (:title, :description)";
        $statement = $connection->prepare($sql);
        $success = $statement->execute(array(':title' => $title, ':description' => $description));

        // Check if data was inserted successfully
        if ($success) {
            // Get the newly inserted album ID
            $albumId = $connection->lastInsertId();

            // Associate selected trips with the album
            if (!empty($_POST['selected_trips'])) {
                foreach ($_POST['selected_trips'] as $tripId) {
                    $sql = "INSERT INTO tripalbums (albumid, tid) VALUES (:albumId, :tripId)";
                    $statement = $connection->prepare($sql);
                    $statement->execute(array(':albumId' => $albumId, ':tripId' => $tripId));
                }
            }

            // Commit the transaction if all operations were successful
            $connection->commit();

            // Set success message
            $successMessage = "Data added successfully!";
        } else {
            // Rollback the transaction if any operation failed
            $connection->rollBack();

            // Set an error message if data insertion failed
            $errorMessage = "Error: Data insertion failed.";
        }
    }

    // Fetch trips for the select dropdown
    $sql = "SELECT * FROM trip";
    $result = $connection->query($sql);

    if ($result->rowCount() > 0) {
        foreach ($result as $row) {
            $tripId = $row["tid"];
            $tripName = escape($row["startlocation"]);

            // Append each trip as an option
            $tripSelectOptions .= "<option value='$tripId'>$tripName</option>";
        }
    } else {
        $tripSelectOptions = "<option value='0'>No trips available</option>";
    }
} catch (PDOException $error) {
    // Handle any database errors and roll back the transaction if needed
    $connection->rollBack();
    echo $sql . "<br>" . $error->getMessage();
}
?>


<?php require "templates/header.php"; ?>

<!-- HTML form -->
<form method="post">
    <label for="title">Album Title</label>
    <input type="text" name="title" id="title">

    <label for="description">Album Description</label>
    <input type="text" name="description" id="description">

    <h4>Select trips for the album (hold Ctrl/Cmd to select multiple)</h4>

    <label for="selected_trips[]">Select Trips</label>
    <select name="selected_trips[]" id="selected_trips" multiple>
        <?php echo $tripSelectOptions; ?>
    </select>

    <input type="submit" name="submit" value="Submit">
</form>

<!-- Display success or error message -->
<?php if (!empty($successMessage)): ?>
    <p style="color: green;"><?php echo $successMessage; ?></p>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <p style="color: red;"><?php echo $errorMessage; ?></p>
<?php endif; ?>


<a href="index.php">Back to home</a>
<?php require "templates/footer.php"; ?>
