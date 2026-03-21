# I — Création de la base de données

Sur macOS:

## 1. Vérifier l’installation de MySQL

`mysql --version`

Sinon:

`brew install mysql`


## 2. Démarrer le serveur MySQL

`brew services start mysql`


## 3. Se connecter au client MySQL

`mysql -u root`

On est dans l’interface :

`mysql>`


## 4. Créer la base de données

Exécuter le script SQL via :

`SOURCE [CheminCompletVers]/projet_DAW/config/Database.sql;`

Ce script va :
* créer la BDD
* créer toutes les tables nécessaires au projet


## 5. Vérifier que la base a bien été créée

`SHOW DATABASES;`


## 6. Quitter MySQL

`EXIT;`


# II — Lancer le serveur PHP

# 1. Vérifier l’installation de PHP

`php -v`

Sinon :

`brew install php`


# 2. Aller dans le dossier du projet

`cd ~[CheminCompletVers]/projet_DAW/`


# 3. Lancer le serveur PHP

`php -S localhost:8000`


# 4. Accéder au site
Avec
`http://localhost:8000/Pages/index.php`


$_SESSION variables:
-> id de l'utilisateur (en autres pour le téléchargement des vraies tickets) ['user_id']
-> role de l'utilisateur (tutor ou student) ['role']
-> erreurs de formulaire pour la rédirection et gestion ['error']
-> message de succès de l'action ['succes']




| Domaine          | Ryan | David |
| ---------------- | - | - |
| Connexion base   | X |   |
| Authentification | X |   |
| Sessions         | X |   |
| Inscription      | X |   |
| Tickets          |   | X |
| Commentaires     |   | X |
| Gestion statut   |   | X |
| Interface CSS    | X | X |
| Base de données  | X | X |
| Tests            | X | X |
