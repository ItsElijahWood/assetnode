# 📂 Asset Node  

**Asset Node** is a powerful asset management tool designed to help you keep track of what you **own, buy, lease, and loan**. Whether for personal or business use, this system simplifies asset tracking and organization.  

## 🛠️ Technologies Used  

This project is built using:  

- **Frontend:** jQuery  
- **Backend:** PHP  
- **Database:** MySQL  
- **Host:** Apache

# Setup

To setup make sure you have a .env file for docker in root directory and config.php for connecting to the database.

.env example:
```.env
    MYSQL_ROOT_PASSWORD=
    MYSQL_DATABASE=
    MYSQL_USER=
    MYSQL_PASSWORD=
    PMA_HOST=
```

config.php example:
```php
    <?php
    return [
        "DB_HOST" => "",
        "DB_USER" => "",
        "DB_PASSWORD" => "",
        "DB_NAME" => "",
        "DB_NAME_ASSETS" => "",
        "WEBSITE_URL" => "http://localhost:80"
    ];
```

## 🔒 License  

MIT License
