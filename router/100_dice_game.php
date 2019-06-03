<?php

#composer dump (update autoload meta)

/**
 * The function `form` controls the output of the desired form for the game
 */

function form()
{
    function sub01()
    {
        if (isset($_GET["form"])) {
            switch ($_GET["form"]) {
                case '1':
                    $_SESSION["players_count"] = [
                        "count" => (int) $_GET["count"],
                    ];
                    $_SESSION["form"] = 2;
                    break;

                case '2':
                // При нажатии кнопки "Send" на обезъянках обрабатываться будет здесь:
                    $_SESSION["players"] = [];
                    $i = 1;
                    while (true) {
                        if (array_key_exists("name_player_$i", $_GET)) {
                            $_SESSION["players"][] = [$_GET["name_player_$i"], $_GET["type_player_$i"]];
                        } else {
                            break;
                        }
                        $i++;
                    }

                    $_SESSION["form"] = 3;
                    break;
            }
        }
    }



    function sub02()
    {
        $index = $_SESSION["form"];
        $form = '
                    <form method="GET">
                        <fieldset>
                            <legend>Enter data players</legend>
                            <label>%s</label>
                            %s
                            <input type="hidden" name="form" value="%s">
                        </fieldset>
                    </form>
                ';
        switch ($index) {
            case 1:
                $name = "Number of players? => ";
                $field = '<input required type="number" name="count">';
                $field .= '<input type="submit" name="btn" value="Send">';
                $codeForm =  "1";
                return sprintf($form, $name, $field, $codeForm);

            case 2:
                $countPlayers = $_SESSION["players_count"]["count"];
                $name = "Enter player names" . "<br>";
                $field = '';
                for ($i = 0; $i < $countPlayers; $i++) {
                    $field .= $i + 1 . '. <input placeholder="name player" required type="text" name="name_player_'. ($i + 1) . '">';
                    $field .=
                    '
                    <select name="type_player_' . ($i + 1) .'">
                        <option value="Human">Human</option>
                        <option value="Machine">Machine</option>
                    </select> <br>
                    ';
                };
                $field .= '<input type="submit" name="btn" value="Send">';
                $codeForm =  "2";
                return sprintf($form, $name, $field, $codeForm);

            case 3:
                $field = "";
                if (isset($_SESSION["players"])) {
                    $i = 1;
                    foreach ($_SESSION["players"] as $value) {
                        $field .= "😆 $i. " . "Player [" . $value[0] . "] : ready => OK!" . '<br>';
                        $i++;
                    }
                }
                $field .= '<a href="game"><button>Start Game</button></a>';
                return $field;
                break;
        }
    }
    sub01();

     return sub02();
}

$form = 'form';

/**
 * Showing message Hello World, rendered within the standard page layout.
 */

$app->router->get("dice-game/form", function () use ($app, $form) {
    $title = "Please insert data players";
    $data = [
       "name" => "hello-world",
       "content" => "Hello World in " . __FILE__,
       "form" => $form(),
    ];

    $app->page->add("dice/starting", $data);

    return $app->page->render([
       "title" => $title,
    ]);
});



$app->router->get("dice-game/start", function () use ($app) {

    $_SESSION["form"] = 1;
    $_SESSION["players_count"] = null;
    $_SESSION["players"] = null;
    $_SESSION["dice_game"] = null;

    $title = "Welcome Dice Game";

    $app->page->add("dice/short-game-terms");

    return $app->page->render([
       "title" => $title,
    ]);
});


$app->router->get("dice-game/game", function () use ($app) {

    $winner = null;
    $type_player = null;
    $name_palyer_move = null;
    $result = null;
    $trows = [6, 6];

    if (!($_SESSION["dice_game"])) {
        $players = [];
        foreach ($_SESSION["players"] as $key => $value) {
            $players[] = [$value[0], $value[1]];
        }
        $_SESSION["dice_game"] = new My\Dice\Dice($players);
        $_SESSION["dice_game"]->contestWhoIsFirst();
        $type_player = $_SESSION["dice_game"]->players[0]->type;
        $name_player_move = $_SESSION["dice_game"]->players[0]->name;
    }

    if (isset($_GET["btn"])) {
        $result = $_SESSION["dice_game"]->moves();
        switch ($result[0]) {
            case 'next':
                $name_palyer_move = $result[1];
                $type_player = $result[2];
                $trows = $result[3];
                break;

            case 'winner':
                $winner = $result[1];
                break;
        }
    }

    if (isset($_GET["continue"])) {
        $result = $_SESSION["dice_game"]->moves(1);
        switch ($result[0]) {
            case 'next':
                $name_player_move = $result[1];
                $type_player = $result[2];
                break;

            case 'winner':
                $winner = $result[1];
                break;
        }
    }

    $players_statistics = $_SESSION["dice_game"]->printedPlayers();

    $title = "Live game Dice 100";
    $data = [
       "h1" => $title,
       "statistics" => $players_statistics,
       "type_player" => $type_player,
       "name_player_move" => $name_player_move,
       "winner" =>  $winner,
       "trows" =>  $trows,
    ];

    $app->page->add("dice/game", $data);
    // $app->page->add("example/debug");

    return $app->page->render([
       "title" => $title,
    ]);
});
