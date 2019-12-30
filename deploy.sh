#!/bin/bash
cd ~/public_html/digiloop-api/

php artisan migrate

chmod -R 777 storage public vendor bootstrap database .git
