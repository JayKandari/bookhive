# Bookhive (Library Management System)
PHP application to demonstrate OOP concepts.

## Key Features:
- Add/Delete Books
- Register as a Customer
- Order a book
## Structure of repository
* asset
  - css: all the `CSS`/`SASS` files generated from gulp-scss
  - js: all the `javascript` files
  - images: all the image files (`jpg`,`png`,`gif` etc)
  - scss: all the `scss` code
* public-html: all the publicly visible files like `index.php` etc.
* resources
  - src: all the php files which contains `class definitions`.
  - template: all the template files for layout e.g `header`, `sidebar` etc.

## Setup
### 1. Clone the project where you want to setup the site.
```bash
$ git clone https://github.com/JayKandari/bookhive
```
### 2. Setup Virtual Host
* Setup virtual host for the project. You can refer to [this](https://www.digitalocean.com/community/tutorials/how-to-set-up-apache-virtual-hosts-on-ubuntu-16-04) to setup vhost for apache in linux.
* In the `.conf` file specify `DocumentRoot path/to/folder/bookhive/public-html`. **Note:** `path/to/folder/` the path which contains clone of the project.

### 3. Create a database
- Create a database in phpmyadmin named `bookhive` to store all the book details.
- Open the newly created database and import the `bookhive.sql` file provided with the repo. (this file contains all the table structures and so on)

### 4. Install composer. 
You can refer [this](https://www.digitalocean.com/community/tutorials/how-to-install-composer-on-ubuntu-20-04-quickstart) to setup composer.

After install run the following command in the project directory. (this will install any dependencies or load autoload)
```bash
$ composer install
```

### 5. Create config file
Place a file named `dbcred.json` in the resources directory, with the following info

```json
{
  "type":"DB_Type",
  "dbname":"DB_Name",
  "username":"DB_Username",
  "pass":"DB_Password",
  "host":"DB_Hostname",
  "port":"DB_Port_num",
  "baseurl":"Site_BaseUrl"
}
```

## Use [Gulp](https://gulpjs.com/) and [SCSS](https://sass-lang.com/) to work with css
### 1. Prerequisites
Follow this [getting started with gulp guide](https://gulpjs.com/docs/en/getting-started/quick-start) to install gulp and understand what it is all about!

### 2. Run Gulp task
Start the gulp sass 
```bash
$ npm install
$ gulp sass
```

## Contributors:
- [Aastha](https://github.com/shriaas2898) (@shriaas2898)
- [Alphons](https://github.com/AJV009) (@AJV009)
- [Anjali](https://github.com/anjali-rathod) (@anjali-rathod)
- [Pragati](https://github.com/pragzii3896) (@pragzii3896)
