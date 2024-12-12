# ERP-Systeem

Deze repro bewaart de up to date versie van het ERP-Systeem, In deze readme staan de volgende punten benoemd:
- Waarvoor is dit?
- Requirments installatie.
- Installatie.

## Installation

### 1. Clone the repository:
```bash
    git clone https://github.com/Aiden20021/ERP.git
```
### 2. Ga naar de project folder
```bash
    cd DigitalSignage-client
```
### 3. Installeer de benodigde dependencies:
```bash
    sudo apt-get update && sudo apt-get upgrade -y
    sudo apt install apache2 php php-cgi php-mysqli php-pear php-mbstring libapache2-mod-php php-common php-phpseclib php-mysql mariadb-server
```
```bash
    sudo mysql_secure_installation
    sudo apt install phpmyadmin
```

   - `apache2` - Gebruikt voor site hosting.
   - `php` - Om te verbinden met de MariaDB database.
   - `mariadb-server` - Gebruikt om de database te hosten.
   - `phpmyadmin` - Gebruikt om de database grafisch te beheren en te installeren voor het project.

## Bronnen:
Installatie bron:

https://phoenixnap.com/kb/how-to-install-phpmyadmin-on-debian

phpmyadmin van eigen wiki.
Installatie op deze manier niet geverifieerd
