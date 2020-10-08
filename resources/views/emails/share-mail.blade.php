<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css2?family=Oxygen:wght@300;400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />   
</head>

<body style="font-family: 'Oxygen', sans-serif;">
	<table align="center" bgcolor="#EAECED" border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody>

			<tr style="font-size:0;line-height:0">
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="center" valign="top">

					<table width="600">
						<tbody>

							<tr>
								<td>&nbsp;</td>
							</tr>

							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<table bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0" style="overflow:hidden!important;border-radius:3px" width="700">
										<tbody>

											<tr style="">
												<td align="center">
													<table width="100%">
														<tbody>
															<tr>
																<td align="center">
																	<h2 style="margin: 0!important;font-family: 'Open Sans',arial,sans-serif!important;font-size: 28px!important;line-height: 38px!important;font-weight: 200!important;color: #fff;background-color: #1f7cca;padding: 5px;">
																	Your Trip</h2>
																</td>
															</tr>
															<tr>
																<td align="center " style="padding: 12px;">
																	<table class="table">

																		<tbody>
																			<tr>
																				<th style="padding: 6px;text-align: left;white-space: nowrap; font-size: 15px; vertical-align: top;">Date</th>
																				<td style="padding: 6px;white-space: nowrap;    font-size: 13px;">{{$data['date']}}</td>
																				<th style="padding: 6px;text-align: left;white-space: nowrap;    font-size: 15px;vertical-align: top;">Beat Plan Date</th>
																				<td style="padding: 6px;white-space: nowrap;    font-size: 13px;">{{$data['plandate']}}</td>
																				<th style="padding: 6px;text-align: left;white-space: nowrap;    font-size: 15px;vertical-align: top;">MP/Zone</th>
																				<td style="padding: 6px;white-space: nowrap;    font-size: 13px;">{{$data['zone']}}</td>

																			</tr>
																			<tr>
																				<th style="padding: 6px;text-align: left;white-space: nowrap;    font-size: 15px;vertical-align: top;">Route Plan</th>
																				<td style="padding: 6px;white-space: nowrap;    font-size: 13px;">{{$data['route']}}</td>
																				<th style="padding: 6px;text-align: left;white-space: nowrap;    font-size: 15px;vertical-align: top;">Vehicle No</th>
																				<td style="padding: 6px;white-space: nowrap;    font-size: 13px;">{{$data['vehicle']}}</td>
																				<th style="padding: 6px;text-align: left;white-space: nowrap;    font-size: 15px;vertical-align: top;">Trip Id</th>
																				<td style="padding: 6px;    font-size: 13px;">{{$data['trip_id']}}</td>

																			</tr>
																			<tr>
																				<th style="padding: 6px;text-align: left;white-space: nowrap;    font-size: 15px;vertical-align: top;">Driver Name & Contact</th>
																				<td style="padding: 6px;white-space: nowrap;    font-size: 13px;">{{$data['driver']}}</td>
																				<!-- <th style="padding: 6px;text-align: left;white-space: nowrap;    font-size: 15px;vertical-align: top;">Driver Contact</th> -->
																				<td style="padding: 6px;white-space: nowrap;    font-size: 13px;"></td>
																				<th style="padding: 6px;text-align: left;white-space: nowrap;    font-size: 15px;vertical-align: top;">Filler Name & Contact</th>
																				<td style="padding: 6px;white-space: nowrap;    font-size: 13px;">{{$data['filler']}}</td>

																			</tr>
																			<tr>
																				<!-- <th style="padding: 6px;text-align: left;white-space: nowrap;    font-size: 15px;vertical-align: top;">Filler Contact</th> -->
																				<td style="padding: 6px;white-space: nowrap;    font-size: 13px;"></td>
																				<th style="padding: 6px;text-align: left;white-space: nowrap;    font-size: 15px;vertical-align: top;">Loading Point</th>
																				<td colspan="3" style="padding: 6px;    font-size: 13px;">{{$data['ro']}}</td>


																			</tr>

																			<tr>
																				<th style="padding: 6px;text-align: left;white-space: nowrap;    font-size: 15px;vertical-align: top;">No Of Sites</th>
																				<td style="padding: 6px;white-space: nowrap;    font-size: 13px;">{{$data['sitesLength']}}</td>
																				<th style="padding: 6px;text-align: left;white-space: nowrap;    font-size: 15px;vertical-align: top;">Sites Quantity</th>
																				<td colspan="3" style="padding: 6px;white-space: nowrap;     font-size: 13px;">{{$data['totalQty']}}</td>
																			</tr>
																		</tbody>
																	</table>

																	<hr>

																	<table class="table" style="width: 100%;">
																		<thead>
																			<tr>
																				<th style="text-align: left;padding: 6px 0;">Site Id</th>
																				<th style="text-align: left;padding: 6px 0;">Site Name</th>
																				<th style="text-align: left;padding: 6px 0;">Qty</th>
																				<th style="text-align: left;padding: 6px 0;">Technician Name</th>
																			</tr>
																		</thead>

																		<tbody>
																			@if(isset($data['sites']) && !empty($data['sites']))
																			@foreach($data['sites'] as $key)
																			<tr>
																				<td style="padding: 5px 0;">{{$key->siteId}}</td>
																				<td style="padding: 5px 0;">{{$key->siteName}}</td>
																				<td style="padding: 5px 0;">{{$key->qty}}</td>
																				<td style="padding: 5px 0;">{{$key->techName}}</td>
																			</tr>
																			@endforeach
																			@endif
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td align="center">
													<table border="0" cellpadding="0" cellspacing="0" width="78%">
														<tbody>
															<tr>
																<td align="center" style="font-family:'Open Sans',arial,sans-serif!important;font-size:16px!important;line-height:30px!important;font-weight:400!important;color:#7e8890!important">
																	Create custom
																	moodboards and
																	brand boards,
																	share image
																	galleries,
																	present
																	in-progress or
																	final design
																	assets, and so
																much more.</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td align="center" valign="top">
													<table border="0" cellpadding="0" cellspacing="0">
														<tbody>
															<tr>
																<td align="center" valign="top">
																	<a href="" style="background-color:#ff2b63;padding:14px 28px 14px 28px;border-radius:3px;line-height:18px!important;letter-spacing:0.125em;text-transform:uppercase;font-size:13px;font-family:'Open Sans',Arial,sans-serif;font-weight:400;color:#ffffff;text-decoration:none;display:inline-block;line-height:18px!important" target="_blank">Your Trip</a>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>

							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>

							<tr>
								<td align="center">
									<a href="#" style="background-color: #1877f2;padding: 14px 28px 14px 28px;border-radius: 3px;line-height: 18px!important;letter-spacing: 0.125em;text-transform: uppercase;font-size: 13px;font-family: 'Open Sans',Arial,sans-serif;font-weight: 400;color: #ffffff;text-decoration: none;display: inline-block;line-height: 18px!important;"><i class="fa fa-facebook" aria-hidden="true"></i></a>
									<a href="#" style="background-color: #71c9f8;padding: 14px 28px 14px 28px;border-radius: 3px;line-height: 18px!important;letter-spacing: 0.125em;text-transform: uppercase;font-size: 13px;font-family: 'Open Sans',Arial,sans-serif;font-weight: 400;color: #ffffff;text-decoration: none;display: inline-block;line-height: 18px!important;"><i class="fa fa-twitter" aria-hidden="true"></i></a>
									<a href="#" style="background-color: #ef4433;padding: 14px 28px 14px 28px;border-radius: 3px;line-height: 18px!important;letter-spacing: 0.125em;text-transform: uppercase;font-size: 13px;font-family: 'Open Sans',Arial,sans-serif;font-weight: 400;color: #ffffff;text-decoration: none;display: inline-block;line-height: 18px!important;"><i class="fa fa-google" aria-hidden="true"></i></a>
								</td>
							</tr>

							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center">
									<table border="0" cellpadding="0" cellspacing="0" width="580">
										<tbody>

											<tr>
												<td>&nbsp;</td>
											</tr>

											<tr style="padding:0;margin:0;font-size:0;line-height:0">
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td align="center">
													<a href="" style="font-family:Open Sans,sans-serif!important;font-size:12px!important;color:#7e8890!important;text-decoration:underline!important" target="_blank">TapLog
													email preferences</a>
												</td>
											</tr>
											<tr style="padding:0;margin:0;font-size:0;line-height:0">
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td align="center" valign="top">
													<p style="margin-bottom:1em;font-family:Open Sans,sans-serif!important;padding:0!important;margin:0!important;color:#7e8890!important;font-size:12px!important;font-weight:300!important">

													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	</body>

	</html>