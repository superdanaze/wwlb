<?php 
    //  SECTION : ADD SPACE

    $row = $args['rowID'];
    $func = $args['func'];
    $breakpoints = array();
    $css = "";
    $vars = (object) array(
        'space_desktop'           => get_sub_field('space_desktop'),
        'space_tablet'            => get_sub_field('space_tablet'),
        'space_mobile'            => get_sub_field('space_mobile'),
        'background'              => get_sub_field('background'),
        'separator'               => get_sub_field('separator'),
        'separator_color'         => get_sub_field('separator_color')
    );

    switch( $vars->separator ) {
        case "none" : $vars->wrap = "none";
        break;

        case "small" : $vars->wrap = "25%";
        break;

        case "medium" : $vars->wrap = "50%";
        break;

        case "large" || "fw" : $vars->wrap = "100%";
        break;
    }

    //  height
    if ( $vars->space_mobile === "none" ) {
        $breakpoints['1'] = 0;
    } else if ( $vars->space_mobile === "default" ) {
        $breakpoints['1'] = $vars->space_desktop;
    } else {
        $breakpoints['1'] = $vars->space_mobile;
    }

    if ( $vars->space_tablet != $vars->space_mobile ) {
        if ( $vars->space_tablet === "none" ) {
            $breakpoints['768'] = 0;
        } else if ( $vars->space_tablet === "default" ) {
            $breakpoints['768'] = $vars->space_desktop;
        } else {
            $breakpoints['768'] = $vars->space_tablet;
        }
    }
    
    if ( isset( $breakpoints['768'] ) && $vars->space_desktop != $breakpoints['768'] ) {
        if ( $vars->space_desktop === "none" ) {
            $breakpoints['1025'] = 0;
        } else {
            $breakpoints['1025'] = $vars->space_desktop;
        }
    }

    foreach( $breakpoints as $key => $b ) {
        $css .= '
            @media screen and ( min-width:'. $key .'px ) {
                .add-space[data-row="'. $row .'"] .space-wrapper {
                    height:'. $b .';
                }
            }
        ';    
    }

    //  background color
    $css .= '
        .add-space[data-row="'. $row .'"] {
            background:'. $vars->background .';
        }
    ';

    //  separator color
    if ( $vars->separator !== "none" ) {
        $css .= '
            .add-space[data-row="'. $row .'"] .space-wrapper span {
                background:'. $vars->separator_color .';
            }
        ';
    }

    //  aggregate section css
    $func->aggregate_css( 'flex', $css );


    add_filter( 'genesis_entry_content', function() use( $vars, $row ) {

        ob_start();

            $container_classes = array("space-wrapper rel");

            $container_classes[] = $vars->wrap !== "fw" ? "container" : "full__container";
            if ( $vars->wrap !== "none" ) $container_classes[] = "flex horiz vert";
            

            genesis_markup([
                'open'		=> '<div %s>',
                'context'	=> 'space-wrap',
                'atts'		=> [ 'class' => implode( " ", $container_classes ) ]
            ]);

                if ( $vars->separator !== "none" ) {
                    genesis_markup([
                        'open'		=> '<span %s>',
                        'context'	=> 'space-separator',
                        'atts'		=> [ 'class' => "space-separator", 'style' => 'width:'. $vars->wrap .';' ],
                        'close'		=> '</span>'
                    ]);
                }

            genesis_markup([
                'context'	=> 'space-wrap',
                'close'		=> '</div>'
            ]);

        $output = ob_get_clean();


        //  OUTPUT
        genesis_markup(
            [
                'open'		=> '<section %s>',
                'context'	=> "add_space_" . $row,
                'atts'		=> [ 'class' => "add-space full__container rel", 'data-row' => $row ],
                'content'	=> $output,
                'close'		=> '</section>',
            ]
        );
    });
    
?>