<?php
include '../Model/Database.php';

session_start(); //Pour stocker les valeurs dedans

//Récupérer et valider les données
$errors = [];
$username = htmlspecialchars($_POST['username'] ?? '');
$password = htmlspecialchars($_POST['password'] ?? '');

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
                header('Location: ../Pages/tuteur.php');
                exit;
            }

            header('Location: ../Pages/etudiant.php');
            exit();
        }
    }
}
//Affiche les erreurs et redigire vers login.php
$_SESSION['error'] = '';
foreach ($errors as $e) {
    $_SESSION['error'] .= $e . "<br>";
    }
header('Location: ../Pages/login.php');
exit();