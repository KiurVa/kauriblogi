<?php
$sql = "SELECT *, DATE_FORMAT(added, '%d.%m.%Y %H:%i:%s') AS estonia FROM blog ORDER BY added DESC LIMIT 3";
$data = $db->dbGetArray($sql);
//$db->show($data); //TEST. Näitab tulemust  inimlikult
?>

<div class="row m-0">
  <div class="col-md fw-bold fs-1 text-center">
    Tere tulemust minu blogisse!
  </div>
  <br />
  <div class="row">
    <div class="col-md text-center">
      See on blogi kõigile, kes tahavad saada targemaks ja paremaks. Kajastan
      siin igapäeva tegevusi ja muud huvitavat maailmas toimuvat.
    </div>
  </div>
</div>

<?php
if ($data !== false) {
  foreach ($data as $key => $val) {
?>
    <!-- SIIA HTML OSA-->
    <div class="row m-1">
      <div class="card shadow">
        <div class="row g-0">
          <div class="col-md-5">
            <img
              src="<?php echo $val['photo']; ?>"
              class="img-thumbnail"
              width="650"
              alt="Pilt">
          </div>
          <div class="col-md-7">
            <div class="card-body">
              <h5 class="card-title fs-3 fw-bold">
                <?php
                echo $val['heading'];
                ?>
              </h5>
              <div class="card-text">
                <small class="text-muted fw-bold"><?php echo $val['estonia']; ?></small>
              </div>
              <div class="card-text">
                <small class="text-muted fw-bold">
                  <?php
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
                  ?>
                </small>
              </div>
              <div class="card-text mt-2"><?php echo $val['preamble']; ?></div>
              <a href="?page=post&sid=<?= $val['id']; ?>" class="btn btn-outline-success mt-1">Tahan edasi lugeda</a>
            </div>
          </div>
        </div>
      </div>
    </div>
<?php
  }
} else {
  echo "ANDMEID pole";
}
?>