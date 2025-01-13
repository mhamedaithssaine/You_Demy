# Projet Youdemy - Plateforme de cours en ligne

Bienvenue sur le projet **Youdemy**, une plateforme interactive et personnalisée conçue pour révolutionner l'apprentissage des étudiants et des enseignants.

## Aperçu

Youdemy permet aux utilisateurs de s'inscrire, de suivre des cours en ligne et de bénéficier d'une expérience d'apprentissage personnalisée. Le projet est divisé en plusieurs fonctionnalités adaptées aux rôles des visiteurs, étudiants, enseignants et administrateurs.

---

## Fonctionnalités

### Front Office

#### Visiteur :
- Accès au catalogue des cours avec pagination.
- Recherche de cours par mots-clés.
- Création d’un compte avec choix du rôle (Étudiant ou Enseignant).

#### Étudiant :
- Visualisation du catalogue des cours.
- Recherche et consultation des détails des cours (description, contenu, enseignant, etc.).
- Inscription à un cours après authentification.
- Accès à une section “Mes cours” regroupant les cours rejoints.

#### Enseignant :
- Ajoute de nouveaux cours avec des détails tels que :
  - Titre, description, contenu (vidéo ou document), tags, et catégorie.
- Gestion des cours :
  - Modification, suppression et consultation des inscriptions.
- Accès à une section “Statistiques” sur les cours :
  - Nombre d’étudiants inscrits, nombre de cours, etc.

### Back Office

#### Administrateur :
- Validation des comptes enseignants.
- Gestion des utilisateurs :
  - Activation, suspension ou suppression.
- Gestion des contenus :
  - Cours, catégories et tags.
  - Insertion en masse de tags.
- Accès à des statistiques globales :
  - Nombre total de cours, répartition par catégorie, le cours avec le plus d’étudiants, les top 3 enseignants.

### Fonctionnalités Transversales

- Un cours peut contenir plusieurs tags (relation many-to-many).
- Application du polymorphisme pour :
  - Ajouter et afficher des cours.
- Système d’authentification et d’autorisation pour protéger les routes sensibles.
- Contrôle d’accès basé sur les rôles des utilisateurs.

---

## Exigences Techniques

- Respect des principes de la POO (abstraction,Encapsulation, Héritage, Polymorphisme).
- Base de données relationnelle avec gestion des relations (One-to-Many, Many-to-Many).
- Utilisation des sessions PHP pour la gestion des utilisateurs connectés.
- Validation des données utilisateur pour garantir la sécurité.

---



---

## Livrables

- Lien du repository GitHub.
- Lien de la présentation.
- Diagrammes UML :
  - Diagramme des cas d'utilisation.
  - Diagramme de classes.

---

## Critères de Performance

- Séparation claire entre logique métier et architecture.
- Application cohérente des concepts POO.
- Structure et lisibilité du code améliorées.
- Adaptabilité des pages web à tous types d’écrans.
- Validation côté client avec HTML5 et JavaScript natif.
- Validation côté serveur pour éviter les attaques (XSS, CSRF, SQL injection).
- Utilisation de requêtes préparées et échappement des données.

---

## Contributeurs

- [Ait hssaine Mhamed ] - Développement initial et conception.


---

## Licence

Ce projet est sous licence YouCode.
