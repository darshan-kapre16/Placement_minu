# College Training & Placement Cell Management System
## Setup Instructions

---

## ✅ Prerequisites
- WAMP or XAMPP installed and running
- PHP 8.0+
- MySQL 5.7+ or MariaDB 10+
- Browser (Chrome/Firefox/Edge)

---

## 📁 Step 1 — Copy Project Files

Copy the entire `placement_m` folder to your web server root:

- **WAMP:**  `C:\wamp64\www\placement_m\`
- **XAMPP:** `C:\xampp\htdocs\placement_m\`

---

## 🗄️ Step 2 — Import the Database

1. Start WAMP/XAMPP and ensure **Apache** and **MySQL** are running.
2. Open your browser and go to: `http://localhost/phpmyadmin`
3. Click **"New"** in the left sidebar to create a new database.
4. Name it `placement_db` → Click **Create**.
5. Select `placement_db` → Click the **"Import"** tab.
6. Click **"Choose File"** → Select `placement_m/database.sql`.
7. Click **"Go"** to import.

---

## ⚙️ Step 3 — Configure Database (if needed)

Open `placement_m/config/database.php` and update if your settings differ:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');           // Change if you have a MySQL password
define('DB_NAME', 'placement_db');
define('BASE_URL', 'http://localhost/placement_m/public/');
```

---

## 🌐 Step 4 — Access the System

Open your browser and go to:

```
http://localhost/placement_m/public/index.php?page=home
```

---

## 🔐 Default Login Credentials

### Admin Panel
- **URL:** `http://localhost/placement_m/public/login.php?type=admin`
- **Username:** `admin`
- **Password:** `admin123`

### Student Panel
- **URL:** `http://localhost/placement_m/public/login.php?type=student`
- Register a new student account (student must be approved by admin first)

---

## 🗂️ Folder Structure

```
placement_m/
├── app/
│   ├── controllers/
│   │   ├── AdminController.php      ← Admin logic
│   │   └── StudentController.php    ← Student logic
│   ├── models/
│   │   ├── Admin.php                ← Admin DB queries
│   │   ├── Student.php              ← Student DB queries
│   │   └── Company.php              ← Company/Drive DB queries
│   └── views/
│       ├── admin/                   ← Admin panel views
│       │   ├── login.php
│       │   ├── dashboard.php
│       │   ├── students.php
│       │   ├── companies.php
│       │   ├── applications.php
│       │   ├── notices.php
│       │   └── sidebar.php
│       ├── student/                 ← Student portal views
│       │   ├── login.php
│       │   ├── register.php
│       │   ├── dashboard.php
│       │   ├── apply.php
│       │   └── applications.php
│       └── public/                  ← Public website views
│           ├── home.php
│           ├── about.php
│           └── companies.php
├── config/
│   └── database.php                 ← DB config + connection
├── public/
│   ├── index.php                    ← FRONT CONTROLLER (router)
│   ├── login.php                    ← Login dispatcher
│   ├── css/style.css
│   └── js/admin.js
├── uploads/
│   ├── resumes/                     ← Student resumes stored here
│   └── notices/                     ← Notice attachments
└── database.sql                     ← Database schema + seed data
```

---

## 🔄 Functional Flow

### Student Flow
1. **Register** at `/index.php?page=register`
2. **Login** at `/login.php?type=student`
3. **Upload Resume** from the Dashboard
4. Wait for **Admin Approval**
5. **Browse Drives** at `/index.php?page=student_apply`
6. **Apply** to companies
7. **Track Status** at `/index.php?page=student_applications`

### Admin Flow
1. **Login** at `/login.php?type=admin`
2. View **Dashboard** stats
3. **Approve Students** at Students section
4. **Add/Manage Companies** and create Drives
5. **Review Applications** — Accept or Reject
6. **Post Notices** for students

---

## 🔒 Security Features

- Passwords hashed with `password_hash()` (bcrypt)
- All DB queries use **prepared statements** (no SQL injection)
- Session-based authentication with `session_regenerate_id()`
- Admin pages guarded — redirect to login if not authenticated
- Student pages guarded — redirect to login if not authenticated
- File upload validation (type + size)
- `htmlspecialchars()` on all output

---

## 🛠️ Troubleshooting

| Issue | Fix |
|-------|-----|
| Blank page | Enable PHP error display in php.ini |
| Database error | Check credentials in `config/database.php` |
| File upload fails | Check permissions on `uploads/` folder |
| CSS not loading | Ensure `BASE_URL` is correct in config |
| 404 on pages | Make sure you're accessing via `/public/index.php?page=...` |

---

## 📝 Notes

- Resume files are stored in `uploads/resumes/`
- Default admin password can be changed by updating the DB hash
- To generate a new password hash, use: `echo password_hash('newpass', PASSWORD_BCRYPT);`
