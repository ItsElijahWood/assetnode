# 🚀 Setup Guide for Asset Node

## Prerequisites  
Before setting up Asset Node, ensure you have the following installed:  

- **Docker** (Required for running Apache, MySQL, and phpMyAdmin locally)  
- **Docker Compose** (For managing multi-container applications)  
- **PHP** (For running the project)  
- **Composer** (Dependency manager for PHP)  

> ⚠ **Note:** The `config.php` file is not included in this repository as it contains tokens. The developer will provide this file separately.  

---

## 🛠 Installation  

### 1️⃣ Install Docker and Docker Compose (Linux)  
Run the following command to install Docker and Docker Compose:  
```bash
sudo apt update && sudo apt install docker.io docker-compose -y
```
Ensure Docker is running:  
```bash
sudo systemctl start docker
sudo systemctl enable docker
```

### 2️⃣ Install PHP and Composer  
Run the following command:  
```bash
sudo apt install php composer -y
```

### 3️⃣ Install Dependencies  
Navigate to the project directory and run:  
```bash
composer install
```
This will install all required dependencies specified in `composer.json`.  

---

## 🚀 Running the Project  

1. Navigate to the project root and run:
   ```bash
   docker-compose up -d
   ```
   This starts Apache, MySQL, and phpMyAdmin in Docker containers.

2. Open a browser and navigate to:
   ```
   http://localhost:80
   ```
   The project should now be accessible.

3. Access phpMyAdmin at:
   ```
   http://localhost:8080
   ```
   Use the MySQL credentials defined in `docker-compose.yml`.

---

## 🎯 Additional Notes  
- Ensure `config.php` is placed in the project root before running the application.  
- Check the running Docker containers with:  
  ```bash
  docker ps
  ```  
- Stop the project when not in use:
  ```bash
  docker-compose down
  ```  
---

## Production
- In production, this project is configured for XAMPP, while Docker is used only for local development.
