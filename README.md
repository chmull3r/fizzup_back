# fizzup_back

Fizzup_back est une api en Symfony6 / Php8. Elle est contenue dans un container Docker d'une image Php~Apache.
Cette Api permet de récupérer des articles de randonnées, les commentaires des utilisateurs associés et de poster de nouveau sur la randonnée de son choix.
Les commentaires sont stockés dans une base de donnée mySQL.
Il est possible d'interragir avec l'API via POSTMAN ou son navigateur à l'adresse localhost:8740.

## Build Setup

~ Github

```bash
# clone le projet via SSH
$ git@github.com:chmull3r/fizzup_front_ui.git
```

~ Docker
```bash
# build l'environnement Docker
$ docker-compose build

# up le container pour démarrer le serveur nodeJS
$ docker-compose up -d

# vérifier que le container cosmic_ui a démarré (Started | Running)
$ docker ps -a
```
~ Symfony / Doctrine

```bash
$ php bin/console doctrine:migrations:migrate  | Jouer les migrations pour build la base de données.
```

~ mySQL

```bash
init.sql | Provisionner la base de données avec les commentaires pré-enregistrés dans ce fichier.
```

## Endpoints 

```bash
/comments | Récupérer l'ensemble des commentaires enregistrées en base de données.
```

```bash
/comment/new | Enregistrer un nouveau commentaire.
```

```bash
/article | Récupérer un exemple d'article de randonnée.
```

## Sources 

https://medium.com/@meherbensalah4/how-to-dockerize-symfony-project-f06bcd735308

https://nuxtjs.org/deployments/koyeb#dockerize-your-application

[//]: # (https://www.appsloveworld.com/docker/100/18/get-http-api1337-games-neterr-name-not-resolved-for-nuxt-js-pages-using-asyn)

[//]: # ()
[//]: # (https://stackoverflow.com/questions/55090038/get-http-api1337-games-neterr-name-not-resolved-for-nuxt-js-pages-using-asy)

