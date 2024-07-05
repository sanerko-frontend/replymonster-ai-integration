<div class="wrap replymonster-settings">
    <img class="replymonster-settings__logo" src="<?php echo plugin_dir_url(__FILE__) . 'images/logo.png'; ?>" alt="ReplyMonster Logo">
    <h1>Add personal access token to embed chatbot <br> to your website</h1>
    <form method="post" action="options.php" class="replymonster-settings__form">
        <?php
        settings_fields('replymonster_settings');
        do_settings_sections('replymonster-settings');
        submit_button();
        ?>
        <div id="replymonster_error" class="error"></div>
    </form>

  
</div>

<div class="wrap replymonster-settings replymonster-settings__footer">
    <p>
        You can copy your personal access token from your <a href="https://replymonster.ai/" target="_blank">ReplyMonster account</a>.
    </p>
</div>
