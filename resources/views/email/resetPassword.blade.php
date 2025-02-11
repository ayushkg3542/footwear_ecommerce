<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Email</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font: size 16px;">

    <p>Hello {{ $mailData['user']->name }},</p>

    <h1>You have requested to change password:</h1>

    <p>Please click the link given below to reset your password</p>

    <a href="{{ route('resetPassword',$mailData['token']) }}" target="_blank" rel="noopener noreferrer">Click Here</a>

    <p>Thankyou</p>
    
</body>

</html>
