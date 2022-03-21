<?php

    //  SCREENINGS TEMPLATE

    $__args = array(
        'post_type'             => 'screenings',
        'post_status'           => 'publish',
        'ignore_sticky_posts'   => true,
        'posts_per_page'		=> -1,
        'orderby'               => 'menu_order', 
        'order'                 => 'ASC'
    );

    $screenings = new WP_Query($__args);

    //  filter only upcoming events
    // $upcoming_screenings = array_filter( $screenings->posts, function($item) {
    //     $start = get_field( 'start_date', $item->ID ); 
    //     $end = get_field( 'end_date', $item->ID ); 
    //     $date = $end ? $end : $start;
    //     $today = date("m/d/Y");

    //     return $today <= $date;
    // });

    //  bypass filter
    $upcoming_screenings = $screenings->posts;

    //  reorder events chronologically
    usort( $upcoming_screenings, function($a, $b) {
        $adate; $bdate;

        if ( get_field( 'start_date', $a->ID ) ) {
            $adate = strtotime( get_field( 'start_date', $a->ID ) );
        } else if ( get_field( 'end_date', $a->ID ) ) {
            $adate = strtotime( get_field( 'end_date', $a->ID ) );
        } else {
            $adate = 0;
        }

        if ( get_field( 'start_date', $b->ID ) ) {
            $bdate = strtotime( get_field( 'start_date', $b->ID ) );
        } else if ( get_field( 'end_date', $b->ID ) ) {
            $bdate = strtotime( get_field( 'end_date', $b->ID ) );
        } else {
            $bdate = 0;
        }
        
        // $adate = strtotime( get_field( 'start_date', $a->ID ) );
        // $bdate = strtotime( get_field( 'start_date', $b->ID ) );

        // el__test( $adate );

        return $adate <=> $bdate;
    });
    
    genesis_markup(
        [
            'open'		=> '<div %s>',
            'context'	=> 'screenings',
            'atts'		=> [ 'class' => 'b-screenings scheme-'. $args['text'] .' full__container _large nomargin_children A_xsm rel' ]
        ]
    );

    //  if no upcoming screenings message
    if ( !count($upcoming_screenings) ) {
        genesis_markup(
            [
                'open'		=> '<h3 %s>',
                'context'	=> 'screenings_message',
                'atts'		=> [ 'class' => "b-screenings_message text_center" ],
                'content'   => $args['message'],
                'close'     => '</h3>'
            ]
        );
    }

    foreach( $upcoming_screenings as $key => $screening ) {
        $id = $screening->ID;
        $title_en = $screening->post_title;
        $title_es = get_field( 'screening_title_spanish', $id );
        $start_date = get_field( 'start_date', $id );
        $end_date = get_field( 'end_date', $id );
        $time = get_field( 'time', $id );
        $location = trim( esc_html( get_field( 'location_name', $id ) ) );
        $forum = get_field( 'online_or_in_person', $id );
        $link = trim( get_field( 'link', $id ) );
        $date = ""; $datetime = ""; $output = "";

        //  if limit to # of screenings
        if ( $args['limit'] !== null && $key < ( count($upcoming_screenings) - intval($args['limit']) ) ) continue;

        //  determine title output
        if ( $title_en && $title_es ) {
            $title = sprintf( '<span class="eng">%s</span>', trim( $title_en ) );
            $title .= sprintf( '<span class="esp">%s</span>', trim( $title_es ) );
        } else if ( $title_en && !$title_es) {
            $title = $title_en;
        } else if ( $title_es && !$title_en ) {
            $title = $title_es;
        }

        //  determine date output
        if ( $start_date && !$end_date ) {
            $date = $start_date;
        } else if ( $start_date && $end_date ) {
            $date = $start_date ." - ". $end_date;
        } else if ( !$start_date && $end_date ) {
            $date = $end_date;
        }

        //  determine date/time output
        if ( $date && $time ) {
            $datetime = $date ." @ ". $time;
        } else if ( $date && !$time ) {
            $datetime = $date;
        } else if ( !$date && $time ) {
            $datetime = $time;
        }

        //  set empty value for empty location
        if ( !$location ) $location = "";

        //  set wrapper atts
        $wrap = $link ? "a" : "div";
        $atts_class = "b-screening-item-wrap full__container grid rel";
        $atts = $link ? [ 'class' => $atts_class, 'href' => $link, 'target' => '_blank', 'rel' => 'nofollow' ] : [ 'class' => $atts_class ];


        //  date & time
        $output .= genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> 'screening__date',
                'atts'		=> [ 'class' => "b-screening-date" ],
                'content'   => '<p>'. $datetime .'</p>',
                'echo'      => false,
                'close'		=> '</div>'
            ]
        );

        //  title
        $output .= genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> 'screening__title',
                'atts'		=> [ 'class' => "b-screening-title" ],
                'content'   => '<p>'. $title .' ('. $forum .')</p>',
                'echo'      => false,
                'close'		=> '</div>'
            ]
        );

        //  location
        $output .= genesis_markup(
            [
                'open'		=> '<div %s>',
                'context'	=> 'screening__location',
                'atts'		=> [ 'class' => "b-screening-location" ],
                'content'   => '<p>'. $location .'</p>',
                'echo'      => false,
                'close'		=> '</div>'
            ]
        );

        //  output
        genesis_markup(
            [
                'open'		=> '<'. $wrap .' %s>',
                'context'	=> 'screening__item__wrap',
                'atts'		=> $atts,
                'content'   => $output,
                'close'		=> '</'. $wrap .'>'
            ]
        );
    }


    genesis_markup(
        [
            'context'	=> 'screenings',
            'close'		=> '</div>'
        ]
    );

?>