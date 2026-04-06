<?php
require_once __DIR__ . '/../config/Database.php';

session_start();

$erreurs = [];
$success = "";
$username = $_POST['username'] ?? "";
$password = $_POST['password'] ?? "";
$password_confirm = $_POST['password_confirm'] ?? "";
$role = $_POST['role'] ?? "student";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($username === "") {
        $erreurs[] = "Nom d'utilisateur obligatoire";
    }

    if ($password === "") {
        $erreurs[] = "Mot de passe obligatoire";
    }

    if ($password !== $password_confirm) {
        $erreurs[] = "Les mots de passe ne correspondent pas";
    }

    if (empty($erreurs)) {
        try {
            $pdo = getDatabaseConnection();

            $stmt = $pdo->prepare(
                "SELECT id FROM users WHERE username = :username LIMIT 1"
            );
            $stmt->execute(['username' => $username]);
            $existingUser = $stmt->fetch();

            if ($existingUser) {
                $erreurs[] = "Ce nom d'utilisateur existe déjà.";
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $insertStmt = $pdo->prepare(
                    "INSERT INTO users (username, password_hash, role)
                    VALUES (:username, :password_hash, :role)"
                );

                $insertStmt->execute([
                    'username' => $username,
                    'password_hash' => $password_hash,
                    'role' => $role,
                ]);

                $success = "Inscription réussie";
                $username = "";
                $role = "student";
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
}

require_once __DIR__ . '/menu.php';
?>

<h2>Inscription</h2>

<?php
if (!empty($erreurs)) {
    echo "<ul>";
    foreach ($erreurs as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul>";
}
?>

<?php
if ($success !== "") {
    echo "<p>" . htmlspecialchars($success) . "</p>";
}
?>

<form action="inscription.php" method="post">
    <p>
        <label for="username">Nom d'utilisateur</label><br>
        <input id="username" type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
    </p>

    <p>
        <label for="password">Mot de passe</label><br>
        <input id="password" type="password" name="password">
    </p>

    <p>
        <label for="password_confirm">Confirmer le mot de passe</label><br>
        <input id="password_confirm" type="password" name="password_confirm">
    </p>

    <p>
        <label for="role">Rôle</label><br>
        <select id="role" name="role">
            <option value="student" <?php if ($role === 'student') echo 'selected'; ?>>Étudiant</option>
            <option value="tutor" <?php if ($role === 'tutor') echo 'selected'; ?>>Tuteur</option>
        </select>
    </p>

    <p>
        <button type="submit">S'inscrire</button>
    </p>
</form>

<p><a href="login.php">Déjà inscrit ? Se connecter</a></p>
<p><a href="index.php">Retour accueil</a></p>

</body>
</html>
