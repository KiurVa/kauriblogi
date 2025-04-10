<?php
$data = false;
if (isset($_GET['sid']) && !empty($_GET['sid']) && is_numeric($_GET['sid'])) {
    $id = (int)$_GET['sid'];
    $sql = "SELECT * FROM blog WHERE id=$id";
    $data = $db->dbGetArray($sql);
}

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
                        <textarea name="preamble"  id="preamble" rows="3" maxlength="200" class="form-control" required><?= $db->htmlTextContent('preamble', $data) ?></textarea>
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