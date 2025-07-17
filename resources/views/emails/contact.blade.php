<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Nova poruka sa sajta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h2 {
            color: #007BFF;
            margin-bottom: 20px;
        }
        .field-label {
            font-weight: bold;
            margin-top: 15px;
        }
        .field-value {
            margin-top: 5px;
            padding: 10px;
            background: #f1f1f1;
            border-radius: 4px;
            word-wrap: break-word;
        }
        .message-box {
            white-space: pre-wrap;
            background: #f1f1f1;
            padding: 15px;
            border-radius: 6px;
            margin-top: 10px;
            line-height: 1.5;
            font-size: 14px;
        }
        footer {
            margin-top: 30px;
            font-size: 12px;
            color: #999;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Nova poruka sa sajta</h2>

        <div>
            <div class="field-label">Ime pošiljaoca:</div>
            <div class="field-value">{{ $name }}</div>
        </div>

        <div>
            <div class="field-label">Email:</div>
            <div class="field-value">{{ $email }}</div>
        </div>

        <div>
            <div class="field-label">Naslov poruke:</div>
            <div class="field-value">{{ $subject }}</div>
        </div>

        <div>
            <div class="field-label">Poruka:</div>
            <div class="message-box">{{ $msg }}</div>
        </div>

        <footer>
            Ovo je automatski generisana poruka. Molimo ne odgovarajte direktno na ovaj email.
        </footer>
    </div>
</body>
</html>
