<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {

    return $app->response->redirect("guess/play");
});


/**
 * Play the game.
 */
$app->router->get("guess/play", function () use ($app) {
    // echo "Some debugging information";
    if (!isset($_SESSION["game"])) {
        $_SESSION["game"] = new Mos\Guess\Guess();
    } else {
        unset($_SESSION["game"]);
        $_SESSION["game"] = new Mos\Guess\Guess();
    }
    $message = "Beginning of the game. Please guess the number 1 - 100";
    $tries = 6;
    $data = [
        "title" => "Gissa numret med PHP",
        "message" => $message,
        "tries" => $tries,
    ];
    $app->page->add("guess-template/index", $data);
    // $app->page->add("guess-template/debug");
    return $app->page->render();
});

$app->router->post("guess/play", function () use ($app) {
    if (!isset($_SESSION["game"])) {
        $_SESSION["game"] = new Mos\Guess\Guess();
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
                    $message = "sorry you have no attempts left";
                }

                break;
            #start new game
            case 'Start from beginning':
                unset($_SESSION["game"]);
                break;
            #view secret number
            case 'Cheat':
                $message = $game->status_message("Cheat");
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

    $data = [
        "title" => "Gissa numret med PHP",
        "message" => $message,
        "tries" => $tries,
    ];



    $app->page->add("guess-template/index", $data);
    // $app->page->add("guess-template/debug");
    return $app->page->render();
    // return $app->response->redirect("guess/play");
});


/**
* Showing message Hello World, rendered within the standard page layout.
 */
// $app->router->get("lek/hello-world-page", function () use ($app) {
//     $title = "Hello World as a page";
//     $data = [
//         "class" => "hello-world",
//         "content" => "Hello World in " . __FILE__,
//     ];

//     $app->page->add("anax/v2/article/default", $data);

//     return $app->page->render([
//         "title" => $title,
//     ]);
// });
