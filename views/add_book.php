<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un livre - Bibliothécaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Ajouter un livre</h2>
        <form action="index.php?action=addBook" method="post">
            <div class="input-group">
                <label for="title">Titre :</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div class="input-group">
                <label for="author">Auteur :</label>
                <input type="text" id="author" name="author" required>
            </div>
            <div class="input-group">
                <label for="isbn">ISBN :</label>
                <input type="text" id="isbn" name="isbn" required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn">Ajouter</button>
            </div>
        </form>
    </div>
</body>
</html>
