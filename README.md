# Social Web Application

## Software Requirements
 - MySql 5.7
 - PHP 7.2
 
## Instalation
- create new database in mySql. i.e ```eqs```
- copy ```.env.dist``` into ```.env``` file
- set ```DATABASE_URL``` parameters in ```.env``` file
- run ```composer install```
- run ```php bin/console doctrine:schema:update --force```

### Run Project
- run ```php bin/console server:run```


## Project description
In order to use functionalities user need to be registered and logged in.

    • User can create one or many groups.
    • A group has only one administrator (its creator).
    • User can send a request to join a group.
    • User can join one or more groups.
    • Only the administrator can accept or refuse a join-request. 
    
- [FOSUserBundle](https://symfony.com/doc/2.0/bundles/FOSUserBundle/index.html) is used for user authentications.
- [SB Admin 2](https://startbootstrap.com/themes/sb-admin-2/) is used as layout template
- Project is not covered with tests