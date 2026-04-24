<?php
require_once __DIR__ . '/menu.php';
?>

<html>
    <body>
        <h2>Bienvenue sur Helpdesk</h2>
        <p>Choisissez une action pour commencer.</p>

        <?php if (isset($_SESSION['user_id'])): ?>
            <p><a href="<?= ($_SESSION['role'] ?? '') === 'tutor' ? '../Pages/tuteur.php' : '../Pages/etudiant.php' ?>">Accéder à mon espace</a></p>
            <p><a href="../Pages/create.php">Créer un ticket</a></p>
        <?php else: ?>
            <p><a href="../Pages/login.php">Se connecter</a></p>
            <p><a href="../Pages/inscription.php">S'inscrire</a></p>
        <?php endif; ?>
    </body>
</html>