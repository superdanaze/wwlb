<?php
    //  FUNDERS LOGOS

    $logos = $args['logos'];
    $func = $args['func'];
    $show_on_page = get_field( 'show_funders_logos_on_page', 'options' );
    $height = get_field( 'funders_logos_height', 'options' );
    $height_mobile = get_field( 'funders_logos_height_mobile', 'options' );
    $space = get_field( 'space_between_funders_logos', 'options' ) / 2;


    //  determine if output should occur
    if ( !in_array( get_the_ID(), $show_on_page ) ) return;

    //  styling
    $css = '
        .funders-inner .funder-logo-wrap {
            padding-inline:'. $space .'px;
        }

        @media screen and ( min-width : 1px ) {
            .funders-inner img {
                height:'. $height_mobile .'px;
            }
        }

        @media screen and ( min-width : 768px ) {
            .funders-inner img {
                height:'. $height .'px;
            }
        }
    ';

    $func->aggregate_css( NEW_CLIENT . '-footer', $css );


    //  logos wrap
    genesis_markup(
        [
            'open'		=> '<div %s>',
            'context'	=> NEW_CLIENT . '_funders',
            'atts'		=> [ 'class' => "funders full__container rel B_lg L_sm R_sm" ]
        ]
    );

        //  title
        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> NEW_CLIENT . '_funders_title',
                'atts'		=> [ 'class' => "funders-title full__container B_md rel" ],
                'content'   => '<h2 class="wwlb-title text_center off_white nomargin">WITH SUPPORT FROM</h2>',
                'close'		=> '</div>'
            ]
        );
        
        //  logos
        genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> NEW_CLIENT . '_funders_inner',
                'atts'		=> [ 'class' => "funders-inner full__container flex horiz vert wrap rel" ]
            ]
        );

            foreach( $logos as $key => $logo ) {
                print '<figure class="funder-logo-wrap">';
                    print wp_get_attachment_image( $logo['id'], 'large', false, array( 'alt' => $logo['alt'] ?? $logo['title'] ) );
                print '</figure>';
            }

        genesis_markup(
            [
                'context'	=> NEW_CLIENT . '_funders_inner',
                'close'		=> '</div>'
            ]
        );

    genesis_markup(
        [
            'context'	=> NEW_CLIENT . '_funders',
            'close'		=> '</div>'
        ]
    );
?>