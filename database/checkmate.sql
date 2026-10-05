-- checkmate.sql
-- Run this in phpMyAdmin (SQL tab) to create the database and the users table.

-- make the database (only if it doesn't exist yet)
CREATE DATABASE IF NOT EXISTS checkmate_db;

-- use that database
USE checkmate_db;

-- table that stores every account made from the sign up form
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,           -- unique number for each user
  full_name VARCHAR(100) NOT NULL,
  student_id VARCHAR(10) NOT NULL UNIQUE,      -- like 2025-62390, UNIQUE so no one signs up twice
  email VARCHAR(100) NOT NULL UNIQUE,          -- NCST email, also UNIQUE
  course VARCHAR(100) NOT NULL,
  year_level VARCHAR(20) NOT NULL,
  password VARCHAR(255) NOT NULL,              -- saved as a hash, NOT the real password
  role VARCHAR(10) NOT NULL DEFAULT 'student' -- everyone who signs up is a student

);