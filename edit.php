<?php
include('config/db_connect.php');

$todo = null;
$error = '';

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $sql = "SELECT * FROM `todo` WHERE `id` = '$id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $todo = mysqli_fetch_assoc($result);
        } else {
            $error = 'No todo item found with that ID.';
        }
    }

    if (isset($_POST['edit_todo'])) {
        $new_title = mysqli_real_escape_string($conn, $_POST['new_title']);
        $new_description = mysqli_real_escape_string($conn, $_POST['new_description']);

        $sql = "UPDATE `todo` SET `title` = '$new_title', `description` = '$new_description' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            header('Location: index.php');
        } else {
            $error = 'Query Error: ' . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles\style.css">
</head>
<body>

<?php include('./templates/header.php'); ?>

<main>
    <div class="edit-form">
        <?php if ($todo): ?>
            <form action="edit.php?id=<?php echo $todo['id']; ?>" method="POST">
                <label for="new_title">New Title:</label>
                <input type="text" id="new_title" name="new_title" value="<?php echo htmlspecialchars($todo['title']); ?>">
                <label for="new_description">New Description:</label>
                <textarea id="new_description" name="new_description"><?php echo htmlspecialchars($todo['description']); ?></textarea>
                <input type="submit" name="edit_todo" value="Save Changes">
            </form>
        <?php elseif ($error): ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
    </div>
</main>

<?php include('./templates/footer.php'); ?>

</body>
</html>
