<?php

    //  SCREENINGS TEMPLATE

    $__args = array(
        'post_type'             => 'press',
        'post_status'           => 'publish',
        'ignore_sticky_posts'   => true,
        'posts_per_page'		=> $args['limit'],
        // 'posts_per_page'		=> -1,
        'orderby'               => 'menu_order', 
        'order'                 => 'ASC'
    );

    $press = new WP_Query($__args);
    $cols = $args['columns'];
    $fallbacks = array( 'buying-ticket-durango', 'julian-bus-waiting', 'julian-pickup', 'julian-plaid-smile', 'watching-workers' );
    $root = '/' . IMG_USER_PATH . 'articles/';

    
    genesis_markup(
        [
            'open'		=> '<div %s>',
            'context'	=> 'press',
            'atts'		=> [ 'class' => 'b-press full__container _large rel' ]
        ]
    );

        //  if no press message
        if ( !count($press->posts) ) {
            genesis_markup(
                [
                    'open'		=> '<h3 %s>',
                    'context'	=> 'press_message',
                    'atts'		=> [ 'class' => "b-screenings_message text_center" ],
                    'content'   => "There are currently no articles to read. Please check back soon!",
                    'close'     => '</h3>'
                ]
            );
        } else {
            //  have press articles
            genesis_markup(
                [
                    'open'		=> '<div %s>',
                    'context'	=> 'press_wrap',
                    'atts'		=> [ 'class' => 'b-press-wrap full__container grid', 'data-cols' => $cols ]
                ]
            );

                //  cycle through press articles
                foreach( $press->posts as $key => $p ) {
                    $id = $p->ID;
                    $title_en = trim($p->post_title);
                    $title_es = trim(get_field( 'article_title_spanish', $id ));
                    $date = trim(get_field( 'date_of_article', $id ));
                    $publication = trim(get_field( 'publication', $id ));
                    $link = trim( get_field( 'link_to_article', $id ) );
                    $img = get_the_post_thumbnail_url( $id, "medium-large" );

                    $bg = $img ? $img : $root . $fallbacks[mt_rand(0, count($fallbacks) - 1)] . '.jpg';

                    printf( '<article class="press-item flex noover rel" data-itemno="%s">', $key );

                        //  link
                        if ( $link ) printf( '<a class="press-item-link full__container full__height flex noover rel" href="%s" target="_blank" rel="nofollow">', $link );

                            //  background
                            printf( '<div class="press-item-bg full__container full__height background center abs topleft z0 easy_does_it" style="background:url(%s)"></div>', $bg );

                            //  inner wrap
                            print '<div class="press-item-inner A_xsm rel z1 easy_does_it">';

                                //  date
                                printf( '<p class="date off_white nomargin">%s</p>', $date );

                                //  title
                                print '<h6 class="off_white nomargin">';
                                    if ( $title_en && $title_es ) {
                                        printf( '<span class="eng">%s</span>', $title_en );
                                        printf( '<span class="esp">%s</span>', $title_es );
                                    } else if ( $title_en && !$title_es ) {
                                        print $title_en;
                                    }
                                print '</h6>';

                                //  publication
                                if ( $publication ) {
                                    printf( '<figcaption class="nomargin"><p class="off_white nomargin">-- %s</p></figcaption>', $publication );
                                }

                            print '</div>';

                        if ( $link ) print '</a>';

                    print '</article>';
                }

            genesis_markup(
                [
                    'context'	=> 'press_wrap',
                    'close'		=> '</div>'
                ]
            );
        }


    genesis_markup(
        [
            'context'	=> 'press',
            'close'		=> '</div>'
        ]
    );

?>