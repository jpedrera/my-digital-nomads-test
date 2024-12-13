## Relevant information
Please consider that this is a simple project with time contraints. 
Some areas could be improved or refactored but I prioritised being on time.
If you see any relevant area where you think you noticed any lack of knowledge or good practices please let me know and let's discuss it during the interview.

## Installation
There's a makefile referencing instructions to a dockerfile in charge of the installation process.
Place yourself in the root of the project and run:

`make install`

then run

`php artisan serve`


I have attached a postman collection with the endpoints to test the API.
This resides in the project root folder; `my_digital_nomads.postman_collection.json`

This should use a prepopulated token from the seeder in the header, but you can create a new one by calling the register and login endpoint.

## Decisions made
A mix of approaches can be found with the intention of showing different ways of doing things.
#### General API
* Versioning throttling and rate limiting of the api could be contemplated
#### HandleApiResponses Trait
* This could be extended and improved with more methods to handle different types of responses


Hope you liked it, I'm looking forward to discuss any areas you may consider relevant.

