<?php

include "../classes/chat_class.php";

$chat = new Chat();

if (isset($_POST['friendEmail'])) {
    $_SESSION['friendEmail'] = $_POST['friendEmail'];
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatting</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            font-size: 1rem;
            font-weight: 400;
            line-height: 0.5;
            color: #212529;
            text-align: left;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px auto;
        }

        h2 {
            color: #075e54;
            text-align: center;
            margin-bottom: 20px;
        }

        #chat-container {
            max-height: 400px;
            overflow-y: auto;
            padding: 10px;
        }

        .message {
            max-width: 70%;
            word-wrap: break-word;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
        }

        .you {
            background-color: #DCF8C6;
            align-self: flex-end;
            text-align: right;
            color: #000;
            margin-left: auto;
        }

        .friend {
            background-color: #ECE5DD;
            align-self: flex-start;
            text-align: left;
            color: #000;
            margin-right: auto;
        }

        #message-form {
            display: flex;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        #message {
            flex-grow: 1;
            resize: none;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        #send-button {
            background-color: #128C7E;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <?php include "../classes/navbar.php" ?>

    <div class="container">
        <h2>Chat with
            <?php echo $_SESSION['friendEmail']; ?>
        </h2>

        <div id="chat-container">
            <?php
            $result = $chat->getChat();
            ?>
        </div>

        <form id="message-form" action="../classes/chat_class.php" method="post">
            <input type="hidden" name="receiver" value="<?= $_SESSION['friendEmail']; ?>">
            <textarea id="message" name="message" rows="4" placeholder="Type a message..."></textarea>
            <button id="send-button" type="button">Send</button>
        </form>

    </div>
    <script>
        $(document).ready(function () {
            function sendMessage() {
                var message = $('#message').val();
                var receiver = $('input[name="receiver"]').val();

                $.ajax({
                    type: 'POST',
                    url: '../classes/chat_class.php',
                    data: { action: 'handleMessage', message: message, receiver: receiver },
                    dataType: 'json', 
                    success: function (response) {
                       
                        $('#message').val('');
                        
                        loadChat();
                    },
                    error: function (error) {
                        console.log('Error sending message:', error);
                    }
                });
            }

            function loadChat() {
                var receiver = $('input[name="receiver"]').val();

                $.ajax({
                    type: 'POST',
                    url: '../classes/chat_class.php',
                    data: { action: 'getChat', receiver: receiver },
                    success: function (data) {
                   
                        $('#chat-container').html(data);
                        
                        $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
                    },
                    error: function (error) {
                        console.log('Error loading chat:', error);
                    }
                });
            }


            loadChat();

            $('#send-button').on('click', function () {
                sendMessage();
            });


            setInterval(function () {
                loadChat();
            }, 1000)
        });
    </script>



</body>


</html>