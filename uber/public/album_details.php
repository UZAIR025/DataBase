<?php
require "../config.php";
require "../common.php";

// Check if the album ID is provided in the URL
if (isset($_GET['album_id'])) {
    $albumId = $_GET['album_id'];

    try {
        $connection = new PDO($dsn, $username, $password, $options);

        // Fetch album details by ID
        $sql = "SELECT * FROM albums WHERE albumid = :albumId";
        $statement = $connection->prepare($sql);
        $statement->execute(array(':albumId' => $albumId));
        $albumDetails = $statement->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $error) {
        echo $error->getMessage();
    }
} else {
    // Redirect to the album list page if no album ID is provided
    header("Location: albumread.php");
    exit;
}
?>

<?php require "templates/header.php"; ?>

<h2>Album Details</h2>
<table>
    <tr>
        <th>Title</th>
        <td><?php echo $albumDetails['title']; ?></td>
    </tr>
    <tr>
        <th>Description</th>
        <td><?php echo $albumDetails['description']; ?></td>
    </tr>
    <tr>
        <th>Created Date</th>
        <td><?php echo $albumDetails['CreatedDate']; ?></td>
    </tr>
</table>

<a href="albums.php">Back to Albums</a>

<?php require "templates/footer.php"; ?>
