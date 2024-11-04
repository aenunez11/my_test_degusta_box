# My test Infonet about Star Wars #
------------------

## Setup Project ##

1. step unzip the **my_test_infonet.zip**

2. Enter the project directory and run **composer install** to generate the vendor

3. Have a Mysql DB manager and create the **my_test_infonet** table

4. execute the migration using the command **php bin/console doctrine:migrations:migrate**

5. to import the star wars information, it is necessary to execute the command **php bin/console starwars:import**

6.Once the configurations are finished, we execute the command **php bin/console cache:clear** to clear the cache and check that everything is fine

7.Last step execute the command **symfony server:start**


## Description ##

The start project shows the characters in a table where you can filter by name. Clicking on the name or the edit icon displays the form to edit the character or delete it

In the movies tab, the list of all the movies is shown and also an icon that, when clicked, displays a table with all the characters in the movie.
