<?php
    //  ACF FLEXIBLE CONTENT CONTROLLER

    $func = new ELA_Funcs;

    while ( have_rows('sections') ) : the_row();

        //  GET CONTENT SECTION
        get_template_part( E_FLEX, get_row_layout(), array( "rowID" => get_row_index(), "func" => $func ) );

    endwhile;

    //  print section styles
    $func->aggregate_css( 'flex', false, true );
?>