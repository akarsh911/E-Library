<?php
require('../../global/php/database_connect.php');
require('../../global/php/get_user_data.php');
require '../../global/php/encrypt_decrypt.php';
require('../../global/php/update_user.php');
initiaize_mail_send($_GET['username']);
function initiaize_mail_send($rcv_token)
{
	$conn = OpenCon();
	$state = get_email_verify_status($rcv_token, $conn);
	$username_valid = get_uid_availaibility($rcv_token, $conn);
	if ($username_valid == $rcv_token) {
		if ($state == "false") {
			send_mail($rcv_token, $conn);
		} elseif ($state == "true") {
			echo "user verified";
			//user is verified
		} else {
			echo "server error";
			//internal server error
		}
	} else {
		http_response_code(404);
		include('../../global/html/error404.html'); // provide your own HTML for the error page
		die();
	}
}
function send_mail($rcv_token, $conn)
{
	$email = get_email_uid($rcv_token, $conn);
	$name = get_full_name($rcv_token, $conn);
	$time = strtotime(date('d-m-Y H:i:s'));
	$data = $rcv_token . "^$^user^$^" . $time;
	echo $data;
	echo "<br>";
	echo str_decryptaesgcm(str_encryptaesgcm($data, "verifymail", "base64"), "verifymail", "base64");
	$short = generateRandomString(9);
	save_short_url(urlencode(str_encryptaesgcm($data, "verifymail", "base64")), $short, $rcv_token, $conn);
	$url = "localhost/verify_email/" . $short;
	$receiver = "admin@localhost.com";
	$subject = "Email Test via PHP using Localhost";
	$body = '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#f9f9f9" id="bodyTable">
	<tbody>
		<tr>
			<td style="padding-right:10px;padding-left:10px;" align="center" valign="top" id="bodyCell">
				<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperWebview" style="max-width:600px">
					<tbody>
						<tr>
							<td align="center" valign="top">
								<table border="0" cellpadding="0" cellspacing="0" width="100%">
									<tbody>
										<tr>
											<td style="padding-top: 20px; padding-bottom: 20px; padding-right: 0px;" align="right" valign="middle" class="webview"> <a href="#" style="color:#bbb;font-family:Open Sans,Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:20px;text-transform:none;text-align:right;text-decoration:underline;padding:0;margin:0" target="_blank" class="text hideOnMobile">Oh wait, there is more! →</a>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperBody" style="max-width:600px">
					<tbody>
						<tr>
							<td align="center" valign="top">
								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableCard" style="background-color:#fff;border-color:#e5e5e5;border-style:solid;border-width:0 1px 1px 1px;">
									<tbody>
										<tr>
											<td style="background-color:#fccc45;font-size:1px;line-height:3px" class="topBorder" height="3">&nbsp;</td>
										</tr>
										<tr>
											<td style="padding-top: 60px; padding-bottom: 20px;" align="center" valign="middle" class="emailLogo">
												<a href="#" style="text-decoration:none" target="_blank">
													<img alt="" border="0" src="https://i.ibb.co/nQZprTD/Logicstics-4.png" style="width:100%;max-width:150px;height:auto;display:block" width="150">
												</a>
											</td>
										</tr>
                    <tr>
                      <td style="padding-bottom: 5px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="mainTitle">
                        <h2 class="text" style="color:#000;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:28px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:36px;text-transform:none;text-align:center;padding:0;margin:0">Welcome aboard!</h2>
                      </td>
                    </tr>
										<tr>
											<td style="padding-bottom: 20px;" align="center" valign="top" class="imgHero">
												<a href="#" style="text-decoration:none" target="_blank">
													<img alt="" border="0" src="https://i.ibb.co/F68G8rj/confirmed-letter-vector-id1357207733-k-20-m-1357207733-s-612x612-w-0-h-w-Ax-f6h-Q6-BJQNJs-HQc-SP32pa.jpg" style="width:100%;max-width:350px;height:auto;display:block;color: #f9f9f9;" width="600">
												</a>
											</td>
										</tr>
										<tr>
											<td style="padding-bottom: 5px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="mainTitle">
												<h2 class="text" style="color:#000;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:28px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:36px;text-transform:none;text-align:center;padding:0;margin:0">Hi ' . $name . '</h2>
											</td>
										</tr>
										<tr>
											<td style="padding-bottom: 30px; padding-left: 20px; padding-right: 20px;" align="center" valign="top" class="subTitle">
												<h4 class="text" style="color:#999;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:16px;font-weight:500;font-style:normal;letter-spacing:normal;line-height:24px;text-transform:none;text-align:center;padding:0;margin:0">Please Verify Your Email Account</h4>
											</td>
										</tr>
										<tr>
											<td style="padding-left:20px;padding-right:20px" align="center" valign="top" class="containtTable ui-sortable">
												<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription" style="">
													<tbody>
														<tr>
															<td style="padding-bottom: 20px;" align="center" valign="top" class="description">
																<p class="text" style="color:#666;font-family:Open Sans,Helvetica,Arial,sans-serif;font-size:14px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:22px;text-transform:none;text-align:center;padding:0;margin:0">Thanks for registering on Logicstics. Please click confirm button for subscription to activate your id.</p>
															</td>
														</tr>
													</tbody>
												</table>
												<table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableButton" style="">
													<tbody>
														<tr>
															<td style="padding-top:20px;padding-bottom:20px" align="center" valign="top">
																<table border="0" cellpadding="0" cellspacing="0" align="center">
																	<tbody>
																		<tr>
																			<td style="background-color: #f2c222; padding: 12px 35px; border-radius: 50px;" align="center" class="ctaButton"> <a href="' . $url . '" style="color:#fff;font-family:Poppins,Helvetica,Arial,sans-serif;font-size:13px;font-weight:600;font-style:normal;letter-spacing:1px;line-height:20px;text-transform:uppercase;text-decoration:none;display:block" target="_blank" class="text">Confirm Email</a>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
											</td>
										</tr>

										<tr>
											<td style="font-size:1px;line-height:1px" height="20">&nbsp;</td>
										</tr>
										<tr>
											<td align="center" valign="middle" style="padding-bottom: 40px;" class="emailRegards">
												<!-- Image and Link // -->
												<a href="#" target="_blank" style="text-decoration:none;">
													<img mc:edit="signature" src="https://i.ibb.co/DKFgbkd/100-Signature-removebg-preview.png" alt="" width="150" border="0" style="width:100%;
   														 max-width:150px; height:auto; display:block;">
												</a>
											</td>
										</tr>
									</tbody>
								</table>

								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
									<tbody>
										<tr>
											<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				<table border="0" cellpadding="0" cellspacing="0" width="100%" class="wrapperFooter" style="max-width:600px">
					<tbody>
						<tr>
							<td align="center" valign="top">
								<table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
									<tbody>
										<tr>
											<td style="padding-top:10px;padding-bottom:10px;padding-left:10px;padding-right:10px" align="center" valign="top" class="socialLinks">
												<a href="#facebook-link" style="display:inline-block" target="_blank" class="facebook">
													<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/facebook.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
												</a>
												<a href="#twitter-link" style="display: inline-block;" target="_blank" class="twitter">
													<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/twitter.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
												</a>
												<a href="#pintrest-link" style="display: inline-block;" target="_blank" class="pintrest">
													<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/pintrest.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
												</a>
												<a href="#instagram-link" style="display: inline-block;" target="_blank" class="instagram">
													<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/instagram.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
												</a>
												<a href="#linkdin-link" style="display: inline-block;" target="_blank" class="linkdin">
													<img alt="" border="0" src="http://email.aumfusion.com/vespro/img/social/light/linkdin.png" style="height:auto;width:100%;max-width:40px;margin-left:2px;margin-right:2px" width="40">
												</a>
											</td>
										</tr>

										<tr>
											<td style="padding: 0px 10px 20px;" align="center" valign="top" class="footerLinks">
												<p class="text" style="color:#bbb;font-family:Open Sans,Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:20px;text-transform:none;text-align:center;padding:0;margin:0"> <a href="#" style="color:#bbb;text-decoration:underline" target="_blank">View Web Version </a>&nbsp;|&nbsp; <a href="#" style="color:#bbb;text-decoration:underline" target="_blank">Email Preferences </a>&nbsp;|&nbsp; <a href="#" style="color:#bbb;text-decoration:underline" target="_blank">Privacy Policy</a>
												</p>
											</td>
										</tr>
										<tr>
											<td style="padding: 0px 10px 10px;" align="center" valign="top" class="footerEmailInfo">
												<p class="text" style="color:#bbb;font-family:Open Sans,Helvetica,Arial,sans-serif;font-size:12px;font-weight:400;font-style:normal;letter-spacing:normal;line-height:20px;text-transform:none;text-align:center;padding:0;margin:0">If you have any quetions please contact us <a href="#" style="color:#bbb;text-decoration:underline" target="_blank">support@mail.com.</a>
													<br> <a href="#" style="color:#bbb;text-decoration:underline" target="_blank">Unsubscribe</a> from our mailing lists</p>
											</td>
										</tr>

										<tr>
											<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td style="font-size:1px;line-height:1px" height="30">&nbsp;</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>'; ?>
<br>
<?php
		$headers  = "From: logicstics@localhost.com"  . "\r\n";
		$headers .= "Reply-To: logicstics@localhost.com"  . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		$sender = "From:logicstics@localhost.com";
		if (mail($receiver, $subject, $body, $headers)) {
		} else {
			echo "Sorry, failed while sending verification mail Kindly Retry!";
		}
	}
?>