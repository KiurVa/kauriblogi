<?php
if (isset($_GET['sid']) && is_numeric($_GET['sid'])) {
  $id = (int)$_GET['sid']; //Võtame url id väärtuse teges täisarvuks
  $sql = "SELECT *, DATE_FORMAT(added, '%d.%m.%Y %H:%i:%s') as adding FROM blog WHERE id = " . $id;
  $data = $db->dbGetArray($sql);

  if ($data !== false) {
    $val = $data[0];


    //$db->show($val);

?>

    <div class="row m-0">
      <div class="col-md fw-bold fs-1 text-center">
        <?= $val['heading']; ?>
      </div>
    </div>

    <div class="row mt-1">
      <div class="col-md text-muted fw-bold fs-4 text-center"><?= $val['adding']; ?></div>
    </div>

    <div class="mt-4 text-center">
      <strong>Märksõnad:</strong>
      <span class="me-1"><?php
                          $tags = array_map('trim', explode(",", $val['tags'])); // Tükelda sildid komast
                          //$db->show($tags); //TEST
                          $links = []; //Tühi linkide list
                          foreach ($tags as $tag) {
                            $safeTag = htmlspecialchars($tag); // Turvaline HTML
                            $links[] = "<a href=''>{$safeTag}</a>"; //Lisa listi
                          }
                          $result = implode(", ", $links); //Ühenda listi elemendid
                          echo $result // väljasta tulemus
                          //$db->show($links); //TEST
                          ?></span>
    </div>

    <div class="row mt-4 justify-content-center">
      <div class="col-md-8">
        <div class="text-center mb-3">
          <img
            src="<?= $val['photo']; ?>"
            class="img-thumbnail"
            width="650"
            alt="Fist up" />
        </div>

        <div>
          <?= $val['context']; ?>
        </div>

        <div class="m-4 d-flex justify-content-end">
          <a href="?page=post2" class="btn btn-outline-primary">Järgmine postitus &raquo;</a>
        </div>
      </div>
    </div>
  <?php
  } else {
  ?>
    <h4>Viga</h4>
    <p>Sellist postitust ei ole.!</p>
  <?php
  }
} else {
  ?>
  <h4>Viga</h4>
  <p>URL on vigane!</p>
<?php
}
?>