<?php
require_once __DIR__ . '/menu.php';
?>

<h2>Bienvenue sur Helpdesk</h2>
<p>Choisissez une action pour commencer.</p>

<?php if (isset($_SESSION['user_id'])): ?>
    <p><a href="<?= ($_SESSION['role'] ?? '') === 'tutor' ? 'tuteur.php' : 'etudiant.php' ?>">Accéder à mon espace</a></p>
    <p><a href="create.php">Créer un ticket</a></p>
<?php else: ?>
    <p><a href="login.php">Se connecter</a></p>
    <p><a href="inscription.php">S'inscrire</a></p>
<?php endif; ?>

</body>
</html>
