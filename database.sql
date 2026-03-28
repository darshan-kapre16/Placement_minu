-- ============================================================
-- College Training & Placement Cell Management System
-- Database Schema & Seed Data
-- ============================================================

CREATE DATABASE IF NOT EXISTS placement_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE placement_db;

-- Admins Table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Students Table
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    branch VARCHAR(100),
    year VARCHAR(10),
    cgpa DECIMAL(4,2),
    resume VARCHAR(255),
    approved TINYINT(1) DEFAULT 0,
    placed TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Companies Table
CREATE TABLE IF NOT EXISTS companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(200) NOT NULL,
    location VARCHAR(200),
    package VARCHAR(100),
    description TEXT,
    website VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Drives Table
CREATE TABLE IF NOT EXISTS drives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    drive_date DATE NOT NULL,
    eligibility TEXT,
    status ENUM('upcoming','ongoing','completed') DEFAULT 'upcoming',
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);

-- Applications Table
CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    company_id INT NOT NULL,
    drive_id INT,
    status ENUM('pending','accepted','rejected') DEFAULT 'pending',
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE,
    UNIQUE KEY unique_application (student_id, company_id)
);

-- Notices Table
CREATE TABLE IF NOT EXISTS notices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(300) NOT NULL,
    content TEXT,
    file VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- Default Seed Data
-- ============================================================

-- Default Admin: username=admin, password=admin123
INSERT INTO admins (username, password) VALUES
('admin', '$2y$10$TKh8H1.PfYi1Nt8t/u5MuOeNgMTHJqDiZl7DcQI3gFjZ7yEW5TUCK');

-- Sample Companies
INSERT INTO companies (company_name, location, package, description, website) VALUES
('TCS', 'Mumbai, Maharashtra', '3.5 LPA', 'Tata Consultancy Services is a global IT services, consulting and business solutions organization.', 'https://www.tcs.com'),
('Infosys', 'Bengaluru, Karnataka', '3.6 LPA', 'Infosys is a global leader in next-generation digital services and consulting.', 'https://www.infosys.com'),
('Wipro', 'Bengaluru, Karnataka', '3.5 LPA', 'Wipro Limited is a leading global information technology company.', 'https://www.wipro.com'),
('Cognizant', 'Chennai, Tamil Nadu', '4.0 LPA', 'Cognizant is one of the world leading professional services companies.', 'https://www.cognizant.com'),
('Accenture', 'Mumbai, Maharashtra', '4.5 LPA', 'Accenture is a global professional services company with capabilities in digital, cloud and security.', 'https://www.accenture.com'),
('HCL Technologies', 'Noida, UP', '3.8 LPA', 'HCL Technologies is a next-generation global technology company.', 'https://www.hcltech.com');

-- Sample Drives
INSERT INTO drives (company_id, drive_date, eligibility, status, description) VALUES
(1, DATE_ADD(CURDATE(), INTERVAL 7 DAY), 'CGPA >= 6.5, No active backlogs, BE/BTech CSE/IT/ECE', 'upcoming', 'TCS National Qualifier Test followed by Technical and HR rounds.'),
(2, DATE_ADD(CURDATE(), INTERVAL 14 DAY), 'CGPA >= 6.0, BE/BTech all branches', 'upcoming', 'Infosys InfyTQ platform test followed by interview rounds.'),
(3, DATE_ADD(CURDATE(), INTERVAL -5 DAY), 'CGPA >= 7.0, BE/BTech CSE/IT', 'completed', 'Wipro Elite National Talent Hunt.');

-- Sample Notices
INSERT INTO notices (title, content) VALUES
('Campus Placement Drive 2024 - Registration Open', 'All eligible students are requested to register for upcoming campus placement drives. Ensure your resume is updated and approved by the placement cell before applying.'),
('Pre-Placement Talk by TCS', 'TCS will be conducting a Pre-Placement Talk before the drive. Attendance is mandatory for all registered students. Venue: Main Auditorium, 10:00 AM.'),
('Resume Submission Deadline', 'Last date to submit your resume for review is this Friday. Pending resumes will not be considered for upcoming drives.');
