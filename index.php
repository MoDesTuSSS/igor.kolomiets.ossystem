<!doctype html>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Igor Kolomiets</title>
    <script src="libs/jquery-3.2.1.min.js"></script>
    <script src="js/script.js"></script>

</head>
<body>
<form id="formUpload" enctype="multipart/form-data" method="post" action='controller/file_convert.php'>
    <div>
        <input type="file" name="file" id="fi1e"/>
    </div>
    <div>
        Output type:
    </div>
    <div>
        <input type="radio" name="type" id="json" value="json"/><label for="json">json</label>
        <input type="radio" name="type" id="xml" value="xml"/><label for="xml">xml</label>
        <input type="radio" name="type" id="csv" value="csv"/><label for="csv">csv</label>
        <input type="radio" name="type" id="yml" value="yml"/><label for="yml">yml</label>
        <input type="submit" value="convert">
    </div>
</form>
</body>
</html>