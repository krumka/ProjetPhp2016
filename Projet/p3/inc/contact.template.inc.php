<div id="f_contact">
    <form method="post" action="testForm.php">
        <fieldset>
            <legend>Contact</legend>
            <p>
                <label for="email">Email : </label>
                <input type="email" name="email" id="email">
            </p>
            <p>
                <label for="verif_email">Vérification email : </label>
                <input type="email" name="verif_email" id="verif_email">
            </p>
            <p>
                <label for="subject">Sujet</label>
                <input type="text" name="subject" id="subject">
            </p>
            <p>
                <label for="msg">Message : </label>
                <textarea id="msg" name="msg"></textarea>
            </p>
            <p>
                <input type="submit" name="contact" id="send" value="Envoyer">
            </p>
        </fieldset>
    </form>
</div>