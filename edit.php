<?php
$data = false;
if (isset($_GET['sid']) && !empty($_GET['sid']) && is_numeric($_GET['sid'])) {
    $id = (int)$_GET['sid'];
    $sql = "SELECT * FROM blog WHERE id=$id";
    $data = $db->dbGetArray($sql);

    if (isset($_GET['update']) && $_GET['update'] == 'true' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        //$db->show($_POST); //VOrmilt mis on lehel andmed. form
        //$db->show($_FILES); //Pildi andmed, kui on uus pilt
        // Tekstiväljade olemasolu ja tühjuse kontroll
        $heading = trim($_POST["heading"] ?? '');
        $preamble = trim($_POST["preamble"] ?? '');
        $context = trim($_POST["context"] ?? '');
        $tags = trim($_POST["tags"] ?? '');
        $oldPhoto = $_POST['oldPhoto'];
        $photoUpdate = '';

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['photo'];
            //Failinime normaliseerimine
            $origName = basename($image['name']); //ainult nimi.laiend (flower.jpg)
            $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION)); //faililaiend

            //$db->show($image);
            //echo $origName;
            //echo $ext;
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp']; // Lubatud pildifailid
            if (!in_array($ext, $allowed)) {
                echo "Lubatud on ainult pildifailid: " . implode(', ', $allowed);
            } else {
                $normalizedName = preg_replace('/[^a-z0-9_\-\.]/i', '_', pathinfo($origName, PATHINFO_FILENAME));
                $filename = $normalizedName . '_' . time() . '.' . $ext;
                $targetFile = UPLOAD_IMAGES . $filename;
                // faili salvestamine
                if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                    // Kustuta vana fail
                    if (!empty($oldPhoto) && file_exists($oldPhoto)) {
                        unlink($oldPhoto);
                        // Lsa uuendatava kirje juurde uus faili tee
                        $photoUpdate = ", photo = '" . $db->dbFix($targetFile) . "'"; // SQL lause osa
                    } else {
                        echo "Pildi üleslaadimine ebaõnnestus!";
                    }
                } // mode_upload_file
            } // !in_array


        } //isset($_FILES)
        //SQL lause uuendamiseks
        $sql = "UPDATE blog SET
                heading = '" . $db->dbFix($heading) . "',
                preamble = '" . $db->dbFix($preamble) . "',
                context = '" . $db->dbFix($context) . "',
                tags = '" . $db->dbFix($tags) . "'
                $photoUpdate WHERE id = $id";

        //echo $sql; //TEST
        if ($db->dbQuery($sql)) {
            echo "Postitus on edukalt uuendatud";
        } else {
            echo "Midagi läks uuendamisega valesti.";
        }
        header("Location: index.php?page=post_edit");
        exit;
    } // isset($_GET['update']
} // (isset($_GET['sid'

?>


<div class="row m-1">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <?php
        if ($data !== false) {
            $data = $data[0];
        ?>
            <!-- SIIA KOGU HTML OSA -->
            <div class="card p-2 shadow">
                <h2 class="text-center">Muuda postitus</h2>
                <form action="?page=edit&sid=<?= $data['id']; ?>&update=true" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="heading" class="form-label fw-bold">Pealkiri</label>
                        <input type="text" name="heading" <?= $db->htmlValue('heading', $data) ?> id="heading" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="preamble" class="form-label fw-bold">Sissejuhatus</label>
                        <textarea name="preamble" id="preamble" rows="3" maxlength="200" class="form-control" required><?= $db->htmlTextContent('preamble', $data) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="context" class="form-label fw-bold">Põhitekst</label>
                        <textarea name="context" id="context" rows="3" class="form-control" required><?= $db->htmlTextContent('context', $data) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="tags" class="form-label fw-bold">Sildid</label>
                        <input type="text" name="tags" <?= $db->htmlValue('tags', $data) ?> id="tags" class="form-control" placeholder="Eralda komadega" required maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label fw-bold">Pilt</label>
                        <div><a href="<?= $data['photo']; ?>" target="_blank"><img src="<?= $data['photo'] ?>" alt="Pilt" class="img-thumbnail" width="200"></a>
                        <a href="<?= $data['photo']; ?>" target="popup" onclick="window.open('<?= $data['photo']; ?>','name','width=600,height=400')"><img src="<?= $data['photo'] ?>" alt="Pilt" class="img-thumbnail" width="200"></a></div>
                        <input type="file" name="photo" id="photo" class="form-control">
                    </div>
                    <div class="d-flex justify-content-between">
                        <input type="hidden" name="oldPhoto" <?= $db->htmlValue('photo', $data); ?>>
                        <button type="reset" class="btn btn-danger">Tühjenda vorm</button>
                        <button type="submit" class="btn btn-success">Muuda postitust</button>
                    </div>
                </form>
            </div>
        <?php
        } else {
            echo "Sobivat postitust ei leitud!";
        }
        ?>

    </div>
</div>