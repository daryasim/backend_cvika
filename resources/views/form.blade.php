<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form method="POST" action="{{ route('create') }}">
    @csrf
    <label for="meno">Name:</label><br>
    <input type="text" id="meno" name="fmeno"><br>
    <label for="email">Email:</label><br>
    <input type="text" id="email" name="femail">
    <br>
    <input type="submit" value="Submit">
</form>


</body>
</html>
