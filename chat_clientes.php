<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        .chatbox {
            width: 100%;
            max-height: 400px;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow-y: auto;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .chat-input-container {
            display: flex;
            margin-top: 10px;
        }

        .chat-input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
            box-sizing: border-box;
            margin-right: -1px; /* Prevent double border */
        }

        .send-button {
            padding: 10px 20px;
            background-color: #c62828;
            color: #fff;
            border: 1px solid #c62828;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .send-button:hover {
            background-color: #a02626;
        }

        .message {
            margin-bottom: 10px;
            padding: 8px 12px;
            background-color: #e9e9e9;
            border-radius: 5px;
        }

        .message strong {
            color: #333;
        }

        @media screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .chatbox {
                max-height: 300px;
            }

            .chat-input-container {
                flex-wrap: wrap;
            }

            .chat-input {
                width: calc(100% - 100px);
                margin-bottom: 10px;
                border-radius: 5px;
            }

            .send-button {
                width: calc(100% - 20px);
                margin-left: 10px;
                border-radius: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Chat</h1>
        <div class="chatbox" id="chatbox"></div>
        <div class="chat-input-container">
            <input type="text" id="message" class="chat-input" placeholder="Escribe un mensaje...">
            <button id="send" class="send-button">Enviar</button>
            <button class="send-button"><a href="index.php">Volver</a></button>
        </div>
    </div>

    <script>
        let conn = new WebSocket('ws://localhost:8080');
        let chatbox = document.getElementById('chatbox');

        conn.onopen = function(e) {
            console.log("Connection established!");
        };

        conn.onmessage = function(e) {
            displayMessage('Usuario', e.data);
        };

        conn.onerror = function(e) {
            console.error("WebSocket error: ", e);
        };

        conn.onclose = function(e) {
            console.log("Connection closed: ", e);
        };

        document.getElementById('send').onclick = function() {
            let message = document.getElementById('message').value;
            if (message) {
                conn.send(message);
                displayMessage('Tú', message);
                document.getElementById('message').value = '';
            }
        };

        document.getElementById('message').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('send').click();
            }
        });

        function displayMessage(user, message) {
            let messageElement = document.createElement('div');
            messageElement.className = 'message';
            messageElement.innerHTML = `<strong>${user}:</strong> ${message}`;
            chatbox.appendChild(messageElement);
            chatbox.scrollTop = chatbox.scrollHeight;
        }
    </script>
</body>
</html>
