# Laravel-Luna-Preset

This package is a addon for laravel presets to help setup Luna-sass with laravel.


This package will do all the necessary setup steps like altering the following file


### Webpack:
Change scss to sass and adding the ability to copy images for resources folder to public folder.


### Sass: 
Copy file from Luna--sass in node_modules and setting up the variables file and adding the correct file locations for icon fonts.


### Javascript: 
Instant setup for javascript needed for Luna-sass to work.


Files: This also setup all the view files for you, including authentication views.



### Installation: 

` composer require designbycode/laravel-luna-presets `

After installing the package run the following commands.

`php artisan preset luna`


Then run one of the two commands below.

`yarn` or `npm install`


After everything is installed simply run the `php artisan luna:start` 


You will be prompt to setup authentication. Make selection and run npm commands as normal.
