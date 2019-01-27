# Modules pour Garradin

Dépôt **non officiel** de différents modules pour Garradin.
Ils ont été réalisé par et pour l'administration d'une association.

## Aide, demande, question

Une liste de discussion est disponible pour échanger, s'entraider, poser vos questions et demander des modifications pour les plugins présent sur ce dépôt.
Pour s'abonner: https://framalistes.org/sympa/subscribe/module_garradin_nfrery
Pour se désabonner: https://framalistes.org/sympa/sigrequest/module_garradin_nfrery

## Par où commencer

Retrouvez l'ensemble du code des modules dans les dossiers portants leurs noms.
Dans le dossier *release* se trouve l'ensemble des modules prêt à l'usage, sous la forme nom_module.tar.gz
Les anciennes versions publiées sont dans le dossier *release/old* sous la forme nom_module-version.tar.gz

Si vous souhaitez réaliser une archive vous-même des plugins en cours de développement, faite le à vos risques et périls. Votre base de données sur votre instance Garradin pourrait être endommagée !

### Installation

Récupérer l'archive du module dans le dossier _release_  et copier le dans le dossier plugin/ de votre instance Garradin.
L'installation du module se passe dans la rubrique Configuration->Extensions

## Liste des modules (>=0.9.0)

## Liste des modules présents (compatible <<0.9.0)

* plugin-test: plugin fourni par Garradin comme exmple pour le développement (>=0.1)
* [plugin-recu-don](https://github.com/nfrery/Modules-Garradin/raw/master/release/recudon.tar.gz): module permettant de remplir le cerfa 11580*03 pour permettre la déduction fiscale d'un don. **Attention, ce plugin n'est pas abouti** (>=0.7.6)
* [plugin-mailchimp](https://github.com/nfrery/Modules-Garradin/raw/master/release/mailchimp.tar.gz): gestion d'une liste sur mailchimp. Fonctionne avec Garradin >=0.8.0.
* [plugin-benevolat](https://github.com/nfrery/Modules-Garradin/raw/master/release/benevolat.tar.gz): Valoriser facilement le bénévolat sur Garradin >=0.8.0

## Liste des modules en cours de réalisation
* plugin-bicycode (fonctionne avec 0.8.0): permet la tenue du registre pour les opérateurs bicycode. Pour plus d'info sur ce service [bicycode.org](https://www.bicycode.org/le-bicycode.rub-2/qu-est-ce-que-c-est.rub-68/).
* plugin-cotisation-avancee: Permet une saisie avancée lors de l'enregistrement d'une cotisation. Prend en compte les prestataires de services (467x) tel que iZettle, HelloAsso, etc pour ne pas débiter directement le compte courant (512x) de l'association. Il enregistre les chèques comme étant à encaisser (5112).
* plugin-requeteur: Entrepose et execute vos requêtes SQL en lecture seule.

## Liste des modules au stade d'idées

* plugin-fluxbb: module qui sert à faire une liaison entre Garradin et FluxBB. Les membres qui sont à jours de cotisation sur Garradin vont soit avoir un profil, créé par le plugin, sur FluxBB, soit être relié à leurs profils sur FluxBB. Cela permettra de les intégrers à un groupe Adhérents sur FluxBB tant qu'ils seront à jour de cotisation.
* plugin-vote: module qui permet d'organiser des votes lors d'AGO et d'AGE. Chaque membre à jour de cotisation peut voter. Seul les membres d'un group défini par l'admin peuvent gérer les votes.
* plugin-categorie: Sert à fixer une catégorie à une saisie avancée en compta. Permet d'inclure la saisie dans les dépenses ou les recettes.
* plugin-statistiques: Générateur de graphique en fonction de tout et n'importe quoi. (compta, membre, etc)
* plugin-sms: envoi d'sms collectif, envoi de rappel automatique de cotisation (support ovhtélécom)

## Versionnement

Nous utilisons [SemVer](http://semver.org/) pour la gestion des versions.

## Authors

* **Nicolas Frery** - *Travail initial* - [nfrery](https://github.com/nfrery)

Voir la liste des [contributeurs](https://github.com/nfrery/modules-garradin/contributors) qui ont participé à ce projet.

## Licence

Ce projet est sous la licence AGPL v3 - voir la [LICENSE.md](LICENSE.md) pour les détails (en).
