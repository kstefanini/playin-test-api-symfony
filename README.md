# Test de recrutement Playin

## Installation du test

```shell
# Installation des dépendances
composer install

# Si vous souhaitez utilisez le conteneur Docker, lancez ce groupe de commandes
docker-compose build --pull --no-cache
docker-compose up -d
docker-compose exec php php-fpm -D

# Si vous recevez ce message :
# the input device is not a TTY.  If you are using mintty, try prefixing the command with 'winpty'
# winpty docker-compose exec php php-fpm -D

# Préparation de la base de données
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console hautelook:fixtures:load
```


### Lancement des tests

```shell
php bin/console doctrine:database:create --env=test
php bin/console doctrine:migrations:migrate --env=test
php bin/console hautelook:fixtures:load --env=test
php vendor/bin/simple-phpunit
```

## Consignes

Lors de la validation d'une commande (`Order::setValidated(true)`), les quantités
vendues dans les stocks et les dépôts doivent être mises à jour. Les stocks et
les dépôts se vident dans l'ordre FIFO (le premier stock crée est le premier vidé).

Pour cet exercice, on considère que les dépôts sont toujours vidés avant les stocks.

Lors de la validation d'une commande, une association doit également être créée pour
relier la commande au stock ou au dépôt qui lui correspond.

L'objet qui représente l'association doit comporter une propriété calculée,
la marge réalisée lors de la vente. Dans le cas d'un dépôt, cette marge est calculée
avec le prix de vente et le pourcentage reversé au dépositaire. Dans le cas d'un stock,
elle est calculée en fonction du prix de vente et du prix d'achat (les questions
relatives à la TVA sont ignorées dans le cadre de ce test.)

## Objectifs

L'entité `Association` a été créée, mais elle est vide. Vous devez la remplir, en
vous aidant des champs de la table `t_assoc` en base de données et exposer les
points d'entrée d'API relatifs à cette entité.

---

**Mise en garde** : Consultez bien la migration, en fonction du champ `t_assoc.vendeur`,
le champ `t_assoc.id_detail_stock` ne fait pas toujours référence à la même table !
Consultez les commentaires de la migration, et résolvez le problème de la manière qui
vous semble la plus judicieuse.

---

Vous devez modifier le comportement de `Order::setValidated()` afin que les quantités
et les quantités vendues soient bien mises à jour et que l'association soit bien créée.
(Pour ce faire, vous pouvez modifier `Order::setValidated()` directement ou utiliser
une autre méthode qui vous semble plus judicieuse.)

Vous pouvez créer de nouveaux tests unitaires ou fonctionnels pour vérifier ce que vous
avez codé, ce serait appréciable, mais ce n'est pas obligatoire. 
