# TicTacToe Test for eDrams ODIGEO

This project is intended to show the solution for the test for the PHP Backend Developer role at eDreams ODIGEO.

It follows the SOLID principles and it shows an outline of the DDD methodology.

## Core folders

The `App/Core` folder holds the core files (as stated by DDD) that presents a really (REALLY) basic structure of how a Game can be built on top of those interfaces.

## Game Folders

The TicTacToe Game logic is holded within `App/Games/TicTacToe` and exposes an implementation of the `App/Core` structure. The logic intends to be as agnostic as posible from which I named _execution context_ which is basically the Laravel Command that triggers the interaction with the game.

## Command file

Since this test is intended for TicTacToe to be designed as a service, the _execution context_ is separated as much as posible from the Game logic itself. Nevertheless, there are some accoupled parts of the game that rely on the _execution context_ given for this test which is this Laravel command.

Such Laravel Command is holded on the `App/Commands/TicTacToe.php` and takes advantage of some Laravel built-in functions to interact from the console with the game.

## Test Files.

Tests are located under `tests/` folder. Invoke them by using:

```
php artisan test
```

## Progress commits.

You can check the progress of the test on https://github.com/mrdynabyte/tic-tac-toe-test/commits/master

# Prerequisites and instructions

`PHP 7.1+` and `composer` is needed in order to execute this game. Nothing else should be needed, but in case you want/need to do some modifications, you can edit `docker-compose.yml` file to activate MySQL database and that can be turned on by running: `./vendor/bin/sail up` from within the `tic-tac-toe` folder

## Migrations and Database.

## **_ DISCLAIMER : THIS IS NOT NEEDED BUT IT'S AVAILABLE _**

Database should be created right away by running `./vendor/bin/sail up`. After that migrations can be run with `php artisan migrate:fresh --seed`

## .ENV File **_ REQUIRED _**

Please copy the `.env.example` file into the root folder `tic-tac-toe` as the `.env` file. The example file holds a variable that is needed for the game to run.

# Installation

You need to run the following commands in order to get the game running:

```
- git https://github.com/mrdynabyte/tic-tac-toe-test.git.
- cd tic-tac-toe-test
- composer install
- php artisan tic-tac-toe:start
```

## Game run

The game can be started by running: `php artisan tic-tac-toe:start`. It will trigger a looping menu that will allow you to play the game.

# Thank you!

Thank you very much again for letting me participate on this process. I look forward very much to meeting you in the next stage!
