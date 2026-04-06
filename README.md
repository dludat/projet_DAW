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


## 6. Créer nouveau utilisateur pour localhost

On execute les commandes suivants pour créeer un nouveau utilisateur et lui donne les droits nécessaires.
`CREATE USER '[nom d'utilisateur]']@'localhost' IDENTIFIED BY '[mot de passe]';`
`GRANT ALL PRIVILEGES ON helpdesk.* TO '[nom d'utilisateur]'@'localhost';`
`FLUSH PRIVILEGES;`


## 7. Quitter MySQL

`EXIT;`


# II — Lancer le serveur PHP

# 1. Vérifier l’installation de PHP

`php -v`

Sinon :

`brew install php`


# 2. Aller dans le dossier du projet

`cd ~[CheminCompletVers]/projet_DAW/`


# 3. Definir variables pour la Connection BDD

`export DB_USER=[nom d'utilisateur]`
`export DB_PASS=[mot de passe]`


# 4. Lancer le serveur PHP

`php -S localhost:8000`


# 5. Accéder au site
Avec
`http://localhost:8000/Pages/index.php`



| Domaine                | Ryan | David |
| ----------------       | - | - |
| Connexion base         | X |   |
| Authentification       | X |   |
| Sessions               | X |   |
| Inscription            | X |   |
| Tickets                |   | X |
| Commentaires           |   | X |
| Gestion Update tickets |   | X |
| Gestion site tuteur    |   | X |
| Gestion création tuteur|   | X |
| Interface CSS          | X |   |
| Base de données        | X | X |
| Tests                  | X | X |