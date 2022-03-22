<?php

    //  SCREENINGS TEMPLATE

    $__args = array(
        'post_type'             => 'quote',
        'post_status'           => 'publish',
        'ignore_sticky_posts'   => true,
        'posts_per_page'		=> $args['limit'],
        'orderby'               => 'menu_order', 
        'order'                 => 'ASC'
    );

    $quotes = new WP_Query($__args);
    $cols = $args['columns'];

    
    genesis_markup(
        [
            'open'		=> '<div %s>',
            'context'	=> 'quotes',
            'atts'		=> [ 'class' => 'b-press full__container _large rel' ]
        ]
    );

        //  if no press message
        if ( !count($quotes->posts) ) {
            genesis_markup(
                [
                    'open'		=> '<h3 %s>',
                    'context'	=> 'press_message',
                    'atts'		=> [ 'class' => "b-screenings_message text_center" ],
                    'content'   => "There are currently no quotes to read. Please check back soon!",
                    'close'     => '</h3>'
                ]
            );
        } else {
            //  have press articles
            genesis_markup(
                [
                    'open'		=> '<div %s>',
                    'context'	=> 'quotes_wrap',
                    'atts'		=> [ 'class' => 'b-quotes-wrap b-press-wrap full__container grid', 'data-cols' => $cols ]
                ]
            );

                //  cycle through press articles
                foreach( $quotes->posts as $key => $q ) {
                    $id = $q->ID;
                    $quote_en = trim(get_field( 'quote_english', $id ));
                    $quote_es = trim(get_field( 'quote_spanish', $id ));
                    $text_size = trim(get_field( 'text_size', $id ));
                    $author = trim(get_field( 'author', $id ));
                    $link = trim(get_field( 'author_link', $id ));


                    // $title_en = trim($p->post_title);
                    // $title_es = trim(get_field( 'article_title_spanish', $id ));
                    // $date = trim(get_field( 'date_of_article', $id ));
                    // $publication = trim(get_field( 'publication', $id ));
                    // $link = trim( get_field( 'link_to_article', $id ) );
                    // $img = get_the_post_thumbnail_url( $id, "medium-large" );

                    // $bg = $img ? $img : $root . $fallbacks[mt_rand(0, count($fallbacks) - 1)] . '.jpg';

                    printf( '<div class="quote-item flex horiz vert rel" data-itemno="%s">', $key );


                            //  inner wrap
                            print '<div class="quote-item-inner">';

                                //  title
                                printf( '<h6 class="nopoint %s">', $text_size );
                                    if ( $quote_en && $quote_es ) {
                                        printf( '<span class="eng">%s</span>', $quote_en );
                                        printf( '<span class="esp">%s</span>', $quote_es );
                                    } else if ( $quote_en && !$quote_es ) {
                                        print $quote_en;
                                    }
                                    else if ( !$quote_en && $quote_es ) {
                                        print $quote_es;
                                    }
                                print '</h6>';

                                //  author
                                if ( $link ) printf( '<a class="easy_does_it" href="%s" target="_blank" rel="nofollow">', trim( $link ) );
                                    if ( $author ) printf( '<p class="quote-author nomargin L_micro easy_does_it">%s</p>', trim( $author ) );
                                if ( $link ) print '</a>';

                            print '</div>';
                    print '</div>';
                }

            genesis_markup(
                [
                    'context'	=> 'quotes_wrap',
                    'close'		=> '</div>'
                ]
            );
        }


    genesis_markup(
        [
            'context'	=> 'quotes',
            'close'		=> '</div>'
        ]
    );

?>