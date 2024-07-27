                                                        <!-- Vue d'une nouvelle production -->
 <?php
$title = 'Admin - Ajout';
?>

<section >
   
    <div class="form-admin">

        <h1 class="section-title">Nouvelle production</h1>
        <?php if (!empty($error)) { ?>

            <div class="msgError"> <?php echo $error; ?> </div>

        <?php } ?>
        <form action="" method="POST" id="myForm" enctype="multipart/form-data" novalidate>
        
            <label for="title">Titre</label>
            <input type="text" id="title" name="title" class="inputForm" required>
            <label for="description">Description</label>
            <input type="text" id="decription" name="description" class="inputForm" required>
            <label for="createdAt">Date de création</label>
            <input type="date" id="createdAt" name="createdAt" class="inputForm" required>
            <label for="file">Fichier</label>
            <input type="file" id="file" name="file" class="inputForm">
            <input type="submit" id="btnSend" name="btnSend" class="btnForm">
 
        </form>
    </div>
</section>