# LarAppointment

LarAppointment is an open source web application for online appointment management. Larappointment is based on Laravel framework written by Panagiotis Bakas and George Noukos with the supervision of Dr. Minas Dasygenis, Lecturer at University of Western Macedonia 

## Installation

Installation using Git and Composer dependency manager 

```bash
git clone https://github.com/gnoukos/larappointment.git
cd larappointment
php composer.phar install
```
Then you have to create an .env file with the configuration settings of your application. An example .env file could be found [here](https://github.com/laravel/laravel/blob/master/.env.example). Please make sure that your .env file contains those 5 lines in order to have a working job queue 

```bash
BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

After that run the following commands 

```bash
php artisan key:generate
php artisan migrate
```
Recommended file permission are "755" for folders and "644" for files


## Usage

Login using the default user account

E-mail: admin@admin.com
Password: admin

Please make sure to change your default user info
