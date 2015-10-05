# greenpi
Arrosage automatique

###Prérequis:

####Informatique :

- Installtion wiringpi :
          sudo apt-get install git-core
          git clone git://git.drogon.net/wiringPi
          cd wiringPi
          git pull origin
          ./build
          
- Installation Raspbian, php5, apache2 (aptitude install php5 apache2)

####Electronique :

- Sonde D18B20 pour la temperature, avec une résistance de 4.7kOhm entre data et vcc
- Capteur humidité type Groove ou YL-69
- Carte relais 5v/220v pour la lumière, la pompe et les ventillateurs

###Installation :

Copier les deux fichiers : configuration.php et index.php dans le repertoire web (/var/www/)
Configurer les pins dans configuration.php (voir : http://mchobby.be/wiki/images/c/c0/Pi-WiringPi-GPIO-01.png)
