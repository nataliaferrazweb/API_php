<h1>PHP Challenge</h1>


This repository contains a stock quote API where you can create a user, log in, request a stock quote, and check
previous stock quote requests.

## Software requirements

<ul>
    <li>PHP version 7.3 or newer</li>
    <li>MariaDB 10.4.21 or newer</li>
    <li>Composer 2.1.10</li>
</ul>

## Software recomendation

<ul>
    <li>Postman v9 or newer</li>
</ul>

## Instalation

This project uses composer as a package manager, so in order to run the project for the first time you need to follow
these next steps:

<ul>
    <li>Run composer install, this will install dependencies</li>
    <li>Copy the .env.sample file into .env and modify its contents to match your current settings.</li>
    <li>Run composer start and you should be able to check the project running on http://localhost:8080</li>
</ul>

In sql folder there are the tables.sql file to create the database used in this project. Import the file to create the
database.

## Usage

The API has three endpoints:

<div>
    <h3>Create User</h3>
    <i>POST</i>
    <h6>/create-user</h6>

</div>
<h4>Requested Parameters</h4>
post - name </br>
post - email </br>
post - password </br>
<p> ----------- </p>
<div>
    <h3>Request Stock</h3>
    *For this endpoint it's required to create at least one user to use authentication.</br></br>
    <i>GET</i>
    <h6>/request-stock</h6>
</div>

<h4>Parameters</h4>
get - code </br>
basic auth - username(previous email regristrated)</br>
basic auth - password </br>
<p> ----------- </p>
<div>
<h3>Request History</h3>
    *For this endpoint it's required to create at least one user to use authentication.</br></br>
    <i>GET</i>
    <h6>/history</h6>
</div>
<h4>Parameters</h4>
get - limit </br>
basic auth - username(previous email regristrated)</br>
basic auth - password </br>

## Request/Response Format

The default response format is JSON

## Errors

There are four error types:

<strong>Error Code - Error Type</strong></br>
400 Bad Request - Invalid request, invalid params </br>
401 Unauthorized - Authentication error, incorrect username or password </br>
404 Not Found - Requests to resources that don't exist or are missing </br>
500 Internal Server Error - Server error </br>

## License

[MIT](https://choosealicense.com/licenses/mit/)