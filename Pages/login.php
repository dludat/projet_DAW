<?php
// Charge la classe de connexion et d'accès aux requêtes SQL.
include '../Model/Database.php';

session_start();

// Initialise les variables utilisées par le formulaire et les messages.
$errors = [];
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Traite le formulaire uniquement lorsqu'il est soumis en POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie que le nom d'utilisateur est bien renseigné.
    if ($username === '') {
        $errors[] = "Le nom d'utilisateur est obligatoire.";
    }

    // Vérifie que le mot de passe est bien renseigné.
    if ($password === '') {
        $errors[] = 'Le mot de passe est obligatoire.';
    }

    // Continue uniquement si la validation du formulaire ne contient pas d'erreur.
    if (empty($errors)) {
        // Ouvre l'accès à la base via la classe centralisée.
        $BDD = new ConnectionBDD();

        // Récupère l'utilisateur correspondant au nom saisi.
        $stmt = $BDD->get_login_data_by_username($username);

        // Lit le résultat de la requête pour vérifier le compte.
        $user = $stmt->fetch();

        // Vérifie que le compte existe et que le mot de passe est correct.
        if (!$user || !password_verify($password, $user['password_hash'])) {
            $errors[] = 'Identifiants invalides.';
        } else {
            // Stocke les informations utiles dans la session.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirige vers l'espace correspondant au rôle de l'utilisateur.
            if ($user['role'] === 'tutor') {
                header('Location: tuteur.php');
                exit;
            }

            header('Location: etudiant.php');
            exit;
        }
    }
}

require_once __DIR__ . '/menu.php';
echo '<link rel="stylesheet" href="../css/index.css">';
?>

<h2>Connexion</h2>

<?php if (!empty($errors)): ?>
    <ul>
        <?php foreach ($errors as $error): ?>
            <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form action="login.php" method="post">
    <label for="username">Nom d'utilisateur</label><br>
    <input id="username" type="text" name="username" value="<?= htmlspecialchars($username) ?>" required><br><br>

    <label for="password">Mot de passe</label><br>
    <input id="password" type="password" name="password" required><br><br>

    <button type="submit">Se connecter</button>
</form>

<p><a href="inscription.php">Créer un compte</a></p>
<p><a href="index.php">Retour accueil</a></p>

</body>
</html>
