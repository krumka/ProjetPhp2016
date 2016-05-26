<div id="f_answer">
    <form method="post" action="testForm.php">
        <fieldset>
            <legend>Réponse</legend>
            <p>
                <label for="email">Auteur : </label>
                <input type="text" name="auteur" id="auteur" placeholder="Votre Nom" size="15" <?php if(isset($auteur)) echo "value='".$auteur."'' disabled" ?> required>
            </p>
            <p>
                <label for="verif_email">Email : </label>
                <input type="email" name="email" id="email" size="15" placeholder="Email du destinataire" <?php if(isset($dest)) echo "value='".$dest."'' disabled" ?> required>
            </p>
            <p>
                <label for="subject">Sujet : </label>
                <input type="text" name="subject" id="subject" size="20" placeholder="Le sujet de votre message" <?php if(isset($subject)) echo "value='".$subject."' disabled" ?> required>
            </p>
            <p>
                <label for="msg">Message : </label></br>
                <textarea id="msg" name="msg" placeholder="Votre Message" rows="15" cols="60" required></textarea>
            </p>
            <p>
                <input type="submit" name="repContact" id="send" value="Répondre">

            </p>
        </fieldset>
    </form>
</div>