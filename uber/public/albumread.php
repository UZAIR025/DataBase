<?php
require "../config.php";
require "../common.php";

try {
    $connection = new PDO($dsn, $username, $password, $options);
    
    // SQL query to retrieve album data
    $sql = "SELECT * FROM albums";
    
    $result = $connection->query($sql);
    
} catch (PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Albums</title>
</head>
<body>
    <h2>Albums</h2>
    
    <?php if ($result && $result->rowCount() > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Album ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Created Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo escape($row["albumid"]); ?></td>
                        <td><?php echo escape($row["title"]); ?></td>
                        <td><?php echo escape($row["description"]); ?></td>
                        <td><?php echo escape($row["CreatedDate"]); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No albums found</p>
    <?php endif; ?>
</body>
</html>


<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>