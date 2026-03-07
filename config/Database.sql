CREATE DATABASE helpdesk; USE helpdesk;

-- =====================================
-- Utilisateurs
-- =====================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student','tutor') NOT NULL
);

-- =====================================
-- Matières
-- =====================================

CREATE TABLE subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

-- Association N-N entre tuteurs et matières

CREATE TABLE tutor_subjects (
    tutor_id INT,
    subject_id INT,
    PRIMARY KEY (tutor_id, subject_id),
    FOREIGN KEY (tutor_id) REFERENCES users(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

-- =====================================
-- Types de tickets
-- =====================================

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

-- Exemples
INSERT INTO categories (name) VALUES
('Cours'),
('TD'),
('TP');

-- =====================================
-- Priorités
-- =====================================

CREATE TABLE priorities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20) NOT NULL
);

INSERT INTO priorities (name) VALUES ('Basse'), ('Moyenne'), ('Haute');

-- =====================================
-- Statuts des tickets
-- =====================================

CREATE TABLE statuses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(20) NOT NULL
);

INSERT INTO statuses (name) VALUES
('Ouvert'),
('En cours'),
('Résolu');

-- =====================================
-- Tickets
-- =====================================

CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT NOT NULL,
    subject_id INT NOT NULL,
    assigned_tutor_id INT NULL,
    category_id INT NOT NULL,
    priority_id INT NOT NULL,
    status_id INT NOT NULL,
    title VARCHAR(200) NOT NULL,
    description TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (author_id) REFERENCES users(id),
    FOREIGN KEY (assigned_tutor_id) REFERENCES users(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id),
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (priority_id) REFERENCES priorities(id),
    FOREIGN KEY (status_id) REFERENCES statuses(id)
);

-- =====================================
-- Commentaires
-- =====================================

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    author_id INT NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (ticket_id) REFERENCES tickets(id),
    FOREIGN KEY (author_id) REFERENCES users(id)
);