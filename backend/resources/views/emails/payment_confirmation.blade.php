<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
</head>
<body>
    <h1>Payment Confirmation for Adoption</h1>

    <p>Dear {{ $payment->adoption->user->name }},</p>

    <p>We are pleased to inform you that your payment for the adoption of the cat <strong>{{ $payment->adoption->cat->name }}</strong> has been successfully processed. Below are the details of your payment:</p>

    <table>
        <tr>
            <td><strong>Amount Paid:</strong></td>
            <td>${{ number_format($payment->amount, 2) }}</td>
        </tr>
        <tr>
            <td><strong>Payment Status:</strong></td>
            <td>{{ ucfirst($payment->payment_status) }}</td>
        </tr>
        <tr>
            <td><strong>Payment Method:</strong></td>
            <td>{{ ucfirst($payment->payment_method) }}</td>
        </tr>
    </table>

    <p>Thank you for adopting! We are excited to see you with your new pet. If you have any questions, feel free to reach out.</p>

    <p>Best regards,<br> The Adoption Team</p>
</body>
</html>