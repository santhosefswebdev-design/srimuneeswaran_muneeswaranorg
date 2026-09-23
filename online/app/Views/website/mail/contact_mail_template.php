<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>ARULMIGU RAJAMARIAMMAN DEVASTHANAM CONTACT FORM</title>
</head>
<body>
<?php $db = db_connect(); ?>
<table style="width:50%;margin:0 auto;background-image: linear-gradient(#2a2728, #e51311);background-size:100% 100%;padding:20px;">
    <tbody>
        <tr>
            <td align="center"><img src="<?php echo base_url(); ?>/uploads/main/1687090400_514735_logo.jpg" style="width:100px;"></td>
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td align="center">
                <h4 style="color:#FFFFFF;font-family: system-ui; margin:0.5em;">Thank you for the Contact Us </h4>
            </td>
        </tr>
        <tr>
            <td align="center">
                <table style="width:50%;" align="center">
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" align="right">Name : </td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" >
                            <?php echo $name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" align="right">Email ID : </td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $email; ?></td>
                    </tr>
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" align="right">Subject : </td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $subject; ?></td>
                    </tr>
                    <tr>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" align="right">Message : </td>
                        <td style="color:#FFFFFF;font-family: system-ui; margin:0.5em;width:50%;" ><?php echo $message; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td>&nbsp;</td></tr>
    </tbody>
</table>
</body>
</html>