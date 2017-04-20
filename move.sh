rm -rf /var/www/html/*
cp -r html/* /var/www/html/
rm /var/www/html/template.php
chown www-data /var/www/html
chgrp www-data /var/www/html
chmod 700 /var/www/html
