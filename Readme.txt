# SAE S3 - Développer une Application Web

Cette application web permet de gérer une plateforme de spectacles musicaux. Les utilisateurs peuvent explorer une liste de spectacles, filtrer selon différents critères (date, style musical, lieu), et ajouter des spectacles à leurs préférences. Les membres du staff peuvent gérer l'ajout, la modification et l'annulation de spectacles, ainsi que créer des soirées avec des spectacles associés.

## Fonctionnalités

### Pour les utilisateurs

- **Affichage de la liste des spectacles** : Visualisez les spectacles disponibles avec leur titre, date, horaire et image associée.
- **Filtrage des spectacles** : Filtrez les spectacles par date, style musical, ou lieu pour trouver facilement ce qui vous intéresse.
- **Affichage détaillé d'un spectacle** : Consultez les détails d'un spectacle, incluant le titre, les artistes, la description, la durée, les images, et des extraits audio/vidéo.
- **Affichage détaillé d'une soirée** : Consultez les informations complètes sur une soirée, y compris la thématique, la date, l'horaire, le lieu et les spectacles associés.
- **Ajouter des spectacles à vos préférences** : Ajoutez des spectacles à une liste de préférences, même sans compte utilisateur.
- **Affichage de votre liste de préférences** : Consultez facilement tous les spectacles que vous avez ajoutés à votre liste.

### Pour le staff (administrateurs et gestionnaires)

- **Authentification** : Le staff peut se connecter pour accéder à des fonctionnalités de gestion avancées.
- **Création d'un spectacle** : Ajoutez de nouveaux spectacles en saisissant les informations nécessaires (titre, artistes, description, etc.).
- **Création d'une soirée** : Organisez des soirées et associez-y des spectacles.
- **Annulation d'un spectacle** : Un spectacle peut être annulé tout en restant affiché dans la liste, marqué comme annulé.
- **Gestion des comptes staff** : Les administrateurs peuvent créer des comptes pour le staff afin de gérer le programme.

## Structure du projet

L'application est construite autour d'une architecture modulaire qui sépare clairement les responsabilités entre différentes parties :

1. **Renderer** : Gère l'affichage des données.
2. **Action** : Gère les actions de l'utilisateur (ajout, modification, suppression).
3. **Models** : Représente les données de l'application (spectacle, soirée, lieu, etc.).
4. **Repository** : Gère l'accès à la base de données.

## Installation et Configuration

### Prérequis

- Serveur web (Apache, Nginx, etc.)
- PHP 7.4 ou supérieur
- SGBD (MySQL, MariaDB)
- Composer pour gérer les dépendances PHP

### Étapes d'installation

1. **Cloner le projet**  
   Clonez le repository depuis GitHub.

   ```bash
   git clone https://github.com/AminoBela/SAE_Belalia_Laghlali_Lambert_Sanjuan_Topcu
   cd SAE_Belalia_Laghlali_Lambert_Sanjuan_Topcu
