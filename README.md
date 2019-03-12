# SnowTricks [![Codacy Badge](https://api.codacy.com/project/badge/Grade/1ee7d64c3b314ab8a1e8bcf415bf2610)](https://www.codacy.com/app/Silverfabien/SnowTricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Silverfabien/SnowTricks&amp;utm_campaign=Badge_Grade)

  Projet 6 OpenClassroom / développeur d'application PHP Symfony
  
 1> Installation
 
 Pour installer le projet cloner le projet et installer le avec la commande :
 
    git clone https://github.com/Silverfabien/SnowTricks.git
    composer install
 
 ---
 
 2> Accès a la BDD et à SMTP
 
 Base de données allez dans App/config/parameters.yml et modifier les lignes 3 à 7 si cela ne correspond pas.
    
        database_host: 127.0.0.1
        database_port: null
        database_name: snowtricks
        database_user: root
        database_password: null
    
 L'envois de mail via le SMTP, modifier les lignes 8 à 11
 
        mailer_transport: smtp
        mailer_host: Votre gestionnaire d'Email
        mailer_user: Votre email
        mailer_password: Votre mot de passe
 
 ---
 
 3> Données en BDD
 
 Avant d'installer la BDD, vérifier que vous n'avez pas une au nom de **SnowTricks**, si vous en avez faites la commande :
    
    php bin/console doctrine:database:create
    
 Ensuite les tables correspondantes :
 
    php bin/console doctrine:schema:update --force
    
 Puis ajouter les données correspondante au site en ajoutant les Fixture :

    php bin/console doctrine:fixtures:load
 
