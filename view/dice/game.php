<?php

namespace Anax\View;

?>

<h1><?php print $data["h1"]; ?></h1>
<p>You text</p>

<div style="display: flex; justify-content: space-around;">
    <div style="display: flex; flex-direction: column;">
        <div>Player 🎲 <?php echo $data["name_palyer_move"]; ?> throws</div>
        <form action="" method="GET">
            <button name="btn" value="trow" style="margin-top: 20px;"> ➡ THROW ⬅ </button>
            <?php if ($data["type_player"] == 'human') : ?>
                <button name="continue" value="trow" style="margin-top: 20px;"> ➡ skip the throw ⬅ </button>
            <?php endif ?>
            <?php

                $result = '<div style="font-size:40px;">';
            for ($i = 0; $i < 2; $i++) {
                    $result .= '&#x268' . ($data['trows'][$i] - 1);
            }
                $result .= '</div>';
                echo $result;

            ?>
        </form>
    </div>
    <div class="block-statistics">
        <?php print $data["statistics"]; ?>
    </div>
</div>
<hr>
    <?php if ($data["winner"]) : ?>
        <h2 align="center">WINNER 🌞 <?php echo $data["winner"]; ?> 🌞</h2>
        <p align="center"> <a href="start"><button> next new game </button></a></p>
    <?php endif ?>
