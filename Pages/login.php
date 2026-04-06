<?php
include '../config/Database.php';

session_start();

$errors = [];
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($username === '') {
        $errors[] = "Le nom d'utilisateur est obligatoire.";
    }

    if ($password === '') {
        $errors[] = 'Le mot de passe est obligatoire.';
    }

    if (empty($errors)) {
        $pdo = getDatabaseConnection();

        $stmt = $pdo->prepare(
            "SELECT id, username, password_hash, role
            FROM users
            WHERE username = :username
            LIMIT 1"
        );

        $stmt->execute(['username' => $username]);

        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            $errors[] = 'Identifiants invalides.';
        } else {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

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
