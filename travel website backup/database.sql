CREATE DATABASE blog_posts;

USE blog_posts;

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100),
    content TEXT,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    image VARCHAR(255)
);
