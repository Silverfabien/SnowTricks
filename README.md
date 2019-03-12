# SnowTricks [![Codacy Badge](https://api.codacy.com/project/badge/Grade/1ee7d64c3b314ab8a1e8bcf415bf2610)](https://www.codacy.com/app/Silverfabien/SnowTricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Silverfabien/SnowTricks&amp;utm_campaign=Badge_Grade)

  Projet 6 OpenClassroom / développeur d'application PHP Symfony
  
 1> Installation
 
 Pour installer le projet cloner le projet et installer le avec la commande :
 
    git clone https://github.com/Silverfabien/SnowTricks.git
    
Ensuite faites la commande suivant pour généré le paramaters.yml et ses vendor :    

    composer install
 
 ---
 
 2> Accès au SMTP
 
 L'envois de mail via le SMTP, modifier les lignes 8 à 11
 
        mailer_host: le smtp
        mailer_port: le port
        mailer_encryption: tls
        mailer_user: email du smtp
        mailer_password: mot de passe du smtp
        contact_email: Adresse de reception
 
 ---
 
 3> Données en BDD
 
 Avant d'installer la BDD, vérifier que vous n'avez pas une au nom de **SnowTricks**, si vous en avez faites la commande :
    
    php bin/console doctrine:database:create
    
 Ensuite les tables correspondantes :
 
    php bin/console doctrine:schema:update --force
    
 Puis ajouter les données correspondante au site en ajoutant les Fixture :

    php bin/console doctrine:fixtures:load
 
