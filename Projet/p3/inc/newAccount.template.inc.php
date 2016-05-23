<div id="f_register">
    <form method="post" action="testForm.php">
        <fieldset>
            <legend>Nouveau compte</legend>
            <p>
                <label for="pseudo">Pseudo : </label>
                <input type="text" name="pseudo" id="pseudo">
            </p>
            <p>
                <label for="mdp">Mot de passe : </label>
                <input type="password" name="mdp" id="mdp">
            </p>
            <p>
                <label for="verif_mdp">Vérification mot de passe : </label>
                <input type="password" name="verif_mdp" id="verif_mdp">
            </p>
            <p>
                <label for="email">Email : </label>
                <input type="email" name="email" id="email">
            </p>
            <p>
                <label for="verif_email">Vérification email : </label>
                <input type="email" name="verif_email" id="verif_email">
            </p>
            <p>
                <input type="submit" name="newAccount" id="send" value="Envoyer">
            </p>
        </fieldset>
    </form>
</div>