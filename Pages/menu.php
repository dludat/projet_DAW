<?php
//=== Le Menu en haut de tous les pages ===
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Helpdesk</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>

<header>
    <h1>Helpdesk</h1>

    <!-- Menu -->
    <nav>
        <a href="index.php">Accueil</a>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="../Pages/login.php">Connexion</a>
            <a href="../Pages/inscription.php">Inscription</a>
        <?php else: //Séparation des éspaces tuteurs et étudiants?>
            <a href="<?= ($_SESSION['role'] ?? '') === 'tutor' ? '../Pages/tuteur.php' : '../Pages/etudiant.php' ?>">Mes tickets</a>
            <a href="../Pages/create.php">Nouveau ticket</a>
            <?php if ($_SESSION['role'] === 'tutor'): #Possibilité d'ajouter les enseignants?>
                <a href='../Pages/cours.php'>Gestion d'enseignants</a>
            <?php endif?>
            <a href="../Pages/logout.php">Déconnexion</a>
        <?php endif; ?>
    </nav>
</header>

<!-- Messages -->
<?php if (isset($_SESSION['error'])): ?>
    <p style="error">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['succes'])): ?>
    <p style="succes">
        <?= htmlspecialchars($_SESSION['succes']) ?>
    </p>
    <?php unset($_SESSION['succes']); ?>
<?php endif; ?>
