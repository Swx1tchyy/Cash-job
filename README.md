# Cash job

CashJob is een website voor studenten die een bijbaan zoeken en hun inkomsten en uitgaven willen bijhouden. Werkgevers kunnen vacatures plaatsen en beheren.

## Functionaliteiten

    Vacatures bekijken en zoeken.
    Vacatures filteren en details bekijken.
    Een account aanmaken als student of werkgever en inloggen.
    Vacatures opslaan en solliciteren.
    Als werkgever vacatures plaatsen en beheren.
    Een persoonlijk dashboard bekijken.
    Inkomsten en uitgaven handmatig registreren.
    Profielgegevens bekijken en aanpassen.

## Gebruikte technieken

    PHP
    MySQL
    HTML
    CSS
    JavaScript
    XAMPP voor lokaal testen

## Benodigdheden

    XAMPP met Apache en MySQL/MariaDB.
    Een webbrowser.
    De bestanden van dit project.

## Installatie en starten
## 1. Projectbestanden plaatsen

    Download het project en pak het ZIP-bestand uit.
    Kopieer de map cashjob_website naar de map htdocs van XAMPP.
    Op Windows is dit meestal: C:\xampp\htdocs\cashjob_website

## 2. Apache en MySQL starten

    Open het XAMPP Control Panel.
    Klik bij Apache op Start.
    Klik bij MySQL op Start.

## 3. Database importeren

    Open http://localhost/phpmyadmin in je browser.
    Ga naar Importeren.
    Selecteer het bestand database/cashjob.sql uit de projectmap.
    Start de import. Het SQL-bestand maakt de database en de benodigde tabellen aan.

## 4. Databaseverbinding controleren
Open config/database.php en controleer de database-instellingen. De standaardinstellingen zijn:

    Host: localhost
    Databasenaam: cashjob
    Gebruikersnaam: root
    Wachtwoord: leeg

Pas deze instellingen aan als jouw lokale MySQL-installatie andere gegevens gebruikt.

## 5. Website openen
Open deze URL in je browser:
http://localhost/cashjob_website/
Database
Het bestand database/cashjob.sql bevat de database-opzet en voorbeeldvacatures. De voorbeeldvacatures zijn fictief.

## Belangrijke aandachtspunten

    De financiële administratie werkt met inkomsten en uitgaven die de gebruiker zelf invoert. Er is geen koppeling met een bankrekening.
    Dit project is gemaakt als school-/groepsproject en is niet zonder aanvullende beveiligingsmaatregelen geschikt voor productiegebruik.
    Deel nooit wachtwoorden, geheime sleutels of echte persoonsgegevens via GitHub.
    Controleer vóór het publiceren of config/database.php geen echte wachtwoorden of andere geheime gegevens bevat.

## Mogelijke uitbreidingen

    Verdere beveiliging en validatie van invoer.
    Geautomatiseerde tests.
    Een online hostingomgeving met ondersteuning voor PHP en MySQL.

