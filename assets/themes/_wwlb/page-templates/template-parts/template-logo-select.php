<?php
    //  LOGO SELECTION

    // $header_style = $args['header_style'];

    // $light_eng = get_field( 'logo_light_english', 'options' );
    // $dark_eng = get_field( 'logo_dark_english', 'options' );
    // $light_esp = get_field( 'logo_light_spanish', 'options' );
    // $dark_esp = get_field( 'logo_dark_spanish', 'options' );

    // function ela_logo_area($args) {
    //     // global $args;
    //     $header_style = $args['header_style'];

    //     $light_eng = get_field( 'logo_light_english', 'options' );
    //     $dark_eng = get_field( 'logo_dark_english', 'options' );
    //     $light_esp = get_field( 'logo_light_spanish', 'options' );
    //     $dark_esp = get_field( 'logo_dark_spanish', 'options' );

    //     $output = "";


    //     if ( $header_style === "nav-light" ) {
    //         //  english
    //         $output .= '<span class="logo eng">';
    //             $output .= wp_get_attachment_image( $light_eng['url'], 'full', false, array( "alt" => $light_eng['description'] . " logo" ) );
    //         $output .= '</span>';

    //         //  español
    //         $output .= '<span class="logo esp">';
    //             $output .= wp_get_attachment_image( $light_esp['url'], 'full', false, array( "alt" => $light_esp['description'] . " logo" ) );
    //         $output .= '</span>';
    //     } else if ( $header_style === "nav-dark" ) {
    //         //  english
    //         $output .= '<span class="logo eng">';
    //             $output .= wp_get_attachment_image( $dark_eng['url'], 'full', false, array( "alt" => $dark_eng['description'] . " logo" ) );
    //         $output .= '</span>';

    //         //  español
    //         $output .= '<span class="logo esp">';
    //             $output .= wp_get_attachment_image( $dark_esp['url'], 'full', false, array( "alt" => $dark_esp['description'] . " logo" ) );
    //         $output .= '</span>';
    //     }

    //     $title = '<h1 itemprop="headline" class="site-title"><a title="Homepage" href="' . get_bloginfo('url') . '">';

    //     $title .= $output;

    //     $title .= '</a></h1>';
	    
    //     return $title;
    // }

    add_filter( 'genesis_seo_title', function() use( $args ) {
        $header_style = $args['header_style'];

        $light_eng = get_field( 'logo_light_english', 'options' );
        $dark_eng = get_field( 'logo_dark_english', 'options' );
        $light_esp = get_field( 'logo_light_spanish', 'options' );
        $dark_esp = get_field( 'logo_dark_spanish', 'options' );

        $output = "";


        if ( $header_style === "nav-light" ) {
            //  english
            $output .= '<span class="logo eng">';
                $output .= wp_get_attachment_image( $light_eng['id'], 'full', false, array( "alt" => $light_eng['description'] . " logo" ) );
            $output .= '</span>';

            //  español
            $output .= '<span class="logo esp">';
                $output .= wp_get_attachment_image( $light_esp['id'], 'full', false, array( "alt" => $light_esp['description'] . " logo" ) );
            $output .= '</span>';
        } else if ( $header_style === "nav-dark" ) {
            //  english
            $output .= '<span class="logo eng">';
                $output .= wp_get_attachment_image( $dark_eng['id'], 'full', false, array( "alt" => $dark_eng['description'] . " logo" ) );
            $output .= '</span>';

            //  español
            $output .= '<span class="logo esp">';
                $output .= wp_get_attachment_image( $dark_esp['id'], 'full', false, array( "alt" => $dark_esp['description'] . " logo" ) );
            $output .= '</span>';
        }

        $title = '<h1 itemprop="headline" class="site-title"><a title="Homepage" href="' . get_bloginfo('url') . '">';

        $title .= $output;

        $title .= '</a></h1>';
	    
        return $title;

    }, 10, 1 );

?>