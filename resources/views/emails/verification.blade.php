<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
	<!--[if gte mso 9]>
	<xml>
		<o:OfficeDocumentSettings>
		<o:AllowPNG/>
		<o:PixelsPerInch>96</o:PixelsPerInch>
		</o:OfficeDocumentSettings>
	</xml>
	<![endif]-->
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="format-detection" content="date=no" />
	<meta name="format-detection" content="address=no" />
	<meta name="format-detection" content="telephone=no" />
	<meta name="x-apple-disable-message-reformatting" />
    <!--[if !mso]><!-->
	<link href="https://fonts.googleapis.com/css?family=Fira+Mono:400,500,700|Ubuntu:400,400i,500,500i,700,700i" rel="stylesheet" />
    <!--<![endif]-->
	<title>{{ env('APP_NAME') }}</title>
	<!--[if gte mso 9]>
	<style type="text/css" media="all">
		sup { font-size: 100% !important; }
	</style>
	<![endif]-->


	<style type="text/css" media="screen">
		/* Linked Styles */
		body { padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#e8ebef; -webkit-text-size-adjust:none }
		a { color:#000001; text-decoration:none }
		p { padding:0 !important; margin:0 !important }
		img { -ms-interpolation-mode: bicubic; /* Allow smoother rendering of resized image in Internet Explorer */ }
		.mcnPreviewText { display: none !important; }

		/* Mobile styles */
		@media only screen and (max-device-width: 480px), only screen and (max-width: 480px) {
			.mobile-shell { width: 100% !important; min-width: 100% !important; }

			.m-center { text-align: center !important; }
			.text3,
			.text-footer,
			.text-header { text-align: center !important; }

			.center { margin: 0 auto !important; }

			.td { width: 100% !important; min-width: 100% !important; }

			.m-br-15 { height: 15px !important; }
			.p30-15 { padding: 30px 15px !important; }
			.p30-15-0 { padding: 30px 15px 0px 15px !important; }
			.p40 { padding-bottom: 30px !important; }
			.box,
			.footer,
			.p15 { padding: 15px !important; }
			.h2-white { font-size: 40px !important; line-height: 44px !important; text-align: center !important; }

			.h2 { font-size: 42px !important; line-height: 50px !important; }

			.m-td,
			.m-hide { display: none !important; width: 0 !important; height: 0 !important; font-size: 0 !important; line-height: 0 !important; min-height: 0 !important; }

			.m-block { display: block !important; }
			.container { padding: 0px !important; }
			.separator { padding-top: 30px !important; }

			.fluid-img img { width: 100% !important; max-width: 100% !important; height: auto !important; }

			.column,
			.column-top,
			.column-dir,
			.column-empty,
			.column-empty2,
			.column-bottom,
			.column-dir-top,
			.column-dir-bottom { float: left !important; width: 100% !important; display: block !important; }

			.column-empty { padding-bottom: 10px !important; }
			.column-empty2 { padding-bottom: 30px !important; }

			.content-spacing { width: 15px !important; }
		}
	</style>
</head>

@php
	$logo = get_setting('header_logo');
@endphp

<body class="body" style="padding:0 !important; margin:0 !important; display:block !important; min-width:100% !important; width:100% !important; background:#e8ebef; -webkit-text-size-adjust:none;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#e8ebef">
		<tr>
			<td align="center" valign="top" class="container" style="padding:50px 10px;">
				<!-- Container -->
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="center">
							<table width="650" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
								<tr>
									<td class="td" bgcolor="#ffffff" style="width:650px; min-width:650px; font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
										<!-- Header -->
										<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
											<tr>
												<td class="p30-15-0" style="padding: 40px 30px 0px 30px;">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<th class="column" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
																<table width="100%" border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td class="img m-center" style="font-size:0pt; line-height:0pt; text-align:left;"><img src="{{ uploaded_asset($logo) }}" width="" height="24" border="0" alt="" /></td>
																	</tr>
																</table>
															</th>
															<th class="column-empty" width="1" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;"></th>
															<th class="column" width="120" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal;">
																<table width="100%" border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td class="text-header right" style="color:#000000; font-family:'Fira Mono', Arial,sans-serif; font-size:12px; line-height:16px; text-align:right;"><a href="{{ env('APP_URL') }}" target="_blank" class="link" style="color:#000001; text-decoration:none;"><span class="link" style="color:#000001; text-decoration:none;">{{ env('APP_NAME') }}</span></a></td>
																	</tr>
																</table>
															</th>
														</tr>
													</table>
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td class="separator" style="padding-top: 40px; border-bottom:4px solid #000000; font-size:0pt; line-height:0pt;">&nbsp;</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
										<!-- END Header -->

										<!-- Intro -->
										<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
											<tr>
												<td class="p30-15" style="padding: 70px 30px 70px 30px;">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td class="h2 center pb10" style="color:#000000; font-family:'Ubuntu', Arial,sans-serif; font-size:50px; line-height:60px; text-align:center; padding-bottom:10px;">{{ $array['subject'] }}</td>
														</tr>
														<tr>
															<td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:20px; line-height:26px; text-align:center; color:#2e57ae; padding-bottom:30px;">{{ $array['content'] }} </td>
														</tr>
                                                        @if(!empty( $array['link']))
                                                            <tr>
                                                                <td class="h5 center blue pb30" style="font-family:'Ubuntu', Arial,sans-serif; font-size:20px; line-height:26px; text-align:center; color:#2e57ae; padding-bottom:30px;">
                                                                    <a href="{{ $array['link'] }}" style="background: #007bff;padding: 0.9rem 2rem;font-size: 0.875rem;color:#fff;border-radius: .2rem;" target="_blank">{{ translate("Click Here") }}</a>
                                                                </td>
                                                            </tr>
                                                        @endif
													</table>
												</td>
											</tr>
										</table>
										<!-- END Intro -->
									</td>
								</tr>
								<tr>
									<td class="text-footer" style="padding-top: 30px; color:#1f2125; font-family:'Fira Mono', Arial,sans-serif; font-size:12px; line-height:22px; text-align:center;">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				<!-- END Container -->
			</td>
		</tr>
	</table>
</body>
</html>
