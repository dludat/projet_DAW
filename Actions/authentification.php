<?php
include "../Model/Database.php";

session_start();

//Récupérer et valider les données
$erreurs = [];
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

                //Ajoute message de succes
                $_SESSION['succes'] = "Vous êtes inscrit avec succes";
                //Redigire vers la page d'accueil
                header('Location: index.php');
                exit();
            }
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    } //Pas de succes
    $_SESSION['error'] = '';
    foreach ($erreurs as $e) {
        $_SESSION['error'] .= $e . "\n";
    }
    header('Location: inscription.php');
    exit();
}
?>