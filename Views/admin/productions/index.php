                                        <!-- Vue de la liste des réalisation en cours -->
<?php
$title = 'Réalisations';
if(!isset($_SESSION['username_admin']))
    header('location:/public/');
?>

<section>
    <div class="realisation-admin">
        <h1  class="section-title">Liste réalisations</h1>
        <a href="/public/adminProduction/add/<?php echo trim($_SESSION['token']);?>">Nouvelle réalisation</a>
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
                                <td class="data"><img src="/public/<?php echo $val->path; ?>" alt="Projet abcd taxi"></td>
                                <td class="data"><?php echo $val->title; ?></td>
                                <!-- <td class="data"><?php echo $val->description; ?></td> -->
                                <td class="data"><?php echo $date->format('d/m/Y'); ?></td>
                                <td class="flexTd"><a href="/public/adminProduction/update/<?php echo $val->idProduction; ?>/<?php echo trim($_SESSION['token']); ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="/public/adminProduction/delete/<?php echo $val->idProduction;?>/<?php echo trim($_SESSION['token']); ?>"><i class="fa-regular fa-circle-xmark color-delete"></i></a></td>
                            </tr>
                        <?php  } 
                        ?>
                </tbody>
            </table>
        </div>
    </div>
    
</section>