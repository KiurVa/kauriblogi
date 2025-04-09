<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //$db->show($_POST); //Näita vormi andmeid
    //$db->show($_FILES); //Näita faili infot

    // Tekstiväljade olemasolu ja tühjuse kontroll
    $heading = trim($_POST["heading"] ?? '');
    $preamble = trim($_POST["preamble"] ?? '');
    $context = trim($_POST["context"] ?? '');
    $tags = trim($_POST["tags"] ?? '');

    $errors = []; //Tühja listi loomine

    if ($heading === '') {
        $errors[] = "Pealkiri on kohustuslik.";
    }
    if ($preamble === '') {
        $errors[] = "Sissejuhatav tekst on kohustuslik.";
    }
    if ($context === '') {
        $errors[] = "Põhitekst on kohustuslik.";
    }
    if ($tags === '') {
        $errors[] = "Kategooria(d) on kohustuslik.";
    }

    // Faili olemasolu ja kontroll
    if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Pildi üleslaadmine ebaõnnestus või on see puudu.";
    } else {
        $image = $_FILES['photo'];
        //Failinime normaliseerimine
        $origName = basename($image['name']); //ainult nimi.laiend (flower.jpg)
        $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION)); //faililaiend

        //$db->show($image);
        //echo $origName;
        //echo $ext;
        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp']; // Lubatud pildifailid
        if (!in_array($ext, $allowed)) {
            $errors[] = "Lubatud on ainult pildifailid: " . implode(', ', $allowed);
        }

        $normalizedName = preg_replace('/[^a-z0-9_\-\.]/i', '_', pathinfo($origName, PATHINFO_FILENAME));
        $filename = $normalizedName . '_' . time() . '.' . $ext;
    }
    // Kui vigu pole, siis töötle ja salvesta
    if (empty($errors)) {
        $heading = htmlspecialchars($heading);
        $preamble = htmlspecialchars($preamble);
        $context = htmlspecialchars($context);
        $tags = htmlspecialchars($tags);

        $uploadPath = UPLOAD_IMAGES . $filename; //images/lilled.png
        move_uploaded_file($image['tmp_name'], $uploadPath); // Tösta tmp kaustast soovitud kohta

        //SQL lause andmebaasi lisamiseks
        $sql = "INSERT INTO blog (heading, preamble, context, tags, photo) VALUES (
            '" . $db->dbFix($heading) . "',
            '" . $db->dbFix($preamble) . "',
            '" . $db->dbFix($context) . "',
            '" . $db->dbFix($tags) . "',
            '" . $db->dbFix($uploadPath) . "')";
        //echo $sql; //Väljastab sql lause(TEST)
        if($db->dbQuery($sql)) {
            echo "<div class='alert alert-success'>Postitus lisatud!</div>";
        }else {
            echo "<div class='aler alert-danger'>Postitus ei lisatud!</div>";
        }
    } else {
        //leiti vigu ($errors)
        echo "<div class='alert alert-danger'><ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul></div>";
    }
}
?>
<div class="row m-1">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card p-2 shadow">
            <h2 class="text-center">Uus postitus</h2>
            <form action="?page=post_add" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="heading" class="form-label fw-bold">Pealkiri</label>
                    <input type="text" name="heading" id="heading" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="preamble" class="form-label fw-bold">Sissejuhatus</label>
                    <textarea name="preamble" id="preamble" rows="3" maxlength="200" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="context" class="form-label fw-bold">Põhitekst</label>
                    <textarea name="context" id="context" rows="3" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="tags" class="form-label fw-bold">Sildid</label>
                    <input type="text" name="tags" id="tags" class="form-control" placeholder="Eralda komadega" required maxlength="50">
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label fw-bold">Pilt</label>
                    <input type="file" name="photo" id="photo" class="form-control" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-danger">Tühjenda vorm</button>
                    <button type="submit" class="btn btn-success">Sisesta postitus</button>
                </div>
            </form>
        </div>
    </div>
</div>