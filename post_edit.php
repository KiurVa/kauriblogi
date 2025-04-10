<?php
if (isset($_GET['sid'])  && !empty($_GET['sid']) && is_numeric($_GET['sid']) && isset($_GET['delete'])) {
    $id = (int)$_GET['sid'];
    $update = $_GET['delete'];
    $sql = "SELECT photo FROM blog WHERE id=$id";
    $photo = $db->dbGetArray($sql);
    //$db->show($photo);
    if (!empty($photo[0]['photo']) && file_exists($photo[0]['photo'])) {
        unlink($photo[0]['photo']); //Kustutab pildi
    }
    $sql = "DELETE FROM blog WHERE id=$id";
    if ($db->dbQuery($sql)) {
        echo "<div class='alert alert-success'>Postitus kustutatud!</div>";
    } else {
        echo "<div class='aler alert-danger'>Postitus ei saanud kustutada!</div>";
    }
}

$sql = "SELECT id, heading, DATE_FORMAT(added, '%d.%m.%Y %H:%i:%s') as adding FROM blog ORDER BY added DESC";
$data = $db->dbGetArray($sql);
//$db->show($data); //TEST!
?>


<div class="row m-1">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card p-2 shadow">
            <h2 class="text-center">Muuda postitust</h2>
            <h6 class="text">Nimekiri:</h6>
            <?php
            if ($data !== false) {
            ?>
                <table class="table table-bordered">
                    <thead class="text-center">
                        <tr>
                            <th>Jrk</th>
                            <th>Pealkiri</th>
                            <th>Lisatud</th>
                            <th>Tegevus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($x = 0; $x < count($data); $x++) { //$x+=1 vs $x=$x+1 1 toimib ka xxx
                        ?>
                            <tr>
                                <td class="text-end"><?= ($x + 1); ?>.</td>
                                <td><?= $data[$x]['heading']; ?></td>
                                <td><?= $data[$x]['adding']; ?></td>
                                <td class="text-center">
                                    <a href="?page=edit&sid=<?= $data[$x]['id']; ?>" title="Muuda postitust"><i class="fa-solid fa-pen text-success me-3"></i></a>
                                    <a href="?page=post_edit&sid=<?= $data[$x]['id'] ?>&delete=true" onclick="return confirm('Kas oled kindel, et soovid kustada?');"><i class="fa-solid fa-trash-arrow-up text-danger" title="Kustuta postitus"></i></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            } else {
                echo "<h4>Viga</h4>";
                echo "<p>Postitusi ei leitud.</p>";
            }
            ?>

        </div>
    </div>
</div>