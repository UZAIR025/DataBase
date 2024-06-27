<?php
try {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    if (isset($_POST['submit'])) {
        $selectedTable = $_POST['selected_table'];
        $selectedAttribute = $_POST['selected_attribute'];
        $newValue = $_POST['new_value'];

        // Validate input
        if (!in_array($selectedTable, ['customer', 'driver', 'trip', 'vehicle'])) {
            $errorMessage = "Invalid table selected.";
        } elseif (empty($selectedAttribute) || empty($newValue)) {
            $errorMessage = "Attribute and new value must not be empty.";
        } else {
            try {
                $connection->beginTransaction();

                // Step 1: Create an index for the selected attribute
                $indexName = "idx_" . $selectedTable . "_" . $selectedAttribute;
                $createIndexSql = "CREATE INDEX IF NOT EXISTS $indexName ON $selectedTable ($selectedAttribute)";
                $connection->exec($createIndexSql);

                // Step 2: Insert a new entity
                $insertSql = "INSERT INTO $selectedTable (column1, column2) VALUES (:value1, :value2)";
                $insertStatement = $connection->prepare($insertSql);
                $insertSuccess = $insertStatement->execute(array(':value1' => $value1, ':value2' => $value2));

                if ($insertSuccess) {
                    // Get the inserted entity ID
                    $entityId = $connection->lastInsertId();

                    // Step 3: Update the relationship table (adjust table and column names)
                    $updateSql = "UPDATE tripalbums SET selected_attribute = :new_value WHERE tripid = :entityId";
                    $updateStatement = $connection->prepare($updateSql);
                    $updateSuccess = $updateStatement->execute(array(':new_value' => $newValue, ':entityId' => $entityId));

                    if ($updateSuccess) {
                        // Commit the transaction if both steps are successful
                        $connection->commit();
                        $successMessage = "Data added and updated successfully!";
                    } else {
                        // Rollback the transaction if the update fails
                        $connection->rollBack();
                        $errorMessage = "Error: Data update failed.";
                    }
                } else {
                    // Rollback the transaction if the insert fails
                    $connection->rollBack();
                    $errorMessage = "Error: Data insertion failed.";
                }
            } catch (PDOException $error) {
                // Handle any exceptions or errors here
                $connection->rollBack();
                $errorMessage = "Error: " . $error->getMessage();
            }
        }
    }
} catch (PDOException $error) {
    $errorMessage = "Database error: " . $error->getMessage();
}
?>

<?php require "templates/header.php"; ?>

<form method="post">
    <label for="selected_table">Select Table:</label>
    <select name="selected_table" id="selected_table">
        <option value="customer">Customer</option>
        <option value="driver">Driver</option>
        <option value="trip">Trip</option>
        <option value="vehicle">Vehicle</option>
    </select>
    <br>

    <label for="selected_attribute">Select Attribute:</label>
    <input type="text" name="selected_attribute" id="selected_attribute">
    <br>

    <label for="new_value">New Value:</label>
    <input type="text" name="new_value" id="new_value">
    <br>

    <input type="submit" name="submit" value="Update">
</form>

<!-- Display success or error message -->
<?php if (!empty($successMessage)): ?>
    <p style="color: green;"><?php echo $successMessage; ?></p>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <p style="color: red;"><?php echo $errorMessage; ?></p>
<?php endif; ?>

<a href="albums.php">Back to album page</a>

<?php require "templates/footer.php"; ?>
