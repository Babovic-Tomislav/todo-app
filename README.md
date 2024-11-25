
# Todo app

This is Todo app project that allows user to login and create multiple todo lists with todo items.



## Installation

### Clone the repository

```sh
git clone https://github.com/Babovic-Tomislav/todo-app.git
cd todo-app
```

### Set up environment variables
Create a .env file in the root directory and add the following variables:
```
MYSQL_ROOT_PASSWORD=your_root_password
MYSQL_DATABASE=your_database_name
MYSQL_USER=your_database_user
MYSQL_PASSWORD=your_database_password
```

### Adjust docker compose

Copy compose.override.yaml.dist into compose.override.yaml and adjust the ports deppending on your machine

### Installing dependancies

Installation is covered using Makefile by running:


```bash
    make dev
```

If you don't have make installed you can run:

```bash
    docker compose up -d
    docker compose exec backend composer install
    docker compose exec backend bin/console d:m:m
    docker compose exec backend bin/console importmap:install
```

### Access the application
Open your browser and go to http://localhost:80. Or any other port you configured to.



## Description

Project has simple registration and login form.

User needs to register to be able to acces the application.

After successful registration user is redirected to login page.

After login user sees his todo lists and items in each of the list.
Each list is clickable and it opens a modal with list details where user can complete a todo list item.

User can also edit the list to add new items or remove old ones.

Deleting the list refreshes removes the list card from the view using js.

## Project arhitecture

Project is created following DDD and CQRS. Every part of the project is split into separate context. Besides that there are added 2 extra PHP Stan rules to ensure that every model is instantiated only from factory to force extra layer of validation before creating the object. Besides that there is rule where Infrastructure implementation of model repository forces developer to extend Interace that extends DomainModelRepositoryInterface to ensure every repository implementation has base needed methods and to force the creation of more specific interface that defines to rule for each model repositoy.