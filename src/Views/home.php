<html lang="en">
<head>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/home.css">
    <title>Home</title>
</head>
<body>
<a href="/logout" class="logout" title="logout">&#x274C;</a>
<h1 id="connected_member" data-id="<?php echo $params['connected_member']->getId() ?>"><?php echo $params['connected_member']->getUsername() ?></h1>
<div class="chat">
    <div class="chat__members" id="chat_members">
    </div>
    <div class="chat__window">
        <div class="chat__conversation" id="chat_conversation">
        </div>
        <div class="chat__input">
            <input type="text" id="input_message" placeholder="Your message..."/>
            <button id="send_message" class="btn btn-primary" disabled="disabled" onclick="sendMessage()">Send</button>
        </div>
    </div>
</div>
<script type="text/javascript" src="js/main.js"></script>
</body>
</html>
