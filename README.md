# Simple message application

## Overview

This is a simple message board application that allows users to post messages.

### Installation

1. Clone the repository:

   ```bash
   git clone git@github.com:Msalah11/simple-message-app.git
2. Navigate to the project directory:

   ```bash
   cd simple-message-app
   ```

3. Install the project dependencies:

   ```bash
    composer install
    ```

4. Copy the .env.example file to .env and configure the database connection.

   ```bash
   cp .env.example .env
   ```

5. Generate the application key:

   ```bash
    php artisan key:generate
    ```

6. Run the database migrations:

   ```bash
    php artisan migrate --seed
    ```
7. Install the node modules:

   ```bash
    npm install
    ```
8. Run Socket.io server:

   ```bash
    node server.js
    ```
9. Run the development server (the output will give the address):

   ```bash
   php artisan serve
   ```
