                                        <!-- Vue de la liste des réalisation en cours -->
<?php
$title = 'Réalisations';
if(!isset($_SESSION['username_admin']))
    header('location:index.php');

   
?>

<section>
    <div class="realisation-admin">
        <h1  class="section-title">Liste réalisations</h1>
        <a href="index.php?controller=adminProduction&action=add&token=<?php echo trim($_SESSION['token']);?>">Nouvelle réalisation</a>
        <div class="table-responsive">
            <table class="table">
                <thead class="">
                    <tr>
                        <!-- <th scope="col">#</th> -->
                        <th scope="col">Screenshot</th>
                        <th scope="col" >Titre</th>
                        <!-- <th scope="col" class="">Description</th> -->
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Parcours les jointures complètes
                    foreach($list as $items => $val) { 
                        $date = new DateTime($val->createdAt);
                        ?>
                            <tr>
                                <td class="data"><img src="<?php echo $val->path; ?>" alt="Projet abcd taxi"></td>
                                <td class="data"><?php echo $val->title; ?></td>
                                <!-- <td class="data"><?php echo $val->description; ?></td> -->
                                <td class="data"><?php echo $date->format('d/m/Y'); ?></td>
                                <td class="flexTd"><a href="index.php?controller=adminProduction&action=update&id=<?php echo $val->idProduction; ?>&token=<?php echo trim($_SESSION['token']); ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="index.php?controller=adminProduction&action=delete&id=<?php echo $val->idProduction;?>&token=<?php echo trim($_SESSION['token']); ?>"><i class="fa-regular fa-circle-xmark color-delete"></i></a></td>
                            </tr>
                        <?php  } 
                        ?>
                </tbody>
            </table>
        </div>
    </div>
    
</section>