This is a REST API server (2 POST and 2 GET requests), made in accordance with the API documentation attached to this letter.

An interface part has also been implemented, which in particular includes registration and authorization forms, and displays a list of users.

The server is implemented based on the Laravel 10 framework using MySQL, Sail, Breeze&Blade, Sanctum.

The initial filling of the database was done by the seeder using the FakerPHP / Faker library.

Database query research was performed using Laravel Telescope.

API request generation was performed using Postman Desktop.

Images uploaded to the server were processed using the tinypng.com API.

The server saves images  in WebP, JPEG and PNG formats.

Uploaded images are stored on AWS S3.

The server is deployed on Heroku hosting at: https://test-abz-agnc-a518be37dcee.herokuapp.com.
