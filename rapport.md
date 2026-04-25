# Helpdesk

## 1. Utilisation

- PHP natif
- MySQL
- PDO
- HTML / CSS
- JavaScript

## 2. Fonctionnalites principales

- inscription d'un utilisateur
- connexion avec gestion de session
- distinction entre les roles `student` et `tutor`
- affichage d'un espace etudiant
- affichage d'un espace tuteur
- creation d'un ticket
- consultation detaillee d'un ticket
- ajout de commentaires sur un ticket
- modification du statut, de la priorite et de la categorie d'un ticket cote tuteur
- affichage des messages de succes et d'erreur
- création de cours et enseignants (seulement pour `tutor`)

## 3. Structure du projet

```text
├── Actions
│   ├── add_comment_action.php
│   ├── add_subject.php
│   ├── add_tuteur.php
│   ├── connexion.php
│   ├── create_ticket_action.php
│   ├── register_action.php
│   └── update_ticket_action.php
├── css
│   ├── index.css
│   └── main.css
├── javascript
│   ├── etudiant.js
│   ├── ticket.js
│   └── tuteur.js
├── Model
│   ├── convertir_valeurs.php
│   ├── Database.php
│   ├── Database.sql
│   ├── Database.txt
│   └── DatabaseUML.png
├── Pages
│   ├── cours.php
│   ├── create.php
│   ├── etudiant.php
│   ├── index.php
│   ├── inscription.php
│   ├── login.php
│   ├── logout.php
│   ├── menu.php
│   ├── tickets.php
│   └── tuteur.php
├── rapport.md
├── README.md
├── sujet_projet.pdf
└── Tests
    ├── donnees.sql
    └── donnes_test.sql
```

## 4. Architecture generale

- `Pages/` contient les vues et les points d'entree de l'application.
- `Actions/` contient les traitements des formulaires.
- `Model/` contient la connexion a la base, les requetes SQL et quelques fonctions utilitaires.

Le coeur de l'acces aux donnees se trouve dans `Model/Database.php` via la classe `ConnectionBDD`.

## 5. Roles utilisateurs

### Etudiant

Un utilisateur ayant le role `student` peut:

- se connecter
- acceder a son espace personnel
- creer un ticket
- consulter ses tickets
- consulter le detail d'un ticket
- ajouter des commentaires

### Tuteur

Un utilisateur ayant le role `tutor` peut:

- se connecter
- acceder a son espace tuteur
- consulter les tickets
- consulter le detail d'un ticket
- ajouter des commentaires
- modifier la priorite, le statut et la categorie d'un ticket
- ajouter des comptes tuteurs/enseignants
- créer un nouveau cours et en ajouter des tuteurs

## 6. Base de donnees

Le schema principal est defini dans `Model/Database.sql`.

### Tables principales

- `users`: utilisateurs de la plateforme
- `subjects`: cours ou matieres
- `tutor_subjects`: association entre tuteurs et cours
- `categories`: type de ticket (`Cours`, `TD`, `TP`)
- `priorities`: niveau de priorite (1, 2, 3)
- `statuses`: etat du ticket (`Ouvert`, `En Cours`, `Résolu`)
- `tickets`: tickets crees par les utilisateurs
- `comments`: commentaires associes a un ticket

### Relations principales

- un utilisateur peut creer plusieurs tickets
- un utilisateur peut ecrire plusieurs commentaires
- un ticket appartient a un auteur
- un ticket est lie a un cours
- un ticket peut etre assigne a un tuteur
- un ticket possede une categorie, une priorite et un statut
- un ticket peut contenir plusieurs commentaires
- un tuteur peut etre associe a plusieurs matieres

## 7. Installation

### Prerequis

- PHP installé localement
- MySQL installé localement
- acces au terminal

### Sous macOS

Verifier les versions:

```bash
php -v
mysql --version
```

Si necessaire:

```bash
brew install php
brew install mysql
```

Demarrer MySQL:

```bash
brew services start mysql
```

## 8. Initialisation de la base de donnees

Se connecter a MySQL:

```bash
mysql -u root
```

Puis executer:

```sql
SOURCE /chemin/vers/projet_DAW/Model/Database.sql;
```

