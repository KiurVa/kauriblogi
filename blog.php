<?php
$sql = "SELECT *, DATE_FORMAT(added, '%d.%m.%Y %H:%i:%s') as estonia FROM blog ORDER BY added DESC";
$data = $db->dbGetArray($sql);
if ($data !== false) {
  $counter = 0; //Veeru lugeja 1, 2
  foreach ($data as $post) {
    if ($counter % 2 === 0) {
?>
      <div class="row mt-1">
      <?php
    } //$counter % 2 == 0
      ?>
      <div class="col-md-6">
        <div class="card mb-1">
          <div class="card-body">
            <h4 class="card-title"><?= $post['heading'] ?><span class="fs-6"> <?= $post['estonia'] ?></span>
            </h4>
            <img src="<?= $post['photo'] ?>" class="img-fluid" alt="Pilt" />

            <p class="card-text">
              <?= $post['preamble'] ?>
            </p>
            <div class="mt-4">
              <strong>Märksõnad:</strong>
              <span class="me-1"><?php
                                  $tags = array_map('trim', explode(",", $post['tags'])); // Tükelda sildid komast
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
            <div class="text-end">
              <a href="?page=post&sid=<?= $post['id']; ?>" class="btn btn-primary">Loe edasi</a>
            </div>
          </div>
        </div>
      </div>
  <?php
    $counter++; //Liidab ühe juurde
    if ($counter % 2 === 0) {
      echo "</div>"; // rea lõpp
    }
  } //foreach
  if ($counter % 2 === 0) {
    echo "</div>"; // rea lõpp, kui viimasel real on postitusi
  }
} //$data !== false
  ?>