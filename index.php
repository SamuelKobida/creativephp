<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Creative PHP</title>
    <style>
    </style>
</head>
<body>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" id="FileInput" name="file">
    <label for="FileInput">Select File:</label>
    <input type="submit" name="submit" value="upload">
</form>

<?php
if (isset($_GET['message'])) {
    $message = urldecode($_GET['message']);
    echo "<p>$message</p>";
}
?>

</body>
</html>
