# Test assignment

For the test assignment, we have a partly finished banking application (created only for test assignment purposes), where one account can send money to another.
This application is far from perfect, so we need you to fix and finish it by paying attention to these factors:
 * **Security** - we do not want to be hacked
 * **Best practices** - code should be clean and easy to maintain
 * **Documentation** - provide information on how to set up the project
 * **Tests** - test the parts that you feel necessary to
 * **Logic** - bank should not allow overspending your balance

Authentication **IS NOT** in the scope of this assignment. Getting the transactions list with the request `GET /accounts/<id>/transactions` is not a security hole.

Use this repository as your starting point but **DO NOT** fork it. Create a public repository on GitHub for your application source code, push it and send a link to jobs@mailerlite.com.

Code quality in this repository **DOES NOT** represent code quality in MailerLite.

-------------------------------------------------------------------------------------------

Having completed most part of this system, here is a brief summary of how to set the system up:
* Kindly clone, fork or download this repo. 
* Open terminal and change directory to api
* Create a .env file by running touch .env or use your IDE to create it.
* Run composer install
* Run php artisan key:generate
* Run php artisan migrate --seed
* And then run php artisan serve
* Change directory to web, cd ../web
* Run yarn install
* Run yarn dev
* After this, you can open localhost:8000 to see the api documentation
* Open localhost:3000 to see the application and play with it.

