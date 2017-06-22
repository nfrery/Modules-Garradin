# Modules pour Garradin

Dépôt de différents modules pour Garradin.
Ils ont été réalisé par et pour l'administration d'une association.

## Par où commencer

Retrouvez l'ensemble du code des modules dans les dossiers portants leurs noms.
Dans le dossier *release* se trouve l'ensemble des modules prêt à l'usage, sous la forme nom_module.tar.gz
Les anciennes versions publiées sont dans le dossier *release/old* sous la forme nom_module-version.tar.gz

### Prérequis

Chaque module a été développé pour la version 0.7.6 de Garradin.

### Installation

Copier le module, présent dans release, dans le dossier plugin/ de votre instance Garradin.
L'installation du module se passe dans la rubrique Configuration->Extensions

## Liste des modules présents

* plugin-test: plugin fourni par Garradin comme exmple pour le développement
* plugin-recu-don: module permettant de remplir le cerfa 11580*03 pour permettre la déduction fiscale d'un don.
* plugin-mailchimp: gestion d'une liste sur mailchimp. Fonctionne avec Garradin >=0.8.0.


## Liste des modules à faire

* plugin-recherche-avancee: module qui permet, comme son nom l'indique, d'effectuer des recherches avancées sur la base de données. Il permet d'échapper à la rédaction de requêtes SQL.
* plugin-fluxbb: module qui sert à faire une liaison entre Garradin et FluxBB. Les membres qui sont à jours de cotisation sur Garradin vont soit avoir un profil, créé par le plugin, sur FluxBB, soit être relié à leurs profils sur FluxBB. Cela permettra de les intégrers à un groupe Adhérents sur FluxBB tant qu'ils seront à jour de cotisation.
* plugin-vote: module qui permet d'organiser des votes lors d'AGO et d'AGE. Chaque membre à jour de cotisation peut voter. Seul les membres d'un group défini par l'admin peuvent gérer les votes.
* plugin-categorie: Sert à fixer une catégorie à une saisie avancée en compta. Permet d'inclure la saisie dans les dépenses ou les recettes.
* plugin-bicycode: permet la tenue du registre.


## Versionnement

Nous utilisons [SemVer](http://semver.org/) pour la gestion des versions.

## Authors

* **Nicolas Frery** - *Travail initial* - [nfrery](https://github.com/nfrery)

Voir la liste des [contributeurs](https://github.com/nfrery/modules-garradin/contributors) qui ont participé à ce projet.

## Licence

Ce projet est sous la licence AGPL v3 - voir la [LICENSE.md](LICENSE.md) pour les détails (en).
