<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Events-calendar. Deployment of the project

- git clone https://github.com/NazarH/online-store.git to project folder
- git clone https://github.com/Laradock/laradock.git to laradock folder
- Install Docker to local machine
- Configure laradock (PHP 8.2)
- Create .conf file in laradock folder - nginx/sites
- Edit hosts file. Write "sudo nano /etc/hosts" in terminal , and add "127.0.0.1       online-store.test" to file
- Run docker container with command "docker-compose up -d nginx mysql phpmyadmin redis workspace"
In container, in project repository:
- composer install
- npm install
- npm run dev
- php artisan migrate
- php artisan db:seed --class=PrimarySeeder
- php artisan db:seed --class=DummySeeder
- Install ngrok (and register a new account)
- Use command to access to ngrok server (in command line)
- Add generated address, from ngrok, to NGROK_URL= in .env file
- Mailtrap was used to send mail locally (need to register and attach it to the .env file)
- php artisan schedule:work (for send notifications & generate sitemaps)
- Go to admin panel, by link - /login:
  Login: admin@app.com
  Password: password

