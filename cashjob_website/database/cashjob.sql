CREATE DATABASE IF NOT EXISTS cashjob CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cashjob;

SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS saved_jobs;
DROP TABLE IF EXISTS applications;
DROP TABLE IF EXISTS jobs;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('student','werkgever') NOT NULL DEFAULT 'student',
  company_name VARCHAR(150) DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE jobs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  employer_id INT UNSIGNED NOT NULL,
  title VARCHAR(120) NOT NULL,
  category ENUM('Horeca','Winkel','Zorg','Onderwijs','Kantoor','Overig') NOT NULL,
  location VARCHAR(120) NOT NULL,
  hourly_wage DECIMAL(7,2) NOT NULL,
  hours_per_week DECIMAL(4,1) NOT NULL,
  min_age TINYINT UNSIGNED NOT NULL DEFAULT 16,
  max_age TINYINT UNSIGNED DEFAULT NULL,
  schedule VARCHAR(150) DEFAULT NULL,
  description TEXT NOT NULL,
  responsibilities TEXT DEFAULT NULL,
  requirements TEXT DEFAULT NULL,
  icon VARCHAR(12) DEFAULT '💼',
  status ENUM('published','closed') NOT NULL DEFAULT 'published',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_jobs_employer FOREIGN KEY (employer_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_jobs_search (status, category, location),
  INDEX idx_jobs_wage (hourly_wage)
) ENGINE=InnoDB;

CREATE TABLE applications (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  job_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  cover_letter TEXT DEFAULT NULL,
  status ENUM('received','reviewing','accepted','rejected') NOT NULL DEFAULT 'received',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_application (job_id,user_id),
  CONSTRAINT fk_app_job FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
  CONSTRAINT fk_app_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_app_status (status)
) ENGINE=InnoDB;

CREATE TABLE saved_jobs (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  job_id INT UNSIGNED NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_saved_job (user_id,job_id),
  CONSTRAINT fk_saved_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_saved_job FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE transactions (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  type ENUM('income','expense') NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  category VARCHAR(60) NOT NULL,
  description VARCHAR(180) DEFAULT NULL,
  transaction_date DATE NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_transactions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_transactions_date (user_id,transaction_date)
) ENGINE=InnoDB;

-- Demo-account voor werkgever. Wachtwoord: DemoWerkgever123!
-- Alleen voor lokaal schoolgebruik. Verander of verwijder dit account voor publicatie.
INSERT INTO users (name,email,password_hash,role,company_name) VALUES
('CashJob Demo','demo@cashjob.local','$2y$12$covUZxhAyL80My6.Sm2iIOXzAeYPFxDrd.9k74TWbaDTTvYantNt2','werkgever','CashJob Demo Bedrijf');

INSERT INTO jobs (employer_id,title,category,location,hourly_wage,hours_per_week,min_age,max_age,schedule,description,responsibilities,requirements,icon,status) VALUES
(1,'Barista','Horeca','Nijmegen',15.00,12,16,NULL,'Flexibele uren, ook weekend','Werk in een gezellig koffieteam en leer gasten op een vriendelijke manier helpen. Je werkt in wisselende diensten en krijgt uitleg over de producten en werkwijze.','Koffie en andere dranken bereiden, bestellingen opnemen, de werkplek schoonhouden en samenwerken met collega’s.','Je bent klantvriendelijk, komt afspraken na en bent bereid om in het weekend te werken.','☕','published'),
(1,'Winkelmedewerker','Winkel','Arnhem',14.50,16,16,NULL,'Avonden en weekenden','Help klanten in een kledingwinkel en zorg samen met je team voor een nette winkel. Ervaring is fijn, maar motivatie en leergierigheid tellen ook.','Klanten helpen, kleding aanvullen, paskamers netjes houden en kassawerk leren.','Je bent vriendelijk, nauwkeurig en beschikbaar op minimaal één weekenddag.','🛍️','published'),
(1,'Assistent kinderopvang','Onderwijs','Nijmegen',15.25,16,18,NULL,'Overdag, in overleg','Ondersteun het team bij dagelijkse activiteiten voor kinderen. De werkgever bespreekt vooraf welke taken passen bij je opleiding en ervaring.','Materialen klaarzetten, activiteiten ondersteunen en ruimtes netjes houden.','Je hebt interesse in werken met kinderen. Vereiste diploma’s en wettelijke voorwaarden worden door de werkgever gecontroleerd.','🧸','published'),
(1,'Vakkenvuller','Winkel','Utrecht',14.25,10,15,NULL,'Avonden en zaterdag','Help mee om de winkel overzichtelijk en goed gevuld te houden. De diensten zijn te combineren met school, volgens de planning van het team.','Vakken vullen, producten spiegelen, voorraad controleren en klanten naar producten verwijzen.','Je werkt zorgvuldig en kunt afspraken over werktijden nakomen.','🛒','published'),
(1,'Medewerker bediening','Horeca','Amersfoort',14.75,8,16,NULL,'Avonden en weekenden','Ontvang gasten en help mee om een prettige ervaring in het restaurant te verzorgen. Je werkt samen met een team en leert tijdens je eerste diensten de procedures kennen.','Bestellingen opnemen, drankjes uitserveren, tafels klaarzetten en opruimen.','Je communiceert vriendelijk en blijft rustig wanneer het druk is.','🍽️','published'),
(1,'Administratief ondersteuner','Kantoor','Utrecht',15.75,8,18,NULL,'Doordeweeks overdag','Ondersteun een klein team met administratieve taken en eenvoudige gegevensverwerking. Dit is een bijbaan voor iemand die nauwkeurig werkt en graag structuur aanbrengt.','Gegevens invoeren, documenten ordenen en eenvoudige vragen doorzetten naar de juiste collega.','Je werkt nauwkeurig en hebt basiskennis van e-mail en tekstverwerking.','💻','published'),
(1,'Logistiek medewerker','Overig','Lelystad',15.10,12,18,NULL,'Ochtend of avond','Help bij het verzamelen en verwerken van bestellingen in een magazijn. De werkgever licht de veiligheidsregels en fysieke werkzaamheden vooraf toe.','Orders verzamelen, pakketten controleren en de werkplek netjes houden.','Je volgt veiligheidsinstructies en kunt de afgesproken diensten werken.','📦','published'),
(1,'Zorgondersteuner','Zorg','Arnhem',15.50,10,18,NULL,'In overleg','Ondersteun medewerkers bij praktische taken op een zorglocatie. De precieze taken hangen af van de locatie en je ervaring.','Materialen klaarzetten, gezamenlijke ruimtes voorbereiden en praktische ondersteuning bieden.','Je gaat zorgvuldig om met privacy en volgt de aanwijzingen van het team.','♡','published');
