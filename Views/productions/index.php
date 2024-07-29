                                                <!-- Vue des productions -->
<?php
$title = 'Réalisation';
?>

<section>
    <div class="realisation-container">

    
        <h1 class="section-title">Projets</h1>
        <div class="project-container">
       
            <?php foreach($pictures as $picture) { ?>
            
            <div class="img-project">
                <img src="<?php echo $picture->path;  ?>" alt=" <?php echo $picture->title; ?>">
                <div class=" content-realisation" >
                    <p> <?php echo $picture->description; ?> </p>
                    <a href="https://abcdtaxi.fr">Accès au site</a>
                </div>
            </div>

            <?php  } ?>
        </div>
    </div>
</section>