<div id="f_contact">
    <form method="post" action="testForm.php">
        <fieldset>
            <legend>Contact</legend>
            <p>
                <label for="email">Email : </label>
                <input type="email" name="email" id="email" placeholder="Votre Email" size="15" required>
            </p>
            <p>
                <label for="verif_email">Vérification email : </label>
                <input type="email" name="verif_email" size="15" placeholder="Retapez votre Email" id="verif_email" required>
            </p>
            <p>
                <label for="subject">Sujet : </label>
                <input type="text" name="subject" size="20" placeholder="Le sujet de votre message" id="subject" required>
            </p>
            <p>
                <label for="msg">Message : </label></br>
                <textarea id="msg" name="msg" placeholder="Votre Message" rows="15" cols="60" required></textarea>
            </p>
            <p>
                <input type="submit" name="contact" id="send" value="Envoyer">

            </p>
        </fieldset>
    </form>
</div>