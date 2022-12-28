<!DOCTYPE html>
<html>
<head>
  <title>SW RP</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<script>
<?php
$html = file_get_contents("https://freelance.habr.com/tasks");
$html2 = "<html>";
echo "console.log('" . $html . "');";
?>
</script>
</body>
</html>
