
## POURQUOI E-VOTING

E-VOTING innove afin de garantir à ses clients 
une visibilité optimale DE VOTE EN LIGNE

## Development Technology

- PHP
- Laravel Framework

## Execution Procedure

Accéder au projet
```bash
$ git clone https://github.com/joelppj/FrikSMS_Backend.git
$ cd FrikSMS_Backend

```
Installer les dépendances
```bash

==== INSATALLATION DES DEPENDANCES  ============
composer install


```
Configuration de la base de donnée
```bash

==== DB CONFIGURATION  ============
    ==> Créer une base de donnée
    ==> Allez dans le fichier .env puis renseigner les coordonnées de votre DB que vous venez de créer

```
Migration des data par defaut dans la DB
```bash

==== DB migration  ============
    Tapez::
    ==> $ php artisan migrate --seed(pour migrer les factories par defaut)

```
Démarrer le serveur en développement
```bash

==== DEMARRAGE REEL DU PROJET ============
$ php artisan passport:install
$ php artisan serve
```
Acceder au Projet par :http://127.0.0.1:8000

## CONSOMMATION DE L'API & UTILISATION DES ROUTES

Accéder à AGBANDE_API/DOCUMENTATION.txt POUR VOIR TOUTES LES ROUTES AINSI QUE LEURS MODES D'EMPLOI.

## TEST DE L'API

Importer  FRIK SMS.postman_collection.json sur Postman puis passer au test de l'API
