USE helpdesk;

INSERT INTO users (username, password_hash, role) VALUES 
    ("Schoemer", "$2y$12$RjZPiSE0KicOjvaEHfy9c.iT8pQpmwS43nijQAn54agcxFRQyI07y", 'tutor'), 
    ("Althaus", "$2y$12$rDX.LckEM.RNlMFdgS5gPOlwftsqzz9KlZ/bF3qOto4SO/wr3pePK", 'tutor');
INSERT INTO subjects (name, description) VALUES ("DSEA", ""), ("Komplexitaetstheorie", "");
INSERT INTO tutor_subjects (tutor_id, subject_id) VALUES (1, 1), (2, 2);
