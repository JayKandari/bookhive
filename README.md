# Bookhive (Library Management System)
PHP application to demonstrate OOP concepts.

## Key Features:
- Add/Delete Books
- Register as a Customer
- Order a book
## Structure of repository
* asset
  - css: all the `CSS`/`SASS` files
  - js: all the `javascript` files
  - images: all the image files (`jpg`,`png`,`gif` etc)
* public-html: all the publicly visible files like `index.html` etc.
* resources
  - src: all the php files which contains `class definitions`.
  - template: all the template files for layout e.g `header`, `sidebar` etc.

## Setup
### 1. Clone the project into the PHP site root
```bash
$ git clone https://github.com/JayKandari/bookhive
$ cd bookhive
```

### 2. Place a file named `dbcred.json` in the root fo the project, with the following info
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

### 3. Install composer. You may use the guide here [DigitalOcean Install Composer](https://www.digitalocean.com/community/tutorials/how-to-install-composer-on-ubuntu-20-04-quickstart)

After install run the following command in the root. (this will install any dependencies or load autoload)
```bash
$ composer install
```

## TODO:
### Web Pages
- [ ] Home
- [ ] Book display
- [ ] Register
- [ ] User home
- [ ] Profile settings
- [ ] Admin controls
### Core packages
- [ ] DBMS Management
- [ ] Session-Cookie Management

## Contributors:
- [Aastha](https://github.com/shriaas2898) (@shriaas2898)
- [Alphons](https://github.com/AJV009) (@AJV009)
- [Anjali](https://github.com/anjali-rathod) (@anjali-rathod)
- [Pragati](https://github.com/pragzii3896) (@pragzii3896)
