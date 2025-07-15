# 🎓 Système de gestion de la Maison des Lycéens (MDL)

Ce projet vise à fournir un outil numérique pour la gestion d’une **Maison des Lycéens (MDL)** dans un établissement scolaire. Il permet de centraliser les informations liées aux adhérents, abonnements, sanctions et à l’historique du foyer.

## ✨ Fonctionnalités

* Gestion des adhérents (ajout, modification, suppression)
* Suivi des abonnements par adhérent
* Création en un clic de la carte d'adhérent et envoi par e-mail
* Création et personnalisation des types d’abonnements (durée, tarif, etc.)
* Attribution de sanctions et suivi de l’historique disciplinaire
* Historique des ouvertures du foyer (dates, heures, responsables)
* Consultation des profils et statuts d’accès
* Différents niveaux d'accès (administrateurs, responsables, utilisateurs)

## 🎯 Objectifs

* Simplifier le fonctionnement quotidien de la MDL
* Suivre précisément les accès et les droits des adhérents
* Aider à la prise de décision avec des historiques clairs

## 🛠️ Installation

[Docker](https://www.docker.com) est la solution la plus simple pour installer l'interface.
Sous macOS et Linux :

```bash
git clone https://github.com/CommandMaker/gestion-mdl
cd gestion-mdl
make run-prod # Voir le Makefile pour plus de détails sur cette commande
```

## 🤝 Contribuer

Les contributions sont les bienvenues !

Tous le code proposé doit être formatté et vérifié (`make prepare-commit` pour le faire rapidement).

Le serveur de développement peut être lancé avec Docker :
```bash
make dev # Lance le serveur de développement
make prepare-dev # En parallèle pour préparer l'environnement
```

Merci à toutes les personnes qui souhaitent améliorer ce projet pour les lycéens 🙌

---

## Licence

Le projet est distribué sous licence **GNU GPL v3.0**. Voir le fichier LICENSE pour plus d'information

**Projet développé dans un cadre éducatif et associatif.**
**Fait avec ❤️ par Command_maker**
