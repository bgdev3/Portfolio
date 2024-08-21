<?php
$title = 'mise à jour';

if (!isset($_SESSION['username_admin']))
    header('location:index.php');

$token = isset($_SESSION['token']) ? trim($_SESSION['token']) : null;
$name = pathinfo($production->path, PATHINFO_FILENAME);
$date = new DateTime($production->createdAt);
var_dump($_SESSION['test']);
?>

<section>
<div class="form-admin">

    <h1 class="section-title">mise à jour</h1>
    <?php if (!empty($error)) { ?>

        <div class="msgError"> <?php echo $error; ?> </div>

    <?php } ?>
    <div class="update-img">
        <img src="<?php echo $production->path; ?>" alt="">
        <form action="" method="POST" id="myForm" enctype="multipart/form-data" novalidate>

        <div class="flex-form">
            <div>
                <label for="title">Titre</label>
                <input type="text" id="title" name="title" class="inputForm" value="<?php echo $production->title; ?>" required>
                <label for="createdAt">Date de création</label> 
                <input type="date" id="createdAt" name="createdAt" class="inputForm"  value="<?php echo $date->format('Y-m-d'); ?>" required>
                <label for="file">Fichier</label>           
                <input type="file" id="file" name="file" class="inputForm">
                <label for="description">Description</label>
                <textarea  id="description" name="description" class="inputForm" rows="8" required> <?php echo $production->description; ?> </textarea>
            </div>
           
            <div>
                <label for="tmp1">Template 1</label>
                <input type="file" id="tmp1" name="tmp1" class="inputForm">
                <label for="tmp2">Template 2</label>
                <input type="file" id="tmp2" name="tmp2" class="inputForm">
                <label for="tmp3">Template 3</label>
                <input type="file" id="tmp3" name="tmp3" class="inputForm">
                <label for="tmp4">Template 4</label>
                <input type="file" id="tmp4" name="tmp4" class="inputForm">
                <label for="comment">Commentaire client</label>
                <textarea id="comment" name="comment" class="inputForm" rows="8"> <?php echo $production->comments; ?> </textarea>
            </div>
        </div>

            <input type="hidden" id="hidden_file" name="hidden_file" class="inputForm"  value="<?php echo $production->path; ?>" hidden>
            <input type="hidden" id="hidden_tmp1" name="hidden_tmp1" class="inputForm"  value="<?php echo $production->template1; ?>" hidden>
            <input type="hidden" id="hidden_tmp2" name="hidden_tmp2" class="inputForm"  value="<?php echo $production->template2; ?>" hidden>
            <input type="hidden" id="hidden_tmp3" name="hidden_tmp3" class="inputForm"  value="<?php echo $production->template3; ?>" hidden>
            <input type="hidden" id="hidden_tmp4" name="hidden_tmp4" class="inputForm"  value="<?php echo $production->template4; ?>" hidden>

            <input type="hidden" id="token" name="token" value="<?php echo $token; ?>">
            <input type="submit" id="btnSend" name="btnSend" class="btnForm">

        </form>
    </div>
</div>
</section>