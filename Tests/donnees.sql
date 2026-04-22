-- Nettoyage des tables

DELETE FROM comments;
DELETE FROM tickets;
DELETE FROM tutor_subjects;
DELETE FROM users;
DELETE FROM subjects;
DELETE FROM categories;
DELETE FROM priorities;
DELETE FROM statuses;

-- USERS

INSERT INTO users (id, username, password_hash, role) VALUES
(1, 'alice', '$2y$12$P20ni2b1NYFFNqRgDg2sMekmQrYDho3qfPz73X4/FE04p34FxeWbu', 'student'),
(2, 'bob', '$2y$12$P20ni2b1NYFFNqRgDg2sMekmQrYDho3qfPz73X4/FE04p34FxeWbu', 'student'), -- Mdp : Etudiant
(3, 'HassanTerro', '$2y$12$yi4pbUC2SGoccpoa5yvmAer9.rNXUWjRqMrW34IK05bQ1bZlokmIe', 'tutor'), -- Mdp: Tuteur
(4, 'DrMuller', '$2y$12$yi4pbUC2SGoccpoa5yvmAer9.rNXUWjRqMrW34IK05bQ1bZlokmIe', 'tutor'),
(5, 'OmarGatlato', '$2y$12$yi4pbUC2SGoccpoa5yvmAer9.rNXUWjRqMrW34IK05bQ1bZlokmIe', 'tutor');

-- SUBJECTS

INSERT INTO subjects (id, name, description) VALUES
(1, 'Primaire', 'Introduction à la lecture et à l’écriture'),
(2, 'Cuisine', 'Description dun plat en soufflé'),
(3, 'Musique', 'Analyse de musiques jazz oriental rétro-futuriste');

-- TUTOR SUBJECTS (N-N)

INSERT INTO tutor_subjects (tutor_id, subject_id) VALUES
(3, 1),
(3, 2),
(4, 2),
(5, 3);

-- CATEGORIES

INSERT INTO categories (id, name) VALUES
(1, 'Cours'),
(2, 'TD'),
(3, 'TP');

-- PRIORITIES

INSERT INTO priorities (id, name) VALUES
(1, 'Basse'),
(2, 'Moyenne'),
(3, 'Haute');

-- STATUSES

INSERT INTO statuses (id, name) VALUES
(1, 'Ouvert'),
(2, 'En cours'),
(3, 'Résolu');

-- TICKETS
INSERT INTO tickets (
id, author_id, subject_id, assigned_tutor_id,
category_id, priority_id, status_id,
title, description, created_at
) VALUES

(1, 1, 1, 3, 1, 2, 1,
 'Difficulté de lecture',
 'Je n''arrive pas à comprendre certains mots en lecture.',
 '2026-01-10 10:00:00'),

(2, 2, 2, NULL, 3, 3, 1,
 'Soufflé qui ne monte pas',
 'Mon soufflé retombe à la sortie du four, que faire ?',
 '2026-01-11 11:00:00'),

(3, 1, 2, 4, 2, 2, 2,
 'Texture du soufflé',
 'Comment obtenir une texture plus aérienne ?',
 '2026-01-12 09:30:00'),

(4, 2, 3, 5, 1, 1, 3,
 'Compréhension musicale',
 'Je ne comprends pas les rythmes dans le jazz oriental.',
 '2026-01-13 14:00:00');


-- COMMENTS

INSERT INTO comments (
id, ticket_id, author_id, message, created_at
) VALUES
(1, 1, 3, 'Essaie de lire à voix haute pour mieux comprendre.', '2026-01-10 10:30:00'),
(2, 1, 1, 'Merci, je vais essayer cette méthode.', '2026-01-10 11:00:00'),
(3, 2, 4, 'Vérifie la température du four et le temps de cuisson.', '2026-01-11 12:00:00'),
(4, 3, 4, 'Il faut bien monter les blancs en neige.', '2026-01-12 10:00:00'),
(5, 4, 5, 'Commence par écouter lentement et analyser les instruments.', '2026-01-13 15:00:00');