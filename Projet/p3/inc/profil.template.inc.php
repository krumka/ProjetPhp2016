<div id="f_profil">
    <form method="post" action="testForm.php">
        <fieldset>
            <legend>Profil ( modifier : <input type="checkbox" id="mod" name="mod"> )</legend>
            <p>
                <label for="id">Id : </label>
                <input type="number" name="id" id="id">
            </p>
            <p>
                <label for="avatar">Avatar : </label>
                <input type="file" name="avatar" id="avatar">
            </p>
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
                <label for="question">Question secrète : </label>
                <input type="text" name="question" id="question">
            </p>
            <p>
                <label for="rep">Réponse secrète : </label>
                <input type="password" name="rep" id="rep">
            </p>
            <p>
                <label for="verif_rep">Vérification réponse : </label>
                <input type="password" name="verif_rep" id="verif_rep">
            </p>
            <hr>
            <p>
                <label for="mdpA">Mot de passe actuel : </label>
                <input type="password" name="mdpA" id="mdpA">
            </p>
            <p>
                <input type="submit" name="profil" id="send" value="Envoyer">
            </p>
        </fieldset>
    </form>
</div>