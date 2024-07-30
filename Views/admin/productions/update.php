<?php
$title = 'mise à jour';

$name = pathinfo($realisation->path, PATHINFO_FILENAME);
?>

<section>
<div class="form-admin">

    <h1 class="section-title">mise à jour</h1>
    <?php if (!empty($error)) { ?>

        <div class="msgError"> <?php echo $error; ?> </div>

    <?php } ?>
    <div class="update-img">
        <img src="<?php echo $realisation->path; ?>" alt="">
        <form action="" method="POST" id="myForm" enctype="multipart/form-data" novalidate>

            <label for="title">Titre</label>
            <input type="text" id="title" name="title" class="inputForm" value="<?php echo $realisation->title; ?>" required>
            <label for="description">Description</label>
            <input type="text" id="decription" name="description" class="inputForm"  value="<?php echo $realisation->description; ?>" required>
            <label for="createdAt">Date de création</label>
            <input type="date" id="createdAt" name="createdAt" class="inputForm"  value="<?php echo $realisation->createdAt; ?>" required>
            <label for="file">Fichier</label>
            <input type="file" id="file" name="file" class="inputForm">
            <input type="hidden" id="hidden" name="hidden" class="inputForm"  value="<?php echo $realisation->path; ?>" hidden>
            <input type="submit" id="btnSend" name="btnSend" class="btnForm">

        </form>
    </div>
</div>
</section>