# portfolio

## Installation

### Installer les dépendances Composer 

`composer install && composer update`

### Installer les dépendances Javascript 
 
`npm install`

### Paramétrer l'accès à la base de données
 - Créer un fichier `.env.local` (dupliquer le `.env`) 
 - Décommenter la ligne `DATABASE_URL=` pour MySQL et changer user, password, db_name en fonction de votre base 
 - Commenter les autres lignes `DATABASE_URL=` si nécessaire

### Génerer les assets avec Webpack Encore 

`npm run dev`

### Lancer le serveur de dev 

`symfony serve`
 
 & Voilà !
