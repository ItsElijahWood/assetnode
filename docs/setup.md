# 🚀 Setup Guide for Asset Node

## Prerequisites  
Before setting up Asset Node, ensure you have the following installed:  

- **PHP** (Required for running the project)  
- **Composer** (Dependency manager for PHP)  
- **LAMP/XAMPP** (For running the project on a local server)  

> ⚠ **Note:** The `config.php` file is not included in this repository as it contains tokens. The developer will provide this file separately.  

---

## 🛠 Installation  

### 1️⃣ Update and Install Dependencies (Linux)  
Run the following command to install PHP and Composer:  
```bash
sudo apt update && sudo apt install php composer -y
```  

### 2️⃣ Install Dependencies  
Navigate to the project directory and run:  
```bash
composer install
```  
This will install all required dependencies specified in `composer.json`.  

---

## 📂 Project Setup  

Ensure that the **Asset Node** directory is inside the `htdocs` folder:  

- **Linux (LAMP Stack):** `/opt/lamp/htdocs/assetnode`  
- **Windows (XAMPP):** `C:\xampp\htdocs\assetnode`  

You may need to restart your local server after placing the project in the correct directory.  

---

## 🚀 Running the Project  

1. Start your local server (LAMP/XAMPP).  
2. Open a browser and navigate to:  
   ```
   http://localhost/assetnode
   ```
3. The project should now be accessible.  

---

## 🎯 Additional Notes  
- Ensure `config.php` is placed in the project root before running the application.  
- If you encounter any issues, check PHP and Composer installations using:  
  ```bash
  php -v
  composer -V
  ```  
- For Windows users, run XAMPP as an administrator to avoid permission issues.  

---
