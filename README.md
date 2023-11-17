# <a href="https://www.roomvu.com/">RoomVU</a> Backend Service Challenge

This PHP service provides functionality to manage users and transactions. Users can be populated with random data, transactions can be performed for specific users on a particular day, and reports can be generated.


### Prerequisites
-  `PHP 7.4+`
-  `MySQL Database`
-  `Docker`

Clone the repository from:
```shell
git clone https://github.com/yourusername/backend-service-challenge.git
```

Install dependencies:
```shell
composer install
```

Configure database connection:
```shell
Update database connection details in src/Database.php.
```

Run Migrations:
```shell
php ConsoleCommand migrate
```

### Populate Users

Populate a specified number of users with random data:
```shell
php ConsoleCommand user:seed <number_of_users>
```

### Perform Transaction

Perform a transaction for a specific user on a given day:
```shell
php ConsoleCommand transaction:create <user_id> <amount> <date>
php ConsoleCommand transaction:create 3 300 2024-11-17T21:21:21
```

### Generate User Report

Generate a report of the total transaction amount for a specific user on a given day:
```shell
php ConsoleCommand user:report (optional)<user_id>
```

[//]: # (### Generate Overall Report)

[//]: # ()
[//]: # (Generate a report of the total transactions amount for all users on a given day:)

[//]: # (```shell)

[//]: # (php ConsoleCommand overall-report <date>)

[//]: # (```)

### Testing

Run PHPUnit tests:
```shell
vendor/bin/phpunit
```

### Docker Integration

Build and run Docker container:
```shell
docker compose up --build
```