# Система Авторизации

Этот проект представляет собой веб-приложение на PHP с использованием базы данных MySQL, предназначенное для локального запуска через сервер XAMPP.

## Установка и настройка

### Установка и настройка

1. Клонируйте проект из репозитория GitHub в директорию `htdocs` XAMPP:

   ```bash
   git clone https://github.com/your/repository.git
   ```
   
2. Настройка базы данных

   Выполните SQL-запрос для создания таблицы пользователей

    ```sql
   CREATE DATABASE IF NOT EXISTS auth;
   
    USE auth;
   
    CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telephone VARCHAR(20) NOT NULL);
   ```
   Проверьте файл config/database.php для убедитесь, что параметры подключения к MySQL соответствуют вашей локальной конфигурации


3. Запуск проекта
 
    Заупстите XAMPP, Apache и MySQL

    ```
    http://localhost:8080/auth
      ```