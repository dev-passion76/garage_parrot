

Guide pour l'Exécution en Local - Garage V.Parrot

 Installation de WAMP64

1. Téléchargement et Installation :
    - Visitez le site officiel de WAMP.
    - Téléchargez la version de WAMP correspondant à votre système (32 ou 64 bits).
    - Exécutez le fichier d'installation et suivez les instructions.

2. Démarrage de WAMP :
    - Lancez WAMP depuis le menu Démarrer.
    - Vérifiez que l'icône de WAMP dans la barre des tâches est verte.

 Configuration de MySQL

1. Création de la Base de Données :
    - Utilisez le terminal MySQL pour créer une nouvelle base de données (`CREATE DATABASE nom_de_votre_db;`).

2. Exécution de Scripts SQL :
    - Utilisez le fichier `DB_GARAGE.sql` pour initialiser la base de données.

 Configuration Apache

- Modifiez le fichier `httpd.conf` pour configurer Apache, notamment en définissant les alias et les directives nécessaires pour le projet.

 Configuration PHP

- Assurez-vous que les extensions `pdo_mysql` et `openssl` sont activées dans le fichier de configuration PHP (`php.ini`).

 Démarrage de l'Application

1. Placer les Fichiers du Projet :
    - Copiez les fichiers de votre projet dans le répertoire `www` de WAMP.

2. Accéder au Projet :
    - Ouvrez un navigateur et accédez à `localhost/nom_du_projet`.

 Tests et Validation

- Suivez le guide de test fourni pour valider les fonctionnalités clés du projet, telles que la visualisation des véhicules, l'utilisation des formulaires et la gestion par l'administrateur.

---

Création d'un Compte Administrateur

Pour créer un compte administrateur, suivez ces étapes après avoir configuré l'environnement local :

1. Accéder à MySQL :
    - Ouvrez le terminal MySQL (`mysql -u root -p`).
    - Sélectionnez la base de données créée (`USE nom_de_votre_db;`).

2. Créer le Compte Administrateur :
    - Utilisez la classe `classUtilisateur.php` pour ajouter un administrateur.
    - Exemple : `Utilisateur::ajoute($pdo, 'identifiant_admin', 'mot_de_passe', 'nom', 'prenom', 'type_utilisateur');`
    - Assurez-vous que le champ `type_utilisateur` est défini comme 'A' pour administrateur.

3. Vérification :
    - Après avoir ajouté le compte administrateur, connectez-vous via le fichier `signin.php` pour vérifier l'accès administratif.


Ce guide combine les étapes de configuration et de démarrage de l'application en local avec la création d'un compte administrateur, en tenant compte des spécificités du projet et de l'architecture de mes fichiers.



