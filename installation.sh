echo 
success '+--------------------------------------------------------+'
success '+ 		Mise à jour / Installation des packages   +'
success '+--------------------------------------------------------+'
sudo apt update && sudo apt upgrade -y
sudo apt install apache2
sudo apt install php
sudo apt install git
sudo apt install unzip
sudo apt install mariadb-server

sudo mysql -e "CREATE USER 'clelia'@'localhost' IDENTIFIED BY 'Fuy3zEmySQ7**/';"
sudo mysql -e "GRANT ALL PRIVILEGES ON * . * TO 'clelia'@'localhost';"

echo 
success '++++++++++++++++++++++++++++++++++++++++++++++++++++++++++'
success '+			php my admin			  +'
success '++++++++++++++++++++++++++++++++++++++++++++++++++++++++++'


sudo apt install phpmyadmin

echo "Récupération de l'archive git"
wget https://github.com/clelialandru/kaiserstuhl/archive/refs/heads/main.zip
unzip -q main.zip
mv -v /kaiserstuhl-main/* ..

sudo chown -R www-data /var/www/html
sudo chmod -R g+w /var/www/html

sudo systemctl restart apache2
