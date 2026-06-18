CREATE DATABASE IF NOT EXISTS mctiers_db;
USE mctiers_db;

CREATE TABLE IF NOT EXISTS players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_name VARCHAR(50) NOT NULL,
    rank_title VARCHAR(30) DEFAULT 'Combat Master',
    points INT DEFAULT 0,
    region VARCHAR(5) DEFAULT 'NA',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);