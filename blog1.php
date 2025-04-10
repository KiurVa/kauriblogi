<?php
$sql = "SELECT *, DATE_FORMAT(added, '%d.%m.%Y %H:%i:%s') as estonia FROM blog ORDER BY added DESC";
$data = $db->dbGetArray($sql);
$db->show($data);
if ($data !== false) {
  $counter = 0; //Veeru lugeja 1, 2
  foreach ($data as $post) {
?>
      <div class="row mt-5">
    <div class="card shadow-sm">
      <div class="row g-0">
        <div class="col-md-5">
          <img
            src="<?= $post['photo'] ?>"
            class="img-thumbnail"
            width="650"
            alt="Pilt"
          />
        </div>
        <div class="col-md">
          <div class="card-body">
            <h5 class="card-title fs-3 fw-bold">
            card-title"><?= $post['heading'] ?>
            </h5>
            <p class="card-text">
              <small class="text-muted fw-bold"><?= $post['estonia'] ?></small>
            </p>
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
            <a href="?page=post&sid=<?= $post['id']; ?>" class="btn btn-outline-success"
              >Tahan edasi lugeda</a
            >
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php
    $counter++; //Liidab ühe juurde
  }
} //$data !== false
  ?>