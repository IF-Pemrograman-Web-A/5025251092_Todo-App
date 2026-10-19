CREATE DATABASE IF NOT EXISTS todo_app;

USE todo_app;

CREATE TABLE IF NOT EXISTS todos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    due_date DATE NULL,
    image VARCHAR(255) NULL,
    notification DATETIME NULL,
    completed TINYINT(1) NOT NULL DEFAULT 0,
    todo_type ENUM('personal', 'shared') NOT NULL DEFAULT 'personal',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO todos (title, description, due_date, image, notification, completed, todo_type)
VALUES
('Tugas', 'Tugas TeGraf', '2026-10-25', NULL, NULL, 0, 'personal'),
('ETS', 'KPPL', '2026-10-22', NULL, NULL, 0, 'shared'),
('CTF', 'Lanjut Cylab', NULL, NULL, NULL, 1, 'personal');
