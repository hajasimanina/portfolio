<?php
/*
 * Template Name: Portfolio
 * Description: Un modèle de page personnalisée utilisant Timber pour mon portfolio.
 */

use Timber\Timber;
use Timber\Post;

$context                                    = Timber::context();
$context['post']                            = Timber::get_post();
$context['portfolio']                       = get_fields();
$context['portfolio']['copyright']          = get_field( 'copyright', 'option' );
$context['portfolio']['site_designer']      = get_field( 'site_designer', 'option' );
$context['portfolio']['site_designer_link'] = get_field( 'site_designer_link', 'option' );
$theme                                      = wp_get_theme();
$context['text_domain']                     = $theme->get( 'TextDomain' );
/*Menu*/
$context['primary_menus'] = Timber::get_menu( 'primary' );

if ( ! empty( $context['portfolio']['profil_photo'] ) ) {
	$context['portfolio']['portfolio_photo'] = wp_get_attachment_image( $context['portfolio']['profil_photo'], 'full', false, array( 'alt' => 'portfolio_photo' ) );
}

/*Contact*/
$context['portfolio']['contacts_1'] = array_slice( $context['portfolio']['contacts'], 0, 3, false );
$context['portfolio']['contacts_2'] = array_slice( $context['portfolio']['contacts'], 3, 10, false );
unset( $context['portfolio']['contacts'] );

/*Skills*/
list( $skills1, $skills2 ) = timber_array_divider( $context['portfolio']['skills'], 2 );
$context['portfolio']['skills1'] = $skills1;
$context['portfolio']['skills2'] = $skills2;
unset( $context['portfolio']['skills'] );

/*Experience*/
$context['portfolio']['realization'] = timber_array_divider( $context['portfolio']['realization'], 3 );
list( $realization1, $realization2, $realization3 ) = timber_array_divider( $context['portfolio']['realization'], 3 );
$context['portfolio']['realization1'] = array_shift( $realization1 );
$context['portfolio']['realization2'] = array_shift( $realization2 );
$context['portfolio']['realization3'] = array_shift( $realization3 );
unset( $context['portfolio']['realization'] );

/*Clients*/
$client_count                         = count( $context['portfolio']['clients'] );
$context['portfolio']['client_class'] = $client_count > 7 ? 'owl-carousel owl-theme clients-display-with-owl-carousel' : 'clients-display-without-owl-carousel';

/**/
$certifications_count                         = count( $context['portfolio']['certifications'] );
$context['portfolio']['certifications_class'] = $certifications_count > 7 ? 'owl-carousel owl-theme clients-display-with-owl-carousel' : 'clients-display-without-owl-carousel';

Timber::render( 'portfolio.twig', $context );