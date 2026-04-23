# QuickField

## Présentation du Projet
**QuickField** est une plateforme web moderne de réservation de terrains de football locaux. Elle met en relation les joueurs et les gestionnaires de terrains dans le but de digitaliser les réservations, sécuriser les revenus via un système d'acompte en ligne, et simplifier la gestion des plannings.

## Stack Technique
* **Front-End :** HTML, JavaScript, Tailwind CSS (Design Responsive & Mobile First)
* **Back-End :** Laravel (PHP) - Architecture MVC
* **Base de Données :** MySQL
* **Gestion des Rôles (ACL) :** Spatie Laravel Permission
* **Outils :** Figma (Maquettage UI/UX), Jira (Gestion de projet)

## Rôles et Fonctionnalités

### Super Admin (Administrateur Plateforme)
* **Validation KYC :** Vérification des documents pour l'activation des Managers.
* **Gestion des Utilisateurs :** Modération et système de Blacklist.
* **Suivi Financier :** Dashboard global (Volume d'affaires, commissions, paiements).
* **Gestion des Litiges :** Accès aux logs de réservation.
* **Configuration :** Paramétrage des taux, CGU, et mode maintenance.

### Terrain Manager (Gestionnaire du Stade)
* **Gestion du Planning :** Heures d'ouverture/fermeture et blocage manuel (anti double-booking).
* **Tarification Dynamique :** Prix variables selon les créneaux (matin vs soir).
* **Gestion du Staff :** Création des comptes pour les Agents de Sécurité.
* **Dashboard Manager :** Suivi des revenus et statistiques d'occupation.
* **Disponibilité :** Activation/Désactivation rapide du terrain (météo, travaux).

### Agent de Sécurité (Staff sur place)
* **Interface Mobile :** UI simplifiée pour le terrain.
* **Scan QR Code :** Vérification des tickets joueurs (Vert = Validé, Orange = Reste à payer, Rouge = Invalide).
* **Encaissement :** Validation de la réception des 50% restants sur place.
* **Planning du Jour :** Liste textuelle de secours en cas de panne internet.

### Utilisateur (Joueur)
* **Recherche & Filtres :** Localisation, prix, type de terrain (5vs5, 7vs7).
* **Réservation 50/50 :** Paiement d'un acompte pour bloquer le créneau.
* **Gestion des Tickets :** Accès aux QR Codes et à l'historique des matchs.
* **Feedback :** Système de notation accessible uniquement après le match.
* **Gestion de Profil :** Favoris et annulations sous conditions.

## Flux de Réservation (User Flow)
1. Le joueur choisit un terrain et une heure.
2. Il paie 50% du montant via la plateforme de paiement.
3. Le système génère un QR Code avec le statut *"En Attente"*.
4. À l'arrivée au stade, l'agent de sécurité scanne le QR Code.
5. Le système indique le montant restant à payer en espèces/sur place.
6. Une fois le solde réglé, le statut passe à *"Validé"* et l'accès au terrain est autorisé.

## Installation & Configuration Locale

1. Cloner le dépôt :
   ```bash
   git clone https://github.com/mohamed-bouth/QuickField.git
   cd quickfield