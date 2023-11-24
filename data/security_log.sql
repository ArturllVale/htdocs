CREATE TABLE security_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    ip_address VARCHAR(45),
    timestamp DATETIME,
    action VARCHAR(255),
    attempts INT DEFAULT 0
);

CREATE TABLE tokens_recuperacao_senha (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX(email),
    INDEX(token)
);
