CREATE TABLE security_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    ip_address VARCHAR(45),
    timestamp DATETIME,
    action VARCHAR(255),
    attempts INT DEFAULT 0
);

ALTER TABLE login ADD cash_coins INT DEFAULT 0