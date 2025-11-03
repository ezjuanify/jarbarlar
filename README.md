# Jarbarlar WordPress Environment

A fully Dockerized WordPress development environment with automated database seeding and phpMyAdmin support.

---

## 🧩 Overview

This stack provides:
- **WordPress (PHP 8.2 + Apache)**  
- **MySQL 8.0**  
- **phpMyAdmin** for DB management  
- **Automatic database seeding** from a remote SQL file (Google Drive)  
- **Local volume mounts** for themes, plugins, and uploads  

Everything runs inside Docker for clean reproducibility and zero manual setup.

---

## 🐋 Services

| Service      | Description                                   | Port  |
|---------------|-----------------------------------------------|--------|
| `wordpress`   | Main WordPress application                    | `8080` |
| `db`          | MySQL database with automatic seeding support | –      |
| `phpmyadmin`  | Database management UI                        | `8081` |

---

## ⚙️ Setup

### 1️⃣ Clone the repo
```bash
git clone https://github.com/<yourname>/jarbarlar.git
cd jarbarlar
