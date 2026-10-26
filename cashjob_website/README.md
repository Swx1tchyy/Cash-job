# CashJob

CashJob is een schoolproject voor studenten die een passende bijbaan zoeken en meer overzicht willen krijgen over hun geld. De website gebruikt PHP, MySQL, HTML, CSS en JavaScript.

## Functionaliteiten
- Vacatures zoeken op trefwoord, locatie, categorie en minimumleeftijd.
- Vacaturedetails bekijken en solliciteren met een account.
- Registreren, inloggen en uitloggen met gehashte wachtwoorden.
- Vacatures opslaan en terugvinden.
- Werkgeversrol voor het plaatsen en beheren van vacatures.
- Eenvoudig persoonlijk inkomsten- en uitgavenoverzicht.
- Responsive vormgeving voor mobiel en desktop.
- SQL-bestand met tabellen en voorbeeldvacatures.

## Installeren met XAMPP
1. Installeer en start Apache en MySQL in XAMPP.
2. Kopieer de map `cashjob_website` naar `C:\xampp\htdocs\`.
3. Open `http://localhost/phpmyadmin`.
4. Importeer `database/cashjob.sql`.
5. Controleer `config/database.php`. De standaardinstellingen zijn geschikt voor een lokale XAMPP-installatie met gebruiker `root` en een leeg wachtwoord.
6. Open `http://localhost/cashjob_website/`.

## Eerste gebruik
- Maak via `Registreren` een account aan.
- Kies bij registratie of je een student of werkgever bent.
- Een student kan vacatures opslaan en solliciteren.
- Een werkgever kan vacatures toevoegen via `Werkgeversdashboard`.
- De financiële pagina is een eenvoudige privétracker. De bedragen zijn invoer van de gebruiker en worden niet automatisch van een bankrekening opgehaald.

## Belangrijke projectkeuzes
- Gebruik `password_hash()` en `password_verify()` voor wachtwoorden.
- SQL-query's met gebruikersinvoer gebruiken prepared statements.
- De voorbeeldvacatures zijn fictieve demo-data. Controleer echte lonen en voorwaarden altijd bij de werkgever.
- De applicatie is bedoeld voor lokaal schoolgebruik. Voor publicatie op internet zijn extra maatregelen nodig, zoals HTTPS, CSRF-bescherming, rate limiting, e-mailverificatie en uitgebreider beheer.

## Bestandsstructuur
- `index.php`: homepage en vacaturezoeker
- `vacatures.php`: alle vacatures en filters
- `vacature.php`: details en sollicitatie
- `login.php`, `register.php`, `logout.php`: account
- `opgeslagen.php`: opgeslagen vacatures
- `dashboard.php`: overzicht voor ingelogde gebruiker
- `werkgever.php`: vacatures plaatsen en beheren
- `financien.php`: inkomsten- en uitgavenregistratie
- `profiel.php`: profielgegevens aanpassen
- `config/database.php`: databaseverbinding
- `database/cashjob.sql`: database en demo-vacatures
- `assets/style.css`: vormgeving
- `assets/app.js`: kleine interacties
- `docs/teamplanning.md`: voorgestelde verdeling over vier groepsleden en vier werkdagen