Ce script:

- cree la base `helpdesk`
- cree les tables
- insere les categories, priorites et statuts par defaut

Des donnees de test sont disponibles dans:

```text
Tests/donnes_test.sql
```

Une fois la base principale créé, on peut charger ces donnees:

```sql
USE helpdesk;
SOURCE /chemin/vers/projet_DAW/Tests/donnes_test.sql;
```

## 9. Lancement du projet

Depuis la racine du projet:

```bash
php -S localhost:8000
```

Acces a l'application:

```text
http://localhost:8000/Pages/index.php
```

## 10. Configuration de la connexion MySQL

La connexion PDO est configuree dans:

- `Model/Database.php`

Les parametres utilises sont:

- hote: `127.0.0.1`
- port: `3306`
- base: `helpdesk`
- utilisateur: variable d'environnement `DB_USER`, sinon `root`
- mot de passe: variable d'environnement `DB_PASS`, sinon chaine vide

Exemple:

```bash
export DB_USER=root
export DB_PASS=""
php -S localhost:8000
```

## 11. Parcours utilisateur

### Accueil

La page `Pages/index.php` affiche:

- les liens de connexion et d'inscription si l'utilisateur n'est pas authentifie
- l'acces a l'espace personnel et a la creation de ticket si l'utilisateur est connecte

### Inscription

La page `Pages/inscription.php` permet:

- de saisir un nom d'utilisateur
- de saisir un mot de passe
- de confirmer le mot de passe
- de choisir un role
Ensuite, les informations sont validés par `Actions/register_action.php`

### Connexion

La page `Pages/login.php` sert à saisir les données de verification,
qui sont ensuite traités par `Actions/connexion.php`:

- verifie les identifiants
- charge l'utilisateur depuis la base
- verifie le mot de passe hash
- stocke les informations en session
- redirige vers l'espace adapté au role

### Espace etudiant

La page `Pages/etudiant.php`:

- affiche les tickets de l'utilisateur connecte
- permet d'acceder a la creation d'un ticket
- permet d'ouvrir le detail de chaque ticket

### Espace tuteur

La page `Pages/tuteur.php`:

- affiche les tickets disponibles
- permet d'acceder au detail d'un ticket

### Creation d'un ticket

La page `Pages/create.php` propose un formulaire avec:

- titre
- cours
- tuteur
- priorite
- categorie
- description

Le formulaire est traite par `Actions/create_ticket_action.php`.

### Detail d'un ticket

La page `Pages/tickets.php` permet:

- d'afficher les informations du ticket
- d'afficher les commentaires
- d'ajouter un commentaire
- de modifier le ticket si le role est `tutor`

### Gestion d'enseignants et cours

La page `Pages/cours.php` permet aux tuteurs:

- d'ajouter des matières
- de repartir des tuteurs enregistrés aux matières
- d"enregistrer des nouveaux tuteurs

## 12. Scripts front-end

Le dossier `javascript/` contient trois scripts simples:

- `etudiant.js`: rend les lignes du tableau à la page de cette nom cliquables
- `tuteur.js`: rend les lignes du tableau à la page de cette nom cliquables
- `ticket.js`: preselectionne les boutons radio selon les valeurs du ticket

Le JavaScript reste leger et complete le rendu serveur.

## 13. Style et interface 
UTILISATION D'IA ! :

Nous avons commencé par dessiner une première version puis nous avons converti notre idée en un premier code CSS.
Le code CSS étant fonctionnel mais pas très beau visuellement il a été amélioré (couleurs, formes…) par l’IA "Claude" en se basant sur le CSS crée précédent.

Les feuilles de style principales se trouvent dans `css/`:

- `main.css`
- `index.css`


## 16. Repartition

La repartition est la suivante:

| Domaine | Ryan | David |
| --- | --- | --- |
| Connexion base | X |   |
| Authentification | X |   |
| Sessions | X |   |
| Inscription | X |   |
| Tickets |   | X |
| Commentaires |   | X |
| Gestion update tickets |   | X |
| Gestion site tuteur |   | X |
| Gestion creation tuteur |   | X |
| Interface CSS | X |   |
| Base de donnees | X | X |
| Tests | X | X |

