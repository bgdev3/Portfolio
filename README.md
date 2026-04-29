# Portfolio — bgdev.fr

![CI](https://github.com/charlieGui/Portfolio/actions/workflows/ci.yml/badge.svg)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php)
![PHPUnit](https://img.shields.io/badge/PHPUnit-11-brightgreen)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?logo=mysql)

Application portfolio développée **from scratch** en PHP 8.4 sans framework, suivant une architecture **MVC maison** avec container d'injection de dépendances, suite de tests PHPUnit et pipeline CI/CD GitHub Actions.

---

## Stack technique

| Couche | Technologie |
|---|---|
| Backend | PHP 8.4 |
| Base de données | MySQL 8 |
| Frontend | JavaScript vanilla, HTML5, CSS3 |
| Tests | PHPUnit 11 |
| CI/CD | GitHub Actions |
| Upload & images | GD Library (redimensionnement webp) |
| Sécurité | CSRF token, reCAPTCHA v2, PDO préparé |
| Environnement | vlucas/phpdotenv |

---

## Architecture

```
portfolio/
├── Controllers/        # Logique métier (MVC)
├── Core/               # Router, DbConnect
├── DependencyInjection/# Container IoC maison
├── Entities/           # Entités métier
├── Models/             # Accès BDD (PDO)
├── Services/           # Form, Captcha
├── Views/              # Templates PHP
├── tests/              # Suite PHPUnit
│   ├── Entities/
│   ├── Models/
│   └── Controllers/
└── public/             # Point d'entrée (index.php)
```

---

## Fonctionnalités

**Partie publique**
- Affichage des réalisations avec galerie d'images
- Page détail par projet avec stack technique associée
- Formulaire de contact

**Back-office admin**
- Authentification sécurisée (session + CSRF)
- CRUD complet sur les réalisations
- Upload et redimensionnement automatique des images en `.webp`
- Protection reCAPTCHA v2 sur les formulaires

---

## Tests

Suite de **18 tests PHPUnit** couvrant les 3 couches de l'application :

```bash
# Lancer tous les tests
vendor/bin/phpunit --testdox

# Par couche
vendor/bin/phpunit --testdox tests/Entities/
vendor/bin/phpunit --testdox tests/Models/
vendor/bin/phpunit --testdox tests/Controllers/
```

Les tests Models utilisent un **mock PDO** — aucune base de données réelle n'est requise pour les faire tourner.

---

## Installation locale

**Prérequis** : PHP 8.4, MySQL 8, Composer

```bash
# 1. Cloner le repo
git clone https://github.com/charlieGui/Portfolio.git
cd Portfolio

# 2. Installer les dépendances
composer install

# 3. Configurer l'environnement
cp .env.example .env
# Renseigner DB_SERVEUR, DB_USER, DB_PASSWORD, DB_BASE

# 4. Importer la base de données
mysql -u root -p portfolio < database/portfolio.sql

# 5. Lancer le serveur
php -S localhost:8000 -t public
```

---

## CI/CD

Chaque push sur `main` déclenche automatiquement le pipeline GitHub Actions :

1. Setup PHP 8.4
2. `composer install`
3. `vendor/bin/phpunit --testdox`

Le badge en haut du README reflète l'état des tests en temps réel.

---

## Auteur

**Guillaume** — [bgdev.fr](https://bgdev.fr)  
Développeur PHP freelance · Spécialisation Symfony