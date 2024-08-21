                                                <!-- Vue des productions -->
<?php
$title = 'Réalisation';
?>

<section>
    <div class="realisation-container">

        <h1 class="section-title">Réalisations</h1>
        <div class="project-container">
       
            <?php 
            if(isset($productions))
                foreach($productions as $production) { 
                    foreach($production as $item) {
            ?>
                    
            <div class="img-project">
                
                    <div class="content-container hide-content">
                      
                        
                        <div class=" content-realisation " >
                        <div>
                            <img src="<?php echo  $item->template1;  ?>" alt=" <?php echo  $item->title; ?>">
                            <img src="<?php echo  $item->template2;  ?>" alt=" <?php echo  $item->title; ?>">
                            <img src="<?php echo  $item->template3;  ?>" alt=" <?php echo  $item->title; ?>">
                            <img src="<?php echo  $item->template4;  ?>" alt=" <?php echo  $item->title; ?>">
                        </div>
                            <p> <?php echo  $item->description; ?> </p>
                            <a href="https://abcdtaxi.fr">Accès au site</a>
                            <button class="btn-close">x</button>
                        </div>
                       
                    </div>
                <img src="<?php echo  $item->path;  ?>" alt=" <?php echo  $item->title; ?>">
               
                <div class="center">
                        <button class="btn-realisation ">+</button>
                </div>

                <div>

                <?php
                    // Tableau pour stocker les languages
                    $languages = [];
                    array_push($languages,  $item->html,  $item->sass,  $item->js,  $item->php,  $item->symfony,  $item->react,  $item->wordpress);
                    // POur chaque languages avec une valeur non nulle
                    // on crée l'élément html en y insérant la class de l'icone fontawesome
                    foreach ($languages as $lang) {

                        if($lang != null) { ?> 
                            <i class="<?php echo $lang; ?>"></i> 
                        <?php } 
                    } 
                ?>

                </div>
                
                
            </div>
           
            <?php  } 
                }
            ?>
        </div>
    </div>

    <div class="quote">
        <p> Aujourd'hui j'estime à 35% le volume d'activité directement ou indirectement lié à la bonne visibilité de mon entreprise, et à 50% de ces 35% le taux de concrétisation des devis réalisés en trajets effectués. - ABCD Taxi</p>
    </div>
</section>