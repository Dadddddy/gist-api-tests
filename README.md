# Gist API Tests

This tiny test project aims to cover the following contexts:
1. Testing gists accessibility in unauthorized/authorized context
2. Testing rate limiting in unauthorized / authorized context
3. Testing of most common REST API methods using simple CRUD operations

Requirements: (For Linux Operating System):
1. Clone the project and navigate to `/gist-api-tests` directory.
2. install PHP and the following PHP dependencies :

```
sudo apt install php
sudo apt intsall php-curl
sudo apt install php-mbstring
sudo apt install php-zip
sudo apt install php-dom
```
3 . After php installation is complete, install php composer by running the following commands (while you are in root directory of the project which is `\gist-api-tests`:
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```
#####Note: 
The hash in the second command will change on every composer update. So if it was not valid in the time your installing composer, please visit `https://getcomposer.org/download/#main` to download the latest version.

4 . After the installation is complete, you will see a `composer.phar` file in the project directory. Now run the following command to install the test project dependencies which is listed in `composer.json` file:

```
php composer.phar install
```
By running this command, composer will install all the project dependencies which are in the composer.json file.

5 . Now you will see a new directory in the project directory named `vendor`. Run the following command to build the project essential libraries:
```$xslt
vendor/bin/codecept build
```
6 . Run the following command to create a .env file from the .env.example while you are in the root directory of the project.

```
cp .env.example .env
```
7 . Open the `.env` file. You will see the following lines:

```
GIST_BASE_URL= https://api.github.com
OAUTH_TOKEN= ***************************
GIST_USER = *****
```
The authorised test scenarios of this project use the value of `OAUTH_TOKEN` & `GIST_USER`. So please Provide a valid gist Oauth Token and its coresponding git hub username and replace them with the star values in `.env` file and save it.

8 . Congratulations! Now you are good to run the tests. There are 4 php files in the path `tests/api/` with the following names:
```$xslt
GistCreataionCest.php
GistDeleteCest.php
GistEditCest.php
RateLimiterCest.php
``` 
Each file includes the tests cases of their file name in both authorise and unauthorised context.
To execute the test cases, run the following command:
```
vendor/bin/codecept run tests/api
```
This command will run all the test files which are inside the `api` suite. To run the test cases separately, include the file name after the suite name. e.g.:
```
vendor/bin/codecept run tests/api/GistCreationCest.php
```
This 2 commands will run the tests in CLI and you can see the results there. You can run the command with the ` --html ` flag to get a graphical report of the test run results which will be stored in `tests/_output/report.html`. You can run the tests having step by step detail by using `--steps` flag. Codeception has lots of other cool feature which you can access by reading its manual. Just run :
```
vendor/bin/codecept --help
```
###Important NOTE : 
Make Sure the Ouath Token  & git hub username that you put in `.env` file, belong to a non-important git hub account, since in some test cases, I delete all the gists of the account for preparing the environment for some of the test cases.


#Why Codeception:
I have worked with many API testing tools and frameworks like Robot Framework, SoapUI(which is barely an automation tool). But the reason that I chose Codeception over the other tools is that codecption is a very strong testing tool which has the following benefits:
1. Strong library for Rest API testing, Acceptance Testing, Unit Testing making the test case writing very easy and super human readable. 
2. Strong Reporting utilities
3. Supporting a DataProvider feature which enables us to run a test case with different data inputs.
4. Supporting shuffled testing which we can run tests in random orders.
5. Most important of all is that it enables us to use the power of a programming language like php which can be very use full in many cases like complicated validations etc.
6. Strong documentation & Community that is a great help in many cases.

To find out more about the capabilities of this tool please visit :
https://codeception.com


 