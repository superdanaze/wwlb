<?php
/**
 * Genesis Sample.
 *
 * This file adds the landing page template to the Genesis Sample Theme.
 *
 * Template Name: Temporary Landing
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
 */

 ?>

<html lang="en-US">
<head itemscope itemtype="https://schema.org/WebSite">
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>What We Leave Behind</title>
<meta name='robots' content='max-image-preview:large' />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Eczar:wght@400;500;600;700;800&family=Lusitana:wght@400;700&family=Special+Elite&display=swap" rel="stylesheet">
<link rel="canonical" href="https://whatweleavebehindfilm.com/" />
<!-- Genesis Open Graph -->
<meta property="og:title" content="What We Leave Behind" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://whatweleavebehindfilm.com/" />
<link rel="pingback" href="https://whatweleavebehindfilm.com/xmlrpc.php" />
<meta itemprop="name" content="What We Leave Behind" />
<meta itemprop="url" content="https://whatweleavebehindfilm.com/" />

<style>
    html, body {
        width:100%;
        margin:0;
        padding:0;
    }
    @keyframes fadein {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
    .home {
        background:#221702;
        width:100%;
        height:100vh;
        top:0;
        left:0;
        display: -webkit-flex;
        display: flex;
        -webkit-justify-content:center;
        -webkit-justify-content:center;
        align-items:center;
        z-index: 0;
        position: relative;
    }
    .home:before {
        background:#221702;
        width:100%;
        height:100%;
        top:0;left:0;
        content:"";
        display: block;
        opacity:0.45;
        z-index: 1;
        position: absolute;
    }
    .home > img,
    .home .banner {
        opacity:0;
        -webkit-animation:fadein 0.5s ease-out forwards;
        animation:fadein 0.5s ease-out forwards;
    }
    .home > img {
        width:100%;
        height:100%;
        -o-object-fit:cover;
        object-fit:cover;
        position: absolute;
    }
    .home .banner {
        width:100%;
        max-width:500px;
        z-index: 2;
        -webkit-animation-delay:0.5s;
        animation-delay:0.5s;
        padding:15px;
        position: relative;
    }
    .home .banner img {
        width:100%;
        max-width:100%;
        height:auto;
    }
    .home .banner h4 {
        font-family:'Special Elite', serif;
        font-size:22px;
        text-align:center;
        letter-spacing:2px;
        color:#fff;
        margin-top:50px;
    }
</style>
</head>

<?php
    $img = get_the_post_thumbnail();
    $content = get_the_content();
    $light_eng = get_field( 'logo_light_english', 'options' );
?>

<div class="home">
    <?php print $img; ?>
    <div class="banner">
        <?php print $content; ?>
        <h4>coming soon</h4>
    </div>
</div>