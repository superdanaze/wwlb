<?php

    //  FILM TRAILER TEMPLATE

        $trailerID = get_field('trailer_id', 'options');
        $type = get_field('trailer_type', 'options');


        if ( $trailerID !== "" ) {
            //  wrap open
            genesis_markup(
                [
                    'open'		=> '<div %s>',
                    'context'	=> 'trailer_wrap',
                    'atts'		=> [ 'id' => '__trailer', 'class' => "ela-trailer-wrap full__container full__frame__height topleft bg_dk_dk_grey fixed start hide" ]
                ]
            );

            //  close X
            genesis_markup(
                [
                    'open'      => '<div %s>',
                    'context'   => 'trailer_close_X',
                    'atts'      => [ 'class' => 'closeX-wrap '. $type .' flex horiz vert abs z10', 'data-action' => 'trailer_close' ],
                    'content'   => '<span></span><span></span>',
                    'close'     => '</div>'
                ]
            );

            //  trailer
            if ( $type === 'youtube' ) {
                print ELA_Elements::youtubeVideo( $trailerID, 'full__height hide start' );
            } else if ( $type === 'vimeo' ) {
                print ELA_Elements::vimeoVideo( $trailerID, 'full__height hide start' );
            }

            //  wrap close
            genesis_markup(
                [
                    'context'	=> 'trailer_wrap',
                    'close'		=> '</div>'
                ]
            );

        } else {
            $css = "
                <style>
                    ul.menu li.trailer {
                        display:none !important;
                    }
                </style>
            ";

            print minimizeCSS($css);
        }


?>