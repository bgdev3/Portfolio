<?php
$title = 'mise à jour';

if(!isset($_SESSION['username_admin']))
    header('location:index.php');

$token = isset($_SESSION['token']) ? trim($_SESSION['token']) : null;
$name = pathinfo($realisation->path, PATHINFO_FILENAME);
$date = new DateTime($realisation->createdAt);
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
            <textarea  id="description" name="description" class="inputForm" rows="8" required><?php echo $realisation->description; ?></textarea>
            <label for="createdAt">Date de création</label> 
            <input type="date" id="createdAt" name="createdAt" class="inputForm"  value="<?php echo $date->format('Y-m-d'); ?>" required>
            <label for="file">Fichier</label>           
            <input type="file" id="file" name="file" class="inputForm">
            <input type="hidden" id="hidden" name="hidden" class="inputForm"  value="<?php echo $realisation->path; ?>" hidden>
            <input type="hidden" id="token" name="token" value="<?php echo $token; ?>">
            <input type="submit" id="btnSend" name="btnSend" class="btnForm">

        </form>
    </div>
</div>
</section>