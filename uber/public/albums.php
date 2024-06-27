
<?php
try {
    // ... (connection setup and fetching albums query)
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    // Fetch the latest album details
    $albumSql = "SELECT *
                 FROM albums
                 ORDER BY CreatedDate DESC
                 LIMIT 3";

    $albumResult = $connection->query($albumSql);

    // Check if tripalbums table has the correct column name (tripid)
    // Adjust the column name if needed
    $tripAlbumSql = "SELECT tripalbums.tripalbumid, albums.title AS album_title, trip.startlocation AS trip_startlocation
                     FROM tripalbums
                     LEFT JOIN albums ON tripalbums.albumid = albums.albumid
                     LEFT JOIN trip ON tripalbums.tid = trip.tid
                     ORDER BY tripalbums.tripalbumid DESC
                     LIMIT 3";

    $tripAlbumResult = $connection->query($tripAlbumSql);
    // Check if the query was successful
    if ($tripAlbumResult !== false) {
        // Fetch the results into an array
        $tripAlbumData = $tripAlbumResult->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Handle the case where the query failed
        $tripAlbumData = array(); // Initialize an empty array
    }

} catch (PDOException $error) {
    echo $error->getMessage();
}
?>


<?php require "templates/header.php"; ?>

<ul>
    <li><a href="createalbum.php"><strong>Create Album</strong></a> - add an album</li>
    <li><a href="albumread.php"><strong>Read Album</strong></a> - Read albums</li>
    <li><a href="update_album.php"><strong>Update Album</strong></a> - you can update your albums  </li>
</ul>

<h2>Latest Albums</h2>
<table>
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Created Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($albumResult as $albumRow): ?>
            <tr>
                <td><?php echo $albumRow['title']; ?></td>
                <td><?php echo $albumRow['description']; ?></td>
                <td><?php echo $albumRow['CreatedDate']; ?></td>
                <td><a href="album_details.php?album_id=<?php echo $albumRow['albumid']; ?>">View</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Modify the foreach loop to use $tripAlbumData -->
<h2>Latest Trip Albums</h2>
<table>
    <thead>
        <tr>
            <th>Trip Album ID</th>
            <th>Album Title</th>
            <th>Trip Start Location</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tripAlbumData as $tripAlbumRow): ?>
            <tr>
                <td><?php echo $tripAlbumRow['tripalbumid']; ?></td>
                <td><?php echo $tripAlbumRow['album_title']; ?></td>
                <td><?php echo $tripAlbumRow['trip_startlocation']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
