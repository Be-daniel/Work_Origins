<?php
session_start(); 

$status_message = '';
if (isset($_SESSION['status'])) {
    $status_message = $_SESSION['status'];
    unset($_SESSION['status']); 
}
?>

<form action="send_email.php" method="POST" role="form" class="form_dmd_rencontre">
    <div class="head-form">
        <h1>Laissez-nous un mail !</h1>
        <span class="underline_gris"></span>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit.
            Cum laborum iusto quo? Quos,
            distinctio explicabo</p>
    </div>
    
    <?php if ($status_message): ?>
        <div class="status-message">
            <?php echo htmlspecialchars($status_message); ?>
        </div>
    <?php endif; ?>
    <div class="body-form">
        <input type="text" name="fullname" placeholder="Nom complet" required>
        <input type="email" name="email" placeholder="Adresse email" required>
        <div class="div_slow_message">
            <textarea name="message" id="" placeholder="Ecrivez votre message ici..."></textarea>
        </div>
    </div>
    <div class="foot-form">
        <button type="submit">Envoyer </button>
    </div>

</form>
