                                                <!-- Vue des productions -->
<?php
$title = 'Réalisation';
?>

<section>
    <div class="realisation-container">

    
        <h1 class="section-title">Réalisations</h1>
        <div class="project-container">
       
            <?php foreach($pictures as $picture) { ?>
            
            <div class="img-project">
                <img src="<?php echo $picture->path;  ?>" alt=" <?php echo $picture->title; ?>">
               
                <div class=" content-realisation" >
                    <div>
                        <p> <?php echo $picture->description; ?> </p>
                        <a href="https://abcdtaxi.fr">Accès au site</a>
                    </div>
                   
                </div>
                
                <div>

                <?php
                    // Tableau pour stocker les languages
                    $languages = [];
                    array_push($languages, $picture->html, $picture->sass, $picture->js, $picture->php, $picture->symfony, $picture->react, $picture->wordpress);
                    // POur chaque languages avec une valeur non nulle
                    // on crée l'élément html en y insérant la class de l'icone fontawesome
                    foreach ($languages as $lang) {

                        if($lang != null) { ?> 
                            <i class="<?php echo $lang; ?>"></i> 
                        <?php } 
                    } 
                ?>

                </div>
                <div class=" btn-realisation" > 
                    <input type="button" class="btnForm" value="+">
                </div>
                
            </div>
           
            <?php  } ?>
        </div>
    </div>

    <div class="quote">
        <p class=""> Aujourd'hui j'estime à 35% le volume d'activité directement ou indirectement lié à la bonne visibilité de mon entreprise, et à 50% de ces 35% le taux de concrétisation des devis réalisés en trajets effectués. - ABCD Taxi</p>
    </div>
</section>