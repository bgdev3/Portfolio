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
                         array_push($languages,  $item->sass, $item->bootstrap, $item->tailwind, $item->js, $item->docker, $item->php,  $item->symfony,  $item->wordpress);
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

                                    if ($lang != null) { 
                                ?> 
                                    <div class="slack_title">

                                        <li> <i class="<?php echo $lang; ?>"></i> </li> 
                                        
                                <?php 
                                        $stacks = ['sass', 'bootstrap', 'tailwind', 'js', 'docker', 'php', 'symfony', 'wordpress'];
                                        foreach ($stacks as $stack) {
                                            if( str_contains($lang, $stack))   echo ucfirst($stack); 
                                        }
                                ?>  </div> 
                                <?php
                                    } 
                                } 
                                ?>
                            </ul>
                        </div>
                        
                        <a href="https://<?php echo $item->url; ?>">Accès au site</a>
                        <button class="btn-close">x</button>
                    </div>
                </div>
                <h4><?php echo $item->title; ?></h4>
                <img src="/public/<?php echo  $item->path;  ?>" alt=" <?php echo  $item->title; ?>">
                <div class="center">
                        <button class="btn-realisation ">+</button>
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