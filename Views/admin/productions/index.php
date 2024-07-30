<?php
$title = 'Réalisations';
?>

<section>
    <div class="realisation-admin">
        <h1  class="section-title">Liste réalisations</h1>
        <a href="index.php?controller=adminProduction&action=add">Nouvelle réalisation</a>
        <div class="table-responsive">
            <table class="">
                <thead class="">
                    <tr>
                        <!-- <th scope="col">#</th> -->
                        <th scope="col" class="">Titre</th>
                        <th scope="col" class="">Description</th>
                        <th scope="col" class="">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Parcours les jointures complètes
                    foreach($list as $items => $val) { ?>
                            <tr >
                                <td class="data"><?php echo $val->title; ?></td>
                                <td class="data"><?php echo $val->description; ?></td>
                                <td class="data"><?php echo $val->createdAt; ?></td>
                                <td class="flexTd"><a href="index.php?controller=adminProduction&action=update&id=<?php echo $val->idProduction; ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="index.php?controller=adminProduction&action=delete&id=<?php echo $val->idProduction; ?>"><i class="fa-regular fa-circle-xmark color-delete"></i></a></td>
                            </tr>
                        <?php  } 
                        ?>
                </tbody>
            </table>
        </div>
    </div>
    
</section>