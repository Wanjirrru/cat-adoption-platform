<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Adoption Denied</title>
</head>
<body>
    <h1>Sorry! Your Adoption Request has been Denied</h1>
    <p>Dear {{ $adoption->user->name }},</p>
    <p>We regret to inform you that your adoption request for the cat <strong>{{ $adoption->cat->name }}</strong> has been denied.</p>
    <p>We understand that this news may be disappointing. Please feel free to explore other cats available for adoption on our platform.</p>
    <p>Thank you for your interest in adopting a cat.</p>
    <p>Sincerely, <br> The Cat Adoption Agency</p>
</body>
</html>