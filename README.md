# QETG - Quiz En Tout Genre

QETG est une application de quiz simple et personnalisable, développée en PHP. Ce projet permet aux utilisateurs de créer et de participer à des quiz variés et flexibles.

## Prérequis

- **PHP** version 7.4 ou plus
- **MySQL** ou **MariaDB** pour la base de données
- **Apache** ou tout autre serveur web compatible avec PHP
- **Composer** (facultatif, selon la gestion des dépendances)

## Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/malomouron/QETG.git
cd qetg
```

### 2. Configuration de la base de données

1. Importez le modèle de base de données fourni dans votre serveur MySQL/MariaDB :

   - Utilisez un client MySQL ou phpMyAdmin pour importer le fichier SQL du modèle :
   
     ```bash
     mysql -u votre_utilisateur -p votre_base_de_donnees < chemin/vers/le/modele_de_base.sql
     ```

2. Configurez le fichier `config.inc.php` en remplissant les informations de connexion à la base de données :

   ```php
   <?php
   // config.inc.php

   $db_host = 'localhost';       // Hôte de la base de données
   $db_user = 'votre_utilisateur'; // Utilisateur de la base de données
   $db_pass = 'votre_mot_de_passe'; // Mot de passe de la base de données
   $db_name = 'qetg';              // Nom de la base de données
   ?>
   ```


### 5. Démarrage de l'application

- Assurez-vous que votre serveur web est configuré pour exécuter des scripts PHP.
- Accédez à votre projet via l'URL locale (ex. : `http://localhost/quiz/`).

### 5. Connexion

Utilisez les identifiants créés au préalable dans la base de données.

## Fonctionnalités

- Création de quiz personnalisés
- Participation à des quiz en ligne
- Gestion des utilisateurs et des scores
- Autre...

## Support

Pour toute question ou problème, merci de contacter l'équipe de développement ou de créer une issue sur le dépôt GitHub.
