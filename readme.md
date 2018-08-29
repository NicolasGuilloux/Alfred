# Alfred

Based on **_[Laradminator](https://github.com/kossa/laradminator)-**.
[Laravel](https://laravel.com/) PHP Framework with [Adminator](https://github.com/puikinsh/Adminator-admin-dashboard) as admin dash.

This a project made for the final project of the [Master of Science Interactive Media](https://www.ucc.ie/en/ckr05/) of the [University College Cork](https://www.ucc.ie/).


## Setup:
All you need is to run these commands:
```bash
git clone https://github.com/NicolasGuilloux/Alfred.git
cd alfred
composer install                   # Install backend dependencies
sudo chmod 777 storage/ -R         # Chmod Storage
cp .env.example .env               # Update database credentials configuration
php artisan key:generate           # Generate new keys for Laravel
php artisan migrate:fresh --seed   # Run migration and seed users and categories for testing
php artisan storage:link	   # Make the public folder in the storage accessible from a link
yarn install                       # or npm i to Install node dependencies
npm run production                 # To compile assets for prod
```

To install everything from scratch (no Nginx, no sql, nothing):
```bash
git clone https://github.com/NicolasGuilloux/Alfred.git
cd alfred
chmod +x install_raspberrypi.sh
./install_raspberrypi.sh
```


## Demo:
- Online demo: Can be found at [alfred.nicolasguilloux.eu](http://alfred.nicolasguilloux.eu/)

**Note:**  
Username: test@test.com      
Password: testtest

***

## Included Packages:

* ALL PACKAGES from Laradminator [here](https://github.com/kossa/laradminator#included-packages)
* Chart.js
