<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());



?><h1><?php echo $title ?> </h1>

<blockquote>
    Spelet fungerar så att en siffra mellan 1 till 100 slumpas fram och spelaren skall gissa vilket tal det är. Spelet ska svara om spelarens gissning är högre eller lägre än det korrekta talet. Spelaren har 6 gissningar på sig att gissa rätt.
</blockquote>

<form method="POST">
    <fieldset>
        <legend> Guess a number between 1 and 100, you have <?php print $tries; ?> left</legend>
        <input type="text" name="input">
        <input type="submit" name="btn" value="Make a guess">
        <input type="submit" name="btn" value="Start from beginning">
        <input type="submit" name="btn" value="Cheat">
    </fieldset>
</form>

<hr>
<?php print $message; ?>
