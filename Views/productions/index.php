                                                <!-- Vue des productions -->
<?php
$title = 'Réalisation';
$comments = [];

?>

<section>
    <div class="realisation-container">

        <h1 class="section-title">Portfolio</h1>
        <div class="project-container">
       
            <?php 
            if(isset($productions))
                foreach($productions as $production) { 
                    foreach($production as $item) {
                        // Stcoke les avis de toutes les réalisation afin de les afficher.
                        array_push($comments, $item->comments);
                         // Tableau pour stocker les languages
                         $languages = [];
                         array_push($languages,  $item->html,  $item->sass, $item->bootstrap, $item->js,  $item->php,  $item->symfony,  $item->react,  $item->wordpress);
            ?>
                    
            <div class="img-project bgImg">
                <div class="content-container hide-content">
                    <div class=" content-realisation" >
                        <h3><?php echo $item->title; ?></h3>
                        <h5>Extrait de maquettes du projet</h5>
                        <div class="template">
                            <div><img src="/public/<?php echo  $item->template1;  ?>" alt=" <?php echo  $item->title; ?>" class="bgImg"><i class="fa-solid fa-arrow-up-right-from-square"></i></div> 
                            <div><img src="/public/<?php echo  $item->template2;  ?>" alt=" <?php echo  $item->title; ?>" class="bgImg"><i class="fa-solid fa-arrow-up-right-from-square"></i></div>
                            <div> <img src="/public/<?php echo  $item->template3;  ?>" alt=" <?php echo  $item->title; ?>" class="bgImg"><i class="fa-solid fa-arrow-up-right-from-square"></i></div>
                            <div> <img src="/public/<?php echo  $item->template4;  ?>" alt=" <?php echo  $item->title; ?>" class="bgImg"><i class="fa-solid fa-arrow-up-right-from-square"></i></div>
                        </div>
                        <p> <?php echo  $item->description; ?> </p>
                        <div class="technos">
                            <p>Technologies du projet : </p>
                            <ul>
                               <?php 
                                foreach ($languages as $lang) {

                                    if($lang != null) { ?> 
                                        <li> <i class="<?php echo $lang; ?>"></i> </li> 
                                    <?php } 
                                } ?>
                            </ul>
                        </div>
                        
                        <a href="https://abcdtaxi.fr">Accès au site</a>
                        <button class="btn-close">x</button>
                    </div>
                </div>
                <h4><?php echo $item->title; ?></h4>
                <img src="/public/<?php echo  $item->path;  ?>" alt=" <?php echo  $item->title; ?>">
                <div class="center">
                        <button class="btn-realisation ">+</button>
                </div>

                <div style="text-align: center";>
                    <!-- <small>Application de devis et de réservation de transport</small> -->
                    <!-- <?php
                       
                        // POur chaque languages avec une valeur non nulle
                        // on crée l'élément html en y insérant la class de l'icone fontawesome
                        foreach ($languages as $lang) {

                            if($lang != null) { ?> 
                                <i class="<?php echo $lang; ?>"></i> 
                            <?php } 
                        } 
                    ?> -->
                </div>
            </div>
            
            <?php  } 
                }
            ?>

        </div>
    </div>
    <!-- Affiche tous les avis  -->
    <aside class="quote">
        <div class="content-quote">

        <?php foreach($comments as $comment) { ?>
            <p> <?php echo $comment; ?> </p>
        <?php } ?> 

       </div>
       <a class="quote__prev" title="Précédent">&lsaquo;</a>
       <a  class="quote__next" title="Suivant">&rsaquo;</a>
       <div class="slide__dot">
            <div id="container-dot" class="dots"></div>
        </div>
    </aside>
</section>