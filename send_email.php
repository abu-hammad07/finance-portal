<?php
$emailContent = '

<!DOCTYPE html>
<html>

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <!-- Add the preheader text here -->
    <meta name="og:title" content="Your Custom Preheader Text">
    <title>Verify Email Address</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        @media screen {
            @font-face {
                font-family: "Source Sans Pro";
                font-style: normal;
                font-weight: 400;
                src: local("Source Sans Pro Regular"), local("SourceSansPro-Regular"), url(https://fonts.gstatic.com/s/sourcesanspro/v10/ODelI1aHBYDBqgeIAH2zlBM0YzuT7MdOe03otPbuUS0.woff) format("woff");
            }

            @font-face {
                font-family: "Source Sans Pro";
                font-style: normal;
                font-weight: 700;
                src: local("Source Sans Pro Bold"), local("SourceSansPro-Bold"), url(https://fonts.gstatic.com/s/sourcesanspro/v10/toadOcfmlt9b38dHJxOBGFkQc6VGVFSmCnC_l7QZG60.woff) format("woff");
            }
        }

        body,
        table,
        td,
        a {
            -ms-text-size-adjust: 100%;
            /* 1 */
            -webkit-text-size-adjust: 100%;
            /* 2 */
        }

        table,
        td {
            mso-table-rspace: 0pt;
            mso-table-lspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        a[x-apple-data-detectors] {
            font-family: inherit !important;
            font-size: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            color: inherit !important;
            text-decoration: none !important;
        }

        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }

        body {
            width: 100% !important;
            height: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        table {
            border-collapse: collapse !important;
        }

        a {
            color: #1a82e2;
        }

        img {
            height: auto;
            line-height: 100%;
            text-decoration: none;
            border: 0;
            outline: none;
        }

        .logo {
            display: inline-block;
            text-decoration: none;
        }

        .logo h1 {
            color: #294B29;

        }
    </style>

</head>

<body style="background-color: #e9ecef;">

    <!-- start preheader -->
    <div class="preheader" style="display: none; max-width: 0; max-height: 0; overflow: hidden; font-size: 1px; line-height: 1px; color: #fff; opacity: 0;">
        Confirm Your Email Address: Tap to Activate Your Account
    </div>
    <!-- end preheader -->

    <!-- start body -->
    <table cellpadding="0" cellspacing="0" width="100%" style="border: 0;">

        <tr>
            <td align="center" style="background-color: #e9ecef;">
                <table cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; border:0; border-radius: 10px; background-color: #ffffff;">
                    <tr>
                        <td align="center" valign="top" style="padding: 30px 24px;">
                            <a href="javascript:void(0)" class="logo" style="display: inline-block;" target="_blank">
                                <!-- <img src="assets/img/Logo.png" alt="Logo" width="180" style="display: block; width: 180px; max-width: 180px; min-width: 180px; border:0;"> -->
                                <h1>Finance Portal</h1>
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- end logo -->

        <!-- start hero -->
        <tr>
            <td align="center" style="background-color: #e9ecef;">
                <table cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; border:0;">
                    <tr>
                        <td style="text-align:left; background:#ffffff; padding: 36px 24px 0; font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; border-top: 3px solid #d4dadf;">
                            <h2 class="email_heading" style="margin: 0;  font-weight: 700; letter-spacing: -1px; line-height: 48px; color: #416D19">Confirm Your Email Address</h2>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- end hero -->

        <!-- start copy block -->
        <tr>
            <td align="center" style="background-color: #e9ecef;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">

                    <!-- start copy -->
                    <tr>
                        <td style="background-color:#ffffff; text-align:left; padding: 24px; font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0;"><br>
                                You have been registered successfuly at
                                <strong><a href="javascript:void(0)" style="text-decoration: none; color: #416D19">Finance Portal</a></strong>
                                Admin Portal. You can access the portal
                            </p>
                        </td>
                    </tr>
                    <!-- end copy -->

                    <!-- start copy -->
                    <tr>
                        <td style="text-align:left; background-color:#ffffff; padding: 24px; font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px;">
                            <p style="margin: 0;">Your login Credentials are:<br>
                                User Email: ' . $_SESSION['show_email'] . ',<br>Password: ' . $_SESSION['show_password'] . '</p><br>
                        </td>
                    </tr>
                    <!-- end copy -->

                    <!-- start button -->
                    <tr>
                        <td align="left" style="background-color:#ffffff;">
                            <table cellpadding="0" cellspacing="0" width="100%" style="border: 0;">
                                <tr>
                                    <td align="center" style="padding: 12px; background-color:#ffffff;">
                                        <table cellpadding="0" cellspacing="0" style="border: 0;">
                                            <tr>
                                                <td style="text-align:center; background-color:#416D19; border-radius: 6px;">
                                                    <a href="http://localhost/finance-portal/activate.php?token=' . $token . '" target="_blank" style="display: inline-block; padding: 16px 36px; font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 16px; color: #ffffff; text-decoration: none; border-radius: 6px;">Verify Email Address</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <!-- end button -->

                    <!-- start copy -->
                    <tr>
                        <td style="text-align:left; background-color:#ffffff; padding: 24px; font-family: \'Source Sans Pro\', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 24px; border-bottom: 3px solid #d4dadf">
                            <p style="margin: 0;">Thanks and Regards,<br>Finance Portal</p>
                        </td>
                    </tr>
                    <!-- end copy -->

                </table>
            </td>
        </tr>
        <!-- end copy block -->

    </table>
    <!-- end body -->

</body>

</html>
';
