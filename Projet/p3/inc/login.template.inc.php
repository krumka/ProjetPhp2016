<div id="f_login">
    <form method="post" action="loginForm.php">
        <fieldset>
            <legend>Connexion</legend>
            <p>
                <label for="username">Pseudo : </label>
                <input type="text" name="username" id="username" value="" required>
            </p>
            <p>
                <label for="password">Mot de passe : </label>
                <input type="password" name="password" id="password" value="" required>
            </p>
            <p>
                <input type="submit" name="send" id="send" value="Envoyer">
            </p>
        </fieldset>
        <p>
            <input type="submit" name="mdp_perdu" id="mdp_perdu" value="Mot de passe perdu">
        </p>
    </form>
</div>