## Requirements
1. <code>"php": "^8.1"</code>
2. Installed composer
3. Installed docker and docker-compose

## Setup process
1. Clone the repository
2. Run <code>composer install</code>
3. If using Docker => Run <code>./vendor/bin/sail up</code> and open <code>http://localhost</code>
4. If using local env => Run <code>php artisan serve</code> and open <code>http://127.0.0.1:8000</code>

## Commands
To create a new author using a command run <code>./vendor/bin/sail artisan qss:create-author</code> and follow the steps.

## Task
Client
- Create a client for connection on Q Symfony Skeleton API (QSS)
- swagger documentation: https://symfony-skeleton.q-tests.com/docs
- credentials: email: ahsoka.tano@q.agency password: Kryze4President
- create a login page that uses Q Symfony Skeleton API, retrieve access token
- store the token using any storage you want (Session, Cookie, something more creative? (Up to you!), with any expiration time (use common sense, 10 seconds is a bad expiration time! :))

Authors
- fetch the list of Authors from the API, display them in a table layout
- enable a user to delete the author if there's no related books for this author
- Create a view page of single authors and their books
- Extra Bonus Part: Symfony CLI command to add a new author using the Q Symfony Skeleton API - this is just for extra points, if you have time ;-) It won’t make you look bad if you show excellent dev skills, but decide to skip this one

Books
- On single author view, enable the user to delete books (one by one)
- create a page where the user can add a new Book and select Authors from a dropdown menu

Profile
- after the user logs in - show his first and last name on the base page layout
- add logout link or button
