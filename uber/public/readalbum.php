<?php


try  {
    require "../config.php";
    require "../common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT *
                    FROM trip
                    ORDER BY tid DESC
                    LIMIT 3";

    $result = $connection->query($sql);

} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>


<?php require "templates/header.php"; ?>

<?php
    if ($result && $result->rowCount() > 0) { ?>
        <h2>Albums details </h2>

        <table>
            <thead>
                <tr>
                    <th>Start Location</th>
                    <th>end Location</th>
                    <th>Distance(KM)</th>
                    <th>Current Location</th>
                    <th>Travel Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["startlocation"]); ?></td>
                <td><?php echo escape($row["endlocation"]); ?></td>
                <td><?php echo escape($row["distance"]); ?></td>
                <td><?php echo escape($row["currentlocation"]); ?></td>
                <td><?php echo escape($row["date"]); ?></td>
                <td><a href="viewtripdetails.php?tid=<?php echo escape($row["tid"]); ?>">View</a></td>

            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>No results found.</blockquote>
    <?php }
?>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
