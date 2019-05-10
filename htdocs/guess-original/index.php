<?php


    require __DIR__ . "/autoload.php";
    require __DIR__ . "/config.php";


//save class `Guess` to session
if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = new Guess();
}

$message = "Beginning of the game. Please guess the number 1 - 100";

if (isset($_POST["btn"])) {
    $game = $_SESSION["game"];
    switch ($_POST["btn"]) {
        #Make a gues
        case 'Make a guess':
            if ($game->tries()) {
                $game->tries -= 1;
                $message = $game->makeGuess($_POST['input']);
            } else {
                $message = "Sorry you have no attempts left";
            }

            break;
        #start new game
        case 'Start from beginning':
            unset($_SESSION["game"]);
            break;
        #view secret number
        case 'Cheat':
            $message = $game->statusMessage("Cheat");
            break;
    }
}

if (isset($_SESSION["game"])) {
    $tries = $_SESSION["game"]->tries();
} else {
    #start message
    $tries = "6";
    // $message = "Beginning of the game. please guess the number 1 - 100";
}


    include("view/template.php");
