                                       <!-- Vue confirmation de suppression de realisation -->
<?php 
$title = 'Confirmation';
if(!isset($_SESSION['username_admin']))
    header('location:/public/');
?>

<section>
    <div class="confirm-container">
    <h1 class="section-title">Supprimer ?</h1>
        <form action="" method="POST">
            <input type="submit" name="yes" value="Oui" class="btnForm">
            <input type="submit" name="no" value="Non" class="btnForm">
        </form>
    </div>
</section>