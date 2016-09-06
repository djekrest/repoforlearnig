<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit product</title>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
<?php
require 'configs/db_access.php';

$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if ( $id==null ) {
    header("Location: index.php");
}

if ( !empty($_POST)) {
    // keep track validation errors
    $nameError = $descriptionError = $name = $description = null;

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    $valid = true;
    if (empty($_POST["name"])) {
        $nameError = 'Please enter Name';
        $valid = false;
    } else{
        $name = test_input($_POST["name"]);
        if (strlen($name) > 255){
            $nameError = 'Name is too long (Max count 255)';
            $valid = false;
        }
    }

    if (empty($_POST['description'])) {
        $descriptionError = 'Please enter description';
        $valid = false;
    } else {
        $description = test_input($_POST['description']);
        if (strlen($description) > 255){
            $descriptionError = 'Description is too long (Max count 255)';
            $valid = false;
        }
    }



    if ($valid) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE products  set name = ?, description = ? WHERE id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($name,$description,$id));
        Database::disconnect();
        header("Location: index.php");
    }
} else {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM products where id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $data = $q->fetch(PDO::FETCH_ASSOC);
    $name = $data['name'];
    $description = $data['description'];
    Database::disconnect();
}
?>
</head>

<body>

<div class="container">

    <div class="span10 offset1">
        <div class="row">
            <h3>Add product</h3>
        </div>

        <form class="form-horizontal" action="edits.php?id=<?php echo $id?>" method="post">
            <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                <label class="control-label">Name</label>
                <div class="controls">
                    <input name="name" type="text"  placeholder="Name" value="<?php echo $name;?>">
                    <?php if (!empty($nameError)): ?>
                        <span class="help-inline"><?php echo $nameError;?></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
                <label class="control-label">Description</label>
                <div class="controls">
                    <input name="description" type="text" placeholder="Description" value="<?php echo $description;?>">
                    <?php if (!empty($descriptionError)): ?>
                        <span class="help-inline"><?php echo $descriptionError;?></span>
                    <?php endif;?>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-success">Update</button>
                <a class="btn" href="index.php">Back</a>
            </div>
        </form>
    </div>

</div>
</body>

</html>
