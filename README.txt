Greg Sciarretta
Stash Senior Backend Engineer Coding Challenge

Problems:
    1. Routing - Need to convert a url to executable code.
    2. Data Validation: Need to ensure queries with bad data don't save and report what is wrong with them.
    3. Password Encryption - Need to save passwords in a secure format.
    4. Key Generation - Need to generate a secure key locally.
    5. Third Party Account Key Generation - Need to fetch account_keys from an unreliable third party and retry on failure.
    6. Keyword Search - Need to implement keyword search on saved users.
    7. JSON Responses - Need to return properly formatted JSON responses with HTTP status codes.
    8. Tests - Need to include a test suite with good test coverage.

After fully reviewing the challenge my initial reaction was that the vast majority of the significant problems were things solved easily by using a proper web framework. In a real world scenario nobody wants you to reinvent the wheel so this made a lot of sense to me. I chose php and Laravel because its most familiar to me and I wanted to be able to focus my effort on showing good design rather than learning something entirely new and I knew Laravel has robust solutions to many of the given problems.

Solutions:
    1. Routing - Laravel allows easy mapping of verbs/routes to controllers.
    2. Data Validation - Laravel has a simple form validation syntax that automatically outputs explanations of errors. Relied on MySql's Unique Indexes to report on duplicates for unique fields and formatted the response the same way as Laravel so that an API user wouldn't be able to tell the difference.
    3. Password Encryption - Generated a random salt value using a crypto-secure randomization function and saved that in the database alongside the salted and hashed password. The hash function was chosen from a list of secure functions and used key stretching to slow down the hash process. This makes a negligible difference in our own function calls but makes brute forcing much slower. https://crackstation.net/hashing-security.htm
    4. Key Generation - I just stuck to a relatively simple hash function that salted with an XOR of a secret key. It was unclear what the exact purpose of the key was from documentation but I felt the Password Encryption function was a good demonstration of security so I did not go too crazy.
    5. Third Party Account Key Generation - I used Guzzle for an Http Client since using curl directly is rather convoluted. Laravel provides a robust system for triggering asynchronous jobs that run in the background and are automatically retried periodically a set number of times.
    6. JSON Responses - Laravel provides a robust response formatter that lets me just pass anything with a JsonSerialize method to it. I used the JsonSerializableInterface with my Models to make them compatible.
    7. Keyword Search - I implemented this using ElasticSearch since I'm very familiar with the technology and it allows for much more future growth than MySql's full-text searching. ElasticSearch is more scalable and lets us do fuzzy searched out of the box meaning you can do a keyword search with a typo or misspelling in your query and still get matches.
    8. Tests - Laravel comes with support for the phpUnit testing framework. I exploited dependency injection wherever possible to make more easily unit testable code. I also used the Mockery library to create mocks of dependencies that might hit unreliable external resources and to isolate the functionality of a test to a single class.

What's included:
    1. Laravel App, all stored in the root of this zip.
    2. stash_dhc_repo.json - A collection of curls that can be used with DHC Http Client to interact with the API. They're pretty simple, the only interesting thing is that the header "X-Requested-With:XMLHttpRequest" is used. Laravel's normal behavior on bad calls is to redirect to the index. This header stops that behavior so you can see validation failure messages.
    3. stash_dump.sql - run with "mysql -u username –-password=your_password stash < stash_dump.sql"
    4. phpunit_dump.sql - The test DB, same as stash_dump.sql run with "mysql -u username –-password=your_password phpunit < phpunit_dump.sql

What's Required:
    1. php7.1
    2. mysql >= 5.6.5
    3. Java (version required depends on ElasticSearch version, newest ElasticSearch requires >=  1.8.0_131)
    4. ElasticSearch - Any version should work
    5. A php server such as Apache

Instructions:
    1. Unzip into a location such as /var/www/stash
    2. Install php
    3. Install java
    4. Ensure that your JAVA_HOME path variable is set to point to your Java installation as ElasticSearch needs it
    4. Install mysql
    5. mysql -u username –-password=your_password stash < stash_dump.sql
    6. mysql -u username –-password=your_password phpunit < phpunit_dump.sql
    7. laravel is configured to access mysql using the username 'api-rw' and password 'getschwifty' but you can edit DB_USERNAME and DB_PASSWORD in .env to whatever you want
    8. phpunit is configured to access mysql using the username 'phpunit' and password 'whocaresitsfortests' but you can edit DB_USERNAME and DB_PASSWORD phpunit.xml to whatever you want
    9. Install ElasticSearch
    10. From your Elasticsearch directory run ./bin/ElasticSearch and leave it running. It should not require any configuration, but you can run "curl -XGET localhost:9200" to see if its working. You should see some version info and a slogan if its working.
    11. Configure your web server to host this directory, the main index file is public/index.php, and ensure php is enabled.
    12. Ensure your server has write access to the "storage" directory and all of its contents.
    13. run "php artisan queue:listen" and leave it running in the background this is the process that listens for our asynchronous jobs. If its not running the program will still work but account_keys will not be generated and new users won't have full text search until its turned on.
    14. You should be able to curl the API now (using the DHC collection if you wish) and run the test suite with "php phpunit.phar"

I know this is a large amount of setup. I'm happy to bring in my laptop with this already done to make things easier.

Important Directories:
    1. app/Http/Packages - This is the vast majority of custom-written code.
    2. database/seeds - These are used to setup the DB for testing.
    3. .env - Contains db login info.
    4. app/Providers - GlobalServiceProvider.php provides some custom IoC bindings.
    5. storage - where Laravel stores logs and temporary data. Your web server needs write permission to this directory.
    6. config/app.php registers some custom Service Prvoiders

