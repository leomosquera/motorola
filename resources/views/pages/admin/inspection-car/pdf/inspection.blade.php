<!doctype html>
<html lang="en">

<head>
    <title>HDI - Inspección </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('/css/style.bundle.css') }}">
    <style>
        body {
            margin: 1.5cm;
            background-color: white;
        }
        h1{
            font-size: 14pt;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <img  src="{{ asset('/media/logos/hdi-seguros.png') }}" style="width:3cm">
        <h5 class=" font-weight-bold">DOMPDF Tutorial</h5>
        <h1>{{ asset('/css/style.bundle.css') }}</h1>
        <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>AAA</td>
                    <td>PEDRO PRUEBA TEST</td>
                    <td>TEST@GMAIL.COM</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
