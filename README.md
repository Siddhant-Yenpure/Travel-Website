<img width="1878" height="881" alt="image" src="https://github.com/user-attachments/assets/5dbe56e4-92d0-46d8-8b47-2b3c5190a298" />
🌍 Travel Website — Travel Blogging Platform

This repository contains a Travel Blogging Website developed as part of my Continuous Assessment (CA) project during the 3rd semester of Engineering.
The project focuses on building a responsive and visually engaging website to showcase travel destinations, blogs, and experiences, along with basic backend and database integration.

📌 Project Overview

The Travel Website simulates a personal travel blog where users can:

Explore travel destinations

Read travel stories and experiences

View travel photo galleries

Learn about the blogger and project purpose

Submit data via forms (contact / blogs)

The project demonstrates frontend development, basic PHP backend handling, and MySQL database connectivity.

✨ Features

🏠 Home page with travel-themed UI

🧭 Travel blogs / destination content

📸 Image gallery

ℹ️ About page

📩 Contact form

📱 Responsive design

⚙️ PHP backend processing

🗄️ MySQL database support

🛠️ Tech Stack

HTML – Website structure

CSS – Styling and layout

JavaScript – Client-side interactivity

PHP – Server-side logic

MySQL – Database

XAMPP – Local development environment

📁 Project Structure
Travel-Website/
│
├── index.html
├── about.html
├── blog.html
├── gallery.html
├── contact.html
├── main.php
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
└── database/
    └── travel_db.sql


(Folder names may vary slightly.)

🚀 How to Run Locally
1️⃣ Install XAMPP

Download XAMPP from:
https://www.apachefriends.org/

Start the following services:

Apache

MySQL

2️⃣ Move Project to XAMPP

Copy the project folder to:

C:\xampp\htdocs\


Example:

C:\xampp\htdocs\Travel-Website\

3️⃣ Open in Browser
http://localhost/Travel-Website/


For PHP entry file:

http://localhost/Travel-Website/main.php

🗄️ SQL / MySQL Setup (XAMPP)
1️⃣ Open phpMyAdmin

In your browser:

http://localhost/phpmyadmin

2️⃣ Create Database

Click New

Enter database name:

travel_website


Click Create

3️⃣ Import SQL File

Select the travel_website database

Go to Import

Choose travel_db.sql (if provided)

Click Go

This will create the required tables automatically.

4️⃣ Database Connection (PHP)

Example connection file (db.php):

<?php
$conn = mysqli_connect("localhost", "root", "", "travel_website");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>


Default XAMPP credentials:

Username: root

Password: (empty)

🎯 Purpose of the Project

This project was created as part of the 3rd Semester Continuous Assessment to:

Apply frontend development concepts

Understand PHP–MySQL integration

Learn local hosting using XAMPP

Build a complete academic web project

📚 Learning Outcomes

Frontend development using HTML, CSS, and JavaScript

Backend basics using PHP

Database creation and querying with MySQL

Local server setup using XAMPP

Structuring a real-world web project

👤 Author

Siddhant Yenpure
3rd Semester Engineering Student

GitHub: https://github.com/Siddhant-Yenpure

📄 License

This project is created strictly for educational purposes as part of academic coursework.
