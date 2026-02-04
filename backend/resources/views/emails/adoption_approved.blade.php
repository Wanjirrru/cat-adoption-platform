<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adoption Approved</title>
</head>
<body>
    <h1>Congratulations! Your Adoption Request has been Approved!</h1>
    <p>Dear {{ $adoption->user->name }},</p>
    <p>We are pleased to inform you that your adoption request for the cat <strong>{{ $adoption->cat->name }}</strong> has been approved!</p>
    <p>Please check your account for further instructions and to complete the adoption process.</p>
    <p>Thank you for choosing to adopt a cat and giving {{ $adoption->cat->name }} a loving home!</p>
    <p>Sincerely, <br> The Cat Adoption Agency</p>
</body>
</html>