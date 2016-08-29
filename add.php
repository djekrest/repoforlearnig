<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add product</title>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>

    <?php

    require 'configs/db_access.php';

    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $descriptionError = null;


        // keep track post values
        $name = $_POST['name'];
        $description = $_POST['description'];


        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }

        if (empty($description)) {
            $descriptionError = 'Please enter description';
            $valid = false;
        }


        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO products (name,description) values(?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name,$description));
            Database::disconnect();
            header("Location: index.php");
        }
    }
    ?>

</head>

<body>

<div class="container">

    <div class="span10 offset1">
        <div class="row">
            <h3>Add product</h3>
        </div>

        <form class="form-horizontal" action="add.php" method="post">
            <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                <label class="control-label">Name</label>
                <div class="controls">
                    <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                    <?php if (!empty($nameError)): ?>
                        <span class="help-inline"><?php echo $nameError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
                <label class="control-label">Description</label>
                <div class="controls">
                    <input name="description" type="text" placeholder="Description" value="<?php echo !empty($description)?$description:'';?>">
                    <?php if (!empty($descriptionError)): ?>
                        <span class="help-inline"><?php echo $descriptionError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Create</button>
                <a class="btn" href="index.php">Back</a>
            </div>
        </form>
    </div>

</div>
</body>

</html>

