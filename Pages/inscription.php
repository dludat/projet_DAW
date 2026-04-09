<?php
// Charge la classe de connexion et d'accès aux requêtes SQL.
require_once __DIR__ . '/../config/Database_tickets.php';

session_start();

// Initialise les variables utilisées par le formulaire et les messages.
$erreurs = [];
$success = "";
$username = $_POST['username'] ?? "";
$password = $_POST['password'] ?? "";
$password_confirm = $_POST['password_confirm'] ?? "";
$role = $_POST['role'] ?? "student";

// Traite le formulaire uniquement lorsqu'il est soumis en POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie que le nom d'utilisateur est bien renseigné.
    if ($username === "") {
        $erreurs[] = "Nom d'utilisateur obligatoire";
    }

    // Vérifie que le mot de passe est bien renseigné.
    if ($password === "") {
        $erreurs[] = "Mot de passe obligatoire";
    }

    // Vérifie que les deux mots de passe sont identiques.
    if ($password !== $password_confirm) {
        $erreurs[] = "Les mots de passe ne correspondent pas";
    }

    // Continue uniquement si la validation du formulaire ne contient pas d'erreur.
    if (empty($erreurs)) {
        try {
            // Ouvre l'accès à la base via la classe centralisée.
            $BDD = new ConnectionBDD();

            // Cherche si un utilisateur avec ce nom existe déjà.
            $stmt = $BDD->get_user_by_username($username);
            $existingUser = $stmt->fetch();

            // Empêche la création d'un deuxième compte avec le même nom.
            if ($existingUser) {
                $erreurs[] = "Ce nom d'utilisateur existe déjà.";
            } else {
                // Génère le hash sécurisé du mot de passe avant insertion.
                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                // Insère le nouvel utilisateur en base via ConnectionBDD.
                $BDD->inserer_user($username, $password_hash, $role);

                // Réinitialise une partie du formulaire et affiche le succès.
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
echo '<link rel="stylesheet" href="../css/index.css">';
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
