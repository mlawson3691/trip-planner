# Trip Planner #

#### A social trip planning application built with PHP, October 7th, 2016

#### By Mark Lawson, Ayana Powell, Molly LeCompte, & Aimen Khakwani

## Description ##

This application serves as a tool for users to plan and reflect on their travels. Users can search other users' trips by city for inspiration. Users can also create and edit trip itineraries, as well as leave feedback on their experiences. The application is built with PHP, using the Silex framework, Twig templates, and Bootstrap for styling.

[View the live site here.](https://glacial-lowlands-59035.herokuapp.com/)

## Setup/Installation Instructions ##

* Clone the repository
* Using the command line, navigate to the project's root directory
* Install dependencies by running $ composer install
* Sign into MySQL shell by running $ /Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot
* Start MAMP server and go to MAMP preferences:
    * Set Document Root to project's root directory
    * In the app/app.php project file, make sure the $server variable points to the localhost port listed under Ports>MySQL port in MAMP
* In a browser, go to http://localhost/phpmyadmin
* Select Import from the top menu and choose the compressed .sql files from the projects root directory and click 'Go' to import the databases
* Navigate to the /web directory and start a local server with $ php -S localhost:8000
* Open a browser and go to the address http://localhost:8000 to view the application

## MySQL Setup

* CREATE DATABASE trip_planner;
* USE trip_planner;
* CREATE TABLE users (id serial PRIMARY KEY, username VARCHAR (255), password VARCHAR (255), name VARCHAR (255), bio TEXT, location VARCHAR (255), UNIQUE (username));
* CREATE TABLE trips (id serial PRIMARY KEY, name VARCHAR (255), description VARCHAR (255), user_id INT, complete BOOL default=0);
* CREATE TABLE reviews (id serial PRIMARY KEY, trip_id INT, description VARCHAR (255), rating VARCHAR (255), title VARCHAR (255));
* CREATE TABLE cities (id serial PRIMARY KEY, name VARCHAR (255), state VARCHAR (255));
* CREATE TABLE cities_trips (id serial PRIMARY KEY, city_id INT, trip_id INT);
* CREATE TABLE activities (id serial PRIMARY KEY, name VARCHAR (255), date VARCHAR (255), description VARCHAR (255), trip_id INT);
* (copy database in phpmyadmin to create trip_planner_test)

## Specifications

* The program will sign up new users
    * Example input: username, password
    * Example output: user1

* The program will log in returning users
    * Example input: username, password
    * Example output: user1

* The program will log out users
    * Example input: user1
    * Example output: false

* The program will create trips
    * Example input: name, city
    * Example output: trip1

* The program will add activities to trips
    * Example input: name, description
    * Example output: activity1

* The program will add cities to trips
    * Example input: trip1, Portland
    * Example output: Portland

* The program will add a review to a trip
    * Example input: trip1, review
    * Example output: review

* The program will display all reviews of a city
    * Example input: Portland
    * Example output: review1, review2, review3

* The program will display all trips of a user
    * Example input: user1
    * Example output: trip1, trip2, trip3

## Known Bugs ##

There are no known bugs at this time.

## Support and Contact Details ##

Please report any bugs or issues to mlawson3691@gmail.com.

## Languages/Technologies Used ##

* PHP
* Silex
* Twig
* PHPUnit
* Bootstrap
* Flaticon

### License ###

*This application is licensed under the MIT license.*

Copyright (c) 2016 Mark Lawson, Ayana Powell, Molly LeCompte, and Aimen Khakwani
