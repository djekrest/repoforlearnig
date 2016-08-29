<!DOCTYPE html>
<html lang="en">
<head>
    <title>Learn PHP</title>
    <meta charset="utf-8">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
<div class="container">
    <div class="row">
        <h3>Products List</h3>
    </div>
    <div class="row">
        <p>
            <a href="add.php" class="btn btn-success">Create</a>
        </p>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            include 'configs/db_access.php';
            $pdo = Database::connect();
            $sql = 'SELECT * FROM products ORDER BY id DESC';
            foreach ($pdo->query($sql) as $row) {
                echo '<tr>';
                echo '<td>'. $row['name'] . '</td>';
                echo '<td>'. $row['description'] . '</td>';
                echo '<td width=250>';
                echo '<a class="btn btn-success" href="edits.php?id='.$row['id'].'">Update</a>';
                echo ' ';
                echo '<a class="btn btn-danger" href="delete.php?id='.$row['id'].'">Delete</a>';
                echo '</td>';
                echo '</tr>';
            }
            Database::disconnect();
            ?>
            </tbody>
        </table>
    </div>
</div> <!-- /container -->
</body>
</html>