<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Email Template</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600" rel="stylesheet" />
    <style>
        /* Reset and base styles */
        body,
        table,
        td,
        a {
            margin: 0;
            padding: 0;
            text-decoration: none;
            -webkit-font-smoothing: antialiased;
            mso-line-height-rule: exactly;
        }

        body {
            width: 100%;
            height: 100%;
            font-family: 'Poppins', Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            color: #333333;
            padding: 0 10px; /* Adds some space on the sides */
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
            border: 0;
            outline: none;
        }

        table {
            border-spacing: 0;
            border-collapse: collapse;
            width: 100%;
        }

        a {
            color: #1a82e2;
            text-decoration: none;
        }

        .container {
            width: 100%;
            max-width: 600px; /* Fixed width for desktop */
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }

        .content {
            padding: 40px;
            text-align: left;
            font-size: 16px;
            line-height: 1.6;
        }

        /* Responsive styles */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                padding: 0 15px; /* Adds space to the sides on small screens */
            }

            .content {
                padding: 20px !important;
            }
        }

        .im {
            color: black !important;
        }
    </style>
</head>

<body>
    <!-- Wrapper -->
    <table width="100%" bgcolor="#f9f9f9" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <!-- Main container -->
                <table class="container" cellpadding="0" cellspacing="0">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 20px; text-align: center; background-color:#f4f4f4;color:#666666">
                            <h1 style="margin: 0; font-size: 24px;">
                            <a href="{{ url('/') }}" style="display: inline-block;">
                            @if(__setting('email_header_logo'))
                            <img src="{{ asset(__setting('email_header_logo')) }}" class="logo" alt="{{ config('app.name') }}">
                            @else
                            <img src="{{ asset(__setting('header_logo')) }}" class="logo app-logo-as-img" alt="{{ config('app.name') }}">
                            @endif
                            </a>
                            </h1>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td class="content">
                            <p>Hello,</p>
                            <p>Welcome to {{ $app_name }}! Your account has been successfully created.</p>
                            <p>To complete your setup, please set your password using the link below:</p>
                            <p style="text-align: center;">
                                <span style="text-decoration: underline;">
                                    <strong>
                                        <a href="{{ $reset_url }}" style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">Set Your Password</a>
                                    </strong>
                                </span>
                            </p>
                            <p>If you have any questions or need assistance, feel free to reach out to our support team.</p>
                            <p>Thank you for joining us!</p>
                            <hr><br>
                            <p>If you’re having trouble clicking the "Set Your Password" button, copy and paste the URL below into your web browser:</p>
                            <p><a href="{{ $reset_url }}" style="color: #1a73e8;">{{ $reset_url }}</a></p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 20px; text-align: center; font-size: 12px; background-color: #f4f4f4; color: #666666;">
                            <p style="margin: 0;">
                                @if(__setting('email_footer_content'))
                                {{ Illuminate\Mail\Markdown::parse(__setting('email_footer_content')) }}
                                @else
                                {{ Illuminate\Mail\Markdown::parse($slot) }}
                                @endif
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
