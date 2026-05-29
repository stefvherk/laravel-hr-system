# Laravel HR Systeem

## Overzicht

Dit project dient als aantoning van mijn PHP, Laravel en Docker vaardigheden als onderbouwing bij het internship-interview proces bij Moonly Software.



Het doel van dit project is het aantonen van kennis en vaardigheden binnen Laravel, waaronder:

* Authenticatie en autorisatie
* Eloquent ORM
* Database migrations
* Factories en seeders
* Form Requests
* CRUD-functionaliteit
* Role Based Access Control (RBAC)
* Filtering en paginatie
* Docker deployment

\---

# Gebruikte technologieën

* Laravel 13
* PHP 8.5
* SQLite
* Laravel Breeze
* Tailwind CSS
* Docker
* GitHub

\---

# Rollen

Het systeem ondersteunt drie rollen:

## Administrator

Kan:

* Alle medewerkers bekijken
* Medewerkers toevoegen
* Medewerkers aanpassen
* Medewerkers verwijderen
* Salarissen bekijken
* Wachtwoorden van andere gebruikers wijzigen
* Alle verlofaanvragen bekijken
* Verlofaanvragen goedkeuren of afwijzen
* Alle aanwezigheidsregistraties bekijken
* Aanwezigheidsregistraties aanmaken
* Alle salarisgegevens bekijken
* Salarisgegevens aanmaken

\---

## HR Manager

Kan:

* Alle medewerkers bekijken
* Medewerkers toevoegen
* Medewerkers aanpassen
* Medewerkers verwijderen
* Salarissen bekijken
* Alle verlofaanvragen bekijken
* Verlofaanvragen goedkeuren of afwijzen
* Alle aanwezigheidsregistraties bekijken
* Aanwezigheidsregistraties aanmaken
* Alle salarisgegevens bekijken
* Salarisgegevens aanmaken

Kan niet:

* Wachtwoorden van andere gebruikers wijzigen

\---

## Employee

Kan:

* Eigen dashboard bekijken
* Actieve collega's bekijken
* Medewerkers filteren
* Eigen verlofaanvragen bekijken
* Eigen verlofaanvragen indienen
* Eigen verlofaanvragen annuleren
* Eigen aanwezigheidsregistraties bekijken
* Eigen salarisgegevens bekijken

Kan niet:

* Salarissen van collega's bekijken
* Inactieve medewerkers bekijken
* Medewerkers beheren
* Verlofaanvragen goedkeuren
* Aanwezigheid registreren
* Salarisgegevens beheren

\---

# Functionaliteiten

## Dashboard

### Administrator / HR

Toont:

* Totaal aantal medewerkers
* Actieve medewerkers
* Medewerkers met verlof
* Aantal afdelingen

### Employee

Toont:

* Aantal eigen verlofaanvragen
* Openstaande verlofaanvragen
* Eigen aanwezigheidsregistraties
* Eigen salarisregistraties

\---

# Medewerkersbeheer

Ondersteunde functionaliteiten:

* Medewerker toevoegen
* Medewerker bekijken
* Medewerker aanpassen
* Medewerker verwijderen
* Zoeken op naam
* Filteren op afdeling
* Filteren op status
* Paginatie

\---

# Verlofaanvragen

Ondersteunde statussen:

* Pending
* Approved
* Rejected
* Cancelled
* Expired

Functionaliteiten:

* Verlof aanvragen
* Verlof annuleren
* Goedkeuren
* Afwijzen
* Automatische vervaldatum (Expired)
* Filteren op medewerker
* Filteren op startdatum
* Filteren op status

Business rules:

* Verlof moet minimaal 14 dagen vooraf worden aangevraagd
* Verlopen aanvragen krijgen automatisch de status Expired

\---

# Aanwezigheidsregistratie

Functionaliteiten:

* Registratie bekijken
* Filteren op medewerker
* Filteren op datum

Business logic:

* Gewerkte uren worden automatisch berekend
* Alleen eigen registraties zichtbaar voor medewerkers

\---

# Salarisadministratie

Functionaliteiten:

* Salarisoverzicht bekijken
* Salarisrecord aanmaken
* Netto salaris berekenen

Formule:

Netto salaris = Basissalaris + Bonus - Inhoudingen

Filtermogelijkheden:

* Eigen salarisoverzicht voor medewerkers
* Volledig overzicht voor HR en Administrators

\---

# Database

Belangrijkste entiteiten:

## User

Authenticatiegegevens en rol.

## Employee

Koppelt gebruikers aan HR-gerelateerde gegevens.

## Department

Afdelingen binnen de organisatie.

## Position

Functies inclusief basissalaris.

## LeaveRequest

Verlofaanvragen.

## AttendanceRecord

Aanwezigheidsregistraties.

## PayrollRecord

Salarisgegevens.

\---

# Laravel Functionaliteiten

Binnen dit project zijn onder andere de volgende Laravel componenten gebruikt:

## Eloquent Relationships

* hasOne
* belongsTo
* hasMany

## Form Requests

Voor validatie van invoer:

* StoreEmployeeRequest
* UpdateEmployeeRequest
* StoreLeaveRequest
* StoreAttendanceRecordRequest
* enzovoort

## Factories

Voor het genereren van testdata.

## Seeders

Voor het vullen van de database met realistische voorbeeldgegevens.

## Middleware

Voor authenticatie.

## Role Based Access Control

Via rollen:

* admin
* hr\_manager
* employee

## Pagination

Laravel paginator wordt gebruikt voor overzichtelijke tabellen.

## Filtering

Zoeken en filteren op meerdere pagina's.

\---

# Realistische Testdata

De database wordt gevuld met:

* Afdelingen
* Functies
* Medewerkers
* Verlofaanvragen
* Aanwezigheidsregistraties
* Salarisgegevens

De seeders houden rekening met:

* Verlofstatussen
* Salarissen gebaseerd op functie
* Historische salarisgegevens
* Relaties tussen medewerkers en afdelingen

\---

# Docker

Image bouwen:

```bash
docker build -t laravel-hr-system .
```

Container starten:

```bash
docker run -p 8000:8000 laravel-hr-system
```

\---



Er is een seeder aanwezig:

```bash
php artisan migrate:fresh --seed
```

Of gebruik de default user:

Email: admin@moonly.com

PW: Armstrong69



