<?php
include("include/settings.php"); //Lae seaded
include("include/mysqli.php"); //Lae andmebaasi klass
$db = new Db(); // Loo andmebaasi objekt

$page = isset($_GET["page"]) ? $_GET["page"] : "homepage";
$allowed_pages = ["homepage", "blog", "contact", "post", "post_add", "post_edit", "edit"];
if (!in_array($page, $allowed_pages)) {
  $page = "homepage";
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>KauriBlogi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>

<body>
  <div class="container">
    <?php include 'navbar.html'; ?>
  </div>

  <div class="container">
    <?php include("$page.php"); ?>
  </div>


















  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>