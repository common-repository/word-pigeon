<h1>Word Pigeon Options</h1>

<?php echo $message ?>

<p>Please enter the public key provided by Word Pigeon</p>

<form action='<?php echo $postUrl ?>' method='post'>

    <div><label for='publicKey'>Public Key</label></div>
    <div>
        <textarea 
            type='text' 
            name='publicKey'
            id='publicKey'
            class='code'
            cols="75"
            rows="20"            
        ><?php echo $publicKeyExists ?></textarea>
    </div>

    <input type='submit' name='submit' id='submit' class='button button-primary' value='Save Public Key' onclick="return confirm('are you sure you want to save this key?')"/>
    <input type='submit' name='deleteKey' id='deleteKey' class='button button-primary' value='Delete Public Key' onclick="return confirm('are you sure you want to delete this key?')" />
</form>