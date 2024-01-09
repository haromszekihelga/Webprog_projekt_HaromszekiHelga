
CREATE DATABASE IF NOT EXISTS receptek_app;

USE receptek_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE recipe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES users(id)
)ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipe_id INT NOT NULL,
    filename VARCHAR(100) NOT NULL,
    FOREIGN KEY (recipe_id) REFERENCES recipe(id)
);

USE receptek_app;

-- -----------------------------------------------------
-- Data insertion for categories
-- -----------------------------------------------------

INSERT INTO categories (name) VALUES 
('Levesek'), ('Főételek'), ('Desszertek'), ('Saláták'), ('Vegetáriánus'),
('Sütemények'), ('Gyors kaják');

-- -----------------------------------------------------
-- Data insertion for users
--password = 'jelszo'
-- -----------------------------------------------------

INSERT INTO users (username, email, password) VALUES 
('reni', 'reni@gmail.com', 'password1'), 
('beata', 'beata2@gmail.com', 'password2'),
('anna', 'anna@gmail.com', 'password3');

-- -----------------------------------------------------
-- Data insertion for recipe
-- -----------------------------------------------------
INSERT INTO recipe (user_id, title, description, category) VALUES
(1, 'Paradicsomleves', 'Friss paradicsomból készült leves', 'Levesek'),
(1, 'Sült csirke', 'Ízletes sült csirke recept', 'Főételek'),
(2, 'Csokoládétorta', 'Csokoládéból készült finom torta', 'Desszertek'),
(2, 'Görög saláta', 'Friss zöldségekkel készült saláta', 'Saláták');


-- -----------------------------------------------------
-- Data insertion for images
-- -----------------------------------------------------

INSERT INTO images (recipe_id, filename) VALUES
(1, 'paradicsomleves.jpg'),
(2, 'sult_csirke.jpg'),
(3, 'csokoladetorta.jpg'),
(4, 'gorogsalata.jpg');

/*SELECT recipe.title, images.filename 
FROM recipe
LEFT JOIN images ON recipe.id = images.recipe_id 
WHERE recipe.id = 1;*/
