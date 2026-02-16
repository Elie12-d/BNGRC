<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Liste des propositions</title>

    <style>
        body {
            background: linear-gradient(135deg, #f8daeb, #d9d2f8, #c7e5f8);
            min-height: 100vh;
        }

        .custom-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 25px;
            box-shadow: 0 15px 35px rgba(150, 120, 255, 0.15);
        }

        .custom-header {
            background: linear-gradient(90deg, #f472b6, #a78bfa, #05101d);
            color: white;
            border-radius: 15px;
        }

        table tbody tr:hover {
            background-color: #f9f5ff;
            transition: 0.3s;
        }

        .btn-accept {
            background: linear-gradient(45deg, #25e0a8, #5da4e7);
            border: none;
            border-radius: 30px;
            color: white;
        }

        .btn-accept:hover {
            opacity: 0.85;
        }

        .btn-refuse {
            background: linear-gradient(45deg, #c51818, #e67d7d);
            border: none;
            border-radius: 30px;
            color: white;
        }

        .btn-refuse:hover {
            opacity: 0.85;
        }

        h1 {
            background: linear-gradient(90deg, #f36eb3, #9b7bfc, #60a5fa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <h1 class="text-center mb-5 fw-bold">
            Liste des propositions
        </h1>

        <div class="card custom-card p-4">

            <div class="table-responsive">
                <table class="table align-middle text-center mb-0">

                    <thead class="custom-header">
                        <tr>
                            <th>Utilisateur proposant</th>
                            <th>Utilisateur recevant</th>
                            <th>Objet proposé</th>
                            <th>Objet demandé</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2</td>
                            <td>3</td>
                            <td>4</td>
                            <td>
                                <div class="d-flex justify-content-center gap-3">
                                    <button class="btn btn-accept px-4">
                                        Accepter
                                    </button>
                                    <button class="btn btn-refuse px-4">
                                        Refuser
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>

        </div>

    </div>

</body>
</html>
