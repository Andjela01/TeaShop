<?php
require_once "config/connection.php";

try {
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT,
        username VARCHAR(50) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'manager', 'customer') NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(id)
    )ENGINE=InnoDB;";
    $pdo->exec($sql);


    $sql = "CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT,
        name VARCHAR(50) UNIQUE NOT NULL,
        description TEXT,
        PRIMARY KEY(id)
    )ENGINE=InnoDB;";
    $pdo->exec($sql);


    $sql = "CREATE TABLE IF NOT EXISTS teas (
        id INT AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        description TEXT,
        price DECIMAL(10, 2) NOT NULL,
        stock_quantity INT NOT NULL,
        category_id INT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY(id),
        CONSTRAINT fk_category_id
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON UPDATE CASCADE 
        ON DELETE RESTRICT
    )ENGINE=InnoDB;";
    $pdo->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT,
        user_id INT,
        order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
        total_amount DECIMAL(10, 2),
        PRIMARY KEY(id),
        CONSTRAINT fk_orders_user_id  
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
    )ENGINE=InnoDB;";
    $pdo->exec($sql);


    $sql = "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT,
        order_id INT,
        tea_id INT,
        quantity INT NOT NULL,
        price DECIMAL(10, 2) NOT NULL,
        PRIMARY KEY(id),
        CONSTRAINT fk_order_id
        FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
        CONSTRAINT fk_tea_id
        FOREIGN KEY (tea_id)
        REFERENCES teas(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
    )ENGINE=InnoDB;";
    $pdo->exec($sql);

    $sql = "CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT,
        user_id INT,
        tea_id INT,
        quantity INT NOT NULL,
        PRIMARY KEY(id),
        CONSTRAINT fk_cart_user_id  
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
        CONSTRAINT fk_cart_tea_id 
        FOREIGN KEY (tea_id)
        REFERENCES teas(id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
    )ENGINE=InnoDB;";
    $pdo->exec($sql);


    $sql = "INSERT INTO users (username, email, password, role) 
            VALUES ('admin', 'admin@a.com', 'admin', 'admin')";
    $pdo->exec($sql);

    $sql = "INSERT INTO users (username, email, password, role) 
            VALUES ('manager', 'manager@m.com', 'manager', 'manager')";
    $pdo->exec($sql);

    $sql = "INSERT INTO categories(name, description)
            VALUES('Biljni', 'Čajevi od lekovitih biljaka'),
                    ('Voćni', 'Čajevi sa susenim vocem'),
                    ('Začinski', 'Čajevi sa jakim, aromatičnim začinima')";
    $pdo->exec($sql);

    echo "Tabele uspešno kreirane i podaci uneseni!";
} catch (PDOException $e) {
    echo "Greška prilikom kreiranja tabela: " . $e->getMessage();
}
