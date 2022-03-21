<?php

    //  FOOTER TEMPLATE

	global $super_mods;
	$funcs = $super_mods->funcs;
	$trailerID = $super_mods->trailerID;
    $signup_message_en = get_field( 'signup_form_message_english', 'options' );
    $signup_message_es = get_field( 'signup_form_message_spanish', 'options' );
    $signup_en = get_field( 'footer_email_signup_shortcode', 'options' );
    $signup_es = get_field( 'footer_email_signup_shortcode_es', 'options' );
    $add_text = get_field( 'footer_add_text', 'options' );
	$funders_logos = get_field( 'funders_logos', 'options' );
	$credits = get_field( 'credit_block', 'options' );
    


	ob_start();
    
		print '<div class="full__container rel">';

			//	funders logos
			if ( $funders_logos && !empty($funders_logos) ) get_template_part( E_TEMPLATES, 'funders', array( 'logos' => $funders_logos, 'func' => $funcs ) );

			//	credit block
			if ( $credits ) get_template_part( E_TEMPLATES, 'credits', array( 'credits' => $credits, 'func' => $funcs ) );


			print '<div class="footer-inner full__container grid T_md">';

				//	footer left
				print '<nav class="footer-nav">';

					//	view trailer pre nav
					if ( $trailerID ) :
						print '<div class="wwlb_btn solid light flex B_md">';
							print '<a class="btn-main md" href="#" data-action="trailer-open" rel="nofollow">View Trailer</a>';
						print '</div>';
					endif;
	
					//	nav
					print wp_nav_menu( array( 'menu' => 1 ) );

				print '</nav>';


				//	footer right
				print '<div class="footer-subscribe">';

					//	signup message
					print '<div class="footer-signupmsg text_left">';
						if ( $signup_message_en && $signup_message_es ) {
							printf( '<h6 class="off_white eng">%s</h6>', $signup_message_en );
							printf( '<h6 class="off_white esp">%s</h6>', $signup_message_es );
						} else if ( $signup_message_en && !$signup_message_es ) {
							printf( '<h6 class="off_white">%s</h6>', $signup_message_en );
						} else if ( !$signup_message_en && $signup_message_es ) {
							printf( '<h6 class="off_white">%s</h6>', $signup_message_es );
						}
					print '</div>';

					//	newsletter signup shortcode
					if ( $signup_en && $signup_es ) {
						printf( '<div class="footer-signup eng">%s</div>', do_shortcode($signup_en) );
						printf( '<div class="footer-signup esp">%s</div>', do_shortcode($signup_es) );
					} else if ( $signup_en && !$signup_es ) {
						printf( '<div class="footer-signup">%s</div>', do_shortcode($signup_en) );
					} else if ( !$signup_en && $signup_es ) {
						printf( '<div class="footer-signup">%s</div>', do_shortcode($signup_es) );
					}

				print '</div>';

			print '</div>';
			
		print '</div>';

		//	social media links
		print $super_mods->social_links('horiz T_xlg B_lg');

	$output = ob_get_clean();


	//  print footer styles
    $funcs->aggregate_css( NEW_CLIENT . '-footer', false, true );


	//	output
	genesis_markup(
		[
			'open'		=> '<div %s>',
			'context'	=> 'footer-add',
			'atts'		=> [ 'class' => "b-footer full__container _large" ],
			'content'	=> $output,
			'close'		=> '</div>',
		]
	);

?>