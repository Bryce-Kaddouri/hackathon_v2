<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/stylesScore.css">
    <title>Tableau des scores</title>
</head>

<body style="background-color:rgba(52, 57, 111, 0.909);">
    <div style="margin:50px;text-align:center;font-size:40px;font-weight:bold;color:white;">
        <h1>Tableau des scores</h1>
    </div>
    <div style="margin-right:50px;margin-left:50px;background-color:#f8f8f8;border:1px solid #ccc;box-shadow:0 1px 1px rgba(0,0,0,.05);border-radius:4px;">
        <div style="display:flex">
            <p style="margin-left:10px;margin-right:20px;font-size:40px">Temps restant : </p><strong style="font-size:40px" id="minuteur"></strong>
        </div>
    </div>
    <table class="container">
        <thead>
            <tr>
                <th>
                    <h1>Position</h1>
                </th>
                <th>
                    <h1>Nom d'équipe</h1>
                </th>
                <th>
                    <h1>Badge</h1>
                </th>
                <th>
                    <h1>Scores</h1>
                </th>
            </tr>
        </thead>
        <tbody class="tabScore">
        </tbody>
        </div>
    </table>

    </div>
    <div style="margin-top:75px;align-items:center;justify-content:center;display:flex">
        <a style="background-color:blue;color:white;font-size:30px;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px;border-radius:15px;cursor:pointer;" href="index.php?uc=enigme&action=afficherEnigmes">Retour</a>

    </div>

    <script type="text/javascript" src="node_modules/jquery/dist/jquery.js"></script>

    <script>
        // chaque seconde on rafraichit le tableau
      
    </script>
    <script src="js/ajax.js"></script>
</body>

</html>