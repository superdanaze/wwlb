<?php

    //  FOOTER TEMPLATE

	$mod = new ELA_Mods;
	$funcs = new ELA_funcs;
    $signup_message_en = get_field( 'signup_form_message_english', 'options' );
    $signup_message_es = get_field( 'signup_form_message_spanish', 'options' );
    $signup = get_field( 'footer_email_signup_shortcode', 'options' );
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
					print '<div class="wwlb_btn solid light flex B_md">';
						print '<a class="btn-main md" href="" data-action="" rel="nofollow">View Trailer</a>';
					print '</div>';
	
					//	nav
					print wp_nav_menu( array( 'menu' => 1 ) );

				print '</nav>';


				//	footer right
				print '<div class="footer-subscribe">';

					//	signup message
					print '<div class="footer-signupmsg text_left">';
						if ( $signup_message_en ) printf( '<h6 class="off_white eng">%s</h6>', $signup_message_en );
						if ( $signup_message_es ) printf( '<h6 class="off_white esp">%s</h6>', $signup_message_es );
					print '</div>';

					//	newsletter signup shortcode
					if ( $signup ) printf( '<div class="footer-signup">%s</div>', do_shortcode($signup) );

				print '</div>';

			print '</div>';
			
		print '</div>';

		//	social media links
		print $mod->social_links('horiz T_xlg B_lg');

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