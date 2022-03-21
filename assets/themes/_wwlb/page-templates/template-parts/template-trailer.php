<?php

    //  FILM TRAILER TEMPLATE
        global $super_mods;
        $funcs = $super_mods->funcs;
        $trailerID = $super_mods->trailerID;
        $type = $super_mods->trailer_type;


        if ( $trailerID !== "" ) {
            ob_start();

                //  close X
                genesis_markup(
                    [
                        'open'      => '<div %s>',
                        'context'   => 'trailer_close_X',
                        'atts'      => [ 'class' => 'closeX-wrap '. $type .' flex horiz vert abs z10', 'data-action' => 'trailer-close' ],
                        'content'   => '<span></span><span></span>',
                        'close'     => '</div>'
                    ]
                );

                //  trailer
                if ( $type === 'youtube' ) {
                    print ELA_Elements::youtubeVideo( $trailerID, 'full__height', true );
                } else if ( $type === 'vimeo' ) {
                    print ELA_Elements::vimeoVideo( $trailerID, 'full__height', true );
                }

            $output = ob_get_clean();


            genesis_markup(
                [
                    'open'		=> '<div %s>',
                    'context'	=> 'trailer_wrap',
                    'atts'		=> [ 'id' => '__trailer', 'class' => "ela-trailer-wrap full__container full__frame__height topleft bg_dk_dk_grey fixed start hide z100" ],
                    'content'   => $output,
                    'close'		=> '</div>'
                ]
            );

        } else {
            $css = "
                ul.menu li.trailer {
                    display:none !important;
                }
            ";

            $funcs->aggregate_css( 'trailer', $css, true );
        }



?>