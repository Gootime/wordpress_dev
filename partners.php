<?php
/**
 * Plugin Name: Mon plugin Partenaire
 * Plugin URI: http://www.lepoles.org
 * Description: Un plugin pour afficher / modifier des Partenaires
 * Version: 1.0
 * Author: Kevin CHERUEL
 * Author URI: http://www.lepoles.org
 * License: quésaco ???
 */

/**
 * Ajoute le type de poste personnalisé
 */
function partners_init() {
	$labels = array(
		'name'					=>	__('Partenaires', 'uep'),
		'singular_name'			=>	__('Partenaire', 'uep'),
		'add_new_item'			=>	__('Ajouter un Partennaire', 'uep'),
		'all_items'				=>	__('Tous les Partenaires', 'uep'),
		'edit_item'				=>	__('Modifier le Partenaire', 'uep'),
		'new_item'				=>	__('Nouveau Partenaires', 'uep'),
		'view_item'				=>	__('Voir Partenaires', 'uep'),
		'not_found'				=>	__('Aucun Parternaires trouvé', 'uep'),
		'not_found_in_trash'	=>	__('Aucun Partenaires trouvé dans la corbeille', 'uep')
	);

	register_post_type('partners', array(
		'public' => true,
		'publicly_queryable' => false,
		'has_archive' => true,
		'labels' => $labels,
		'menu_position' => 9,
		'supports' => array('thumbnail', 'author', 'title', 'editor')
		// Definit les fonctionnalitées supporter par le plugin
	));
}

/**
 * simple_events_shortcode  shortcode function
 *
 * @use [simple_partners_shortcode]
 */
function partners_shortcode_func( $atts ) {
	extract( shortcode_atts( array(
		'content' => 'all_content',
		'link' => 'no_link'
	), $atts ) );

	//TODO remove these hard-coded attribute-overrides in next version release
	$content = 'all_content';
	$link = 'no_link';

	return partners_display_shortcode($link, $content);
}

// Cette fonction permet de gérer les metabox du carroussel


// add meta box
function add_custom_meta_box()
{
    add_meta_box("demo-meta-box", "Raison Sociale du Partenaire", "custom_meta_box_markup", "partners", "advanced", "high", null);
    add_meta_box("demo-meta-boxTer", "Information sur le partenaire", "custom_meta_box_markupTer", "partners", "advanced", "high", null);
    add_meta_box("demo-meta-boxBis", "Région d'exercice du Partenaire", "custom_meta_box_markupBis", "partners", "advanced", "high", null);
    add_meta_box("demo-meta-boxQuad", "Contact du Partenaire", "custom_meta_box_markupQuad", "partners", "advanced", "high", null);
}

add_action("add_meta_boxes", "add_custom_meta_box");


/*First Block de Meta Box*/
function custom_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

    ?>
        <div>
            <label for="meta-box-text">Raison Sociale du Partenaire  :&nbsp;</label><br>
            <input name="meta-box-text" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-text", true); ?>" placeholder="Raison Sociale de la personne / Raison sociale de la structure" style="width:450px;" required autofocus>*

            <br>

        	
        </div>
    <?php  
}


function save_custom_meta_box($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "partners";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";
    $meta_box_dropdown_value = "";
    $meta_box_checkbox_value = "";

    if(isset($_POST["meta-box-text"]))
    {
        $meta_box_text_value = $_POST["meta-box-text"];
    }   
    update_post_meta($post_id, "meta-box-text", $meta_box_text_value);

    if(isset($_POST["meta-box-textBis"]))
    {
        $meta_box_dropdown_value = $_POST["meta-box-textBis"];
    }   
    update_post_meta($post_id, "meta-box-textBis", $meta_box_dropdown_value);
}

/* Fin du Block*/

/*Second Block de Meta Box*/
function custom_meta_box_markupBis($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonceBis");

    ?>
        <div>
            <label for="meta-box-dropdown">Region du Partenaire :</label><br>

            <select name="meta-box-dropdown" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-textBisBis", true); ?>">
            	<option value="Séléctionner Une Région">Séléctionner Une Région</option>
            	<option value="Alsace">Alsace</option>
            	<option value="Aquitaine">Aquitaine</option>
            	<option value="Auvergne">Auvergne</option>
            	<option value="Basse-Normandie">Basse-Normandie</option>
            	<option value="Bourgogne">Bourgogne</option>
            	<option value="Bretagne">Bretagne</option>
            	<option value="Centre">Centre</option>
            	<option value="Champagne-Ardenne">Champagne-Ardenne</option>
            	<option value="Corse">Corse</option>
            	<option value="Franche-Comté">Franche-Comté</option>
            	<option value="Haute-Normandie">Haute-Normandie</option>
            	<option value="Île-de-France">Île-de-France</option>
            	<option value="Languedoc-Roussillon">Languedoc-Roussillon</option>
            	<option value="Limousin">Limousin</option>
            	<option value="Lorraine">Lorraine</option>
            	<option value="Midi-Pyrénées">Midi-Pyrénées</option>
            	<option value="Nord-Pas-De-Calais">Nord-Pas-De-Calais</option>
            	<option value="Pays de la Loire">Pays de la Loire</option>
            	<option value="Picardie">Picardie</option>
            	<option value="Poitou-Charrente">Poitou-Charrente</option>
            	<option value="Provence-Alpes-Côte d'Azur">Provence-Alpes-Côte d'Azur</option>
            	<option value="Rhône-Alpes">Rhône-Alpes</option>
            	<option value="Guadeloupe">Guadeloupe</option>
            	<option value=">Guyane">Guyane</option>
            	<option value="La Réunion">La Réunion</option>
            	<option value="Martinique">Martinique</option>
            	<option value="Mayotte">Mayotte</option>

            </select>

            <br>

        	
        </div>
    <?php  
}


function save_custom_meta_boxBis($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonceBis"]) || !wp_verify_nonce($_POST["meta-box-nonceBis"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "partners";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";

    if(isset($_POST["meta-box-dropdown"])  && $_POST["meta-box-dropdown"] !== 'Séléctionner Une Région')
    {
        $meta_box_text_value = $_POST["meta-box-dropdown"];
    }   
    update_post_meta($post_id, "meta-box-dropdown", $meta_box_text_value);

}
/*Fin du Second Block*/

/*Troisième Block de Meta Box*/
function custom_meta_box_markupTer($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonceTer");

    ?>
        <div>
            <label for="meta-box-textTer">Activité du Partenaire :</label><br>
            <input name="meta-box-textTer" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-textTer", true); ?>" placeholder="Emploi du Partenaire / Secteur d'activité de la Structure" style="width:450px;" required>*

            <br>

        	
        </div>
    <?php  
}


function save_custom_meta_boxTer($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonceTer"]) || !wp_verify_nonce($_POST["meta-box-nonceTer"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "partners";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";

    if(isset($_POST["meta-box-textTer"]))
    {
        $meta_box_text_value = $_POST["meta-box-textTer"];
    }   
    update_post_meta($post_id, "meta-box-textTer", $meta_box_text_value);

    
}
/*Fin du troisième Block*/

//début quatrième block
function custom_meta_box_markupQuad($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonceQuad");

    ?>
        <div>
            <label for="meta-box-textQuad">Contact du Partenaire :</label><br>
            <input name="meta-box-textQuad" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-textQuad", true); ?>" placeholder="Contact du Partenaire / Contact de la Structure" style="width:450px;">

            <br>

        	
        </div>
    <?php  
}


function save_custom_meta_boxQuad($post_id, $post, $update)
{
    if (!isset($_POST["meta-box-nonceQuad"]) || !wp_verify_nonce($_POST["meta-box-nonceQuad"], basename(__FILE__)))
        return $post_id;

    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "partners";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";

    if(isset($_POST["meta-box-textQuad"]))
    {
        $meta_box_text_value = $_POST["meta-box-textQuad"];
    }   
    update_post_meta($post_id, "meta-box-textQuad", $meta_box_text_value);

    
}
//fin quatrième block


add_action("save_post", "save_custom_meta_box", 10, 3);
add_action("save_post", "save_custom_meta_boxBis", 10, 3);
add_action("save_post", "save_custom_meta_boxTer", 10, 3);
add_action("save_post", "save_custom_meta_boxQuad", 10, 3);



/**
 * Afficher les messages de type personnalisé
 *
 * Les params vont faire quelque chose dans les prochaines versions
 *
 * @param String $link
 * @param String $content
 * @return String $html_str
 */

function partners_display_shortcode($link='',$content=''){
	$html_str = '';

	$args = array( 'post_type' => 'partners', 'posts_per_page' => 6 );
	$loopy = new WP_Query( $args );

	while ( $loopy->have_posts() ) {
		$loopy->the_post();
		//verif thumbnails existante
		if ( has_post_thumbnail() ) {
    		$thumb = the_post_thumbnail();
		}
		else {
   			 $thumb = '<img src="http://wordpress.lepoles.com/wp-content/uploads/2016/07/not-found.png">';
}
//fin thumbnails


//verif des infos
	//Raison Sociale
	if(strlen(get_post_meta(get_the_ID(),"meta-box-text")[0]) === 0){
		$raison = "Non Renseigné lors de l'insertion";
	}
	else{
		$raison = implode(get_post_meta(get_the_ID(),"meta-box-text"));
	}

	//Activité
	if(strlen(get_post_meta(get_the_ID(),"meta-box-textTer")[0]) === 0){
		$activite = "Non Renseigné lors de l'insertion";
	}
	else{
		$activite = implode(get_post_meta(get_the_ID(),"meta-box-textTer"));
	}

	//Région
	if(strlen(get_post_meta(get_the_ID(),"meta-box-dropdown")[0]) === 0){
		$region = "Non Renseigné lors de l'insertion";
	}
	else{
		$region = implode(get_post_meta(get_the_ID(),"meta-box-dropdown"));
	}

	//Contact
	if(strlen(get_post_meta(get_the_ID(),"meta-box-textQuad")[0]) === 0){
		$url = "Non Renseigné lors de l'insertion";
	}
	else{
		$url = implode(get_post_meta(get_the_ID(),"meta-box-textQuad"));
	}
//fin des infos
	$id = get_the_ID();
		$html_str .=
		$count = 1;
			'<div class="singleArticle" id="'. the_post() . $count++ . '">'
				.'<div class="imgArticle" id="'. the_post_thumbnail(). $count++ .'" style="font-family: "Ruda", sans-serif;">'

                    .'<div class="metaArticle">'
						.'<p class="categoryArticle">'. the_category(). '</p>'
						.'<p class="dateArticle">'. the_date(). '</p>'
                        .'<p class="titreArticle"><a href="'. the_permalink() | the_title(). '</a></p>'
                        .'<p class="extraitArticle">'. excerpt(20). '</p>'
                    .'</div>'
                .'</div>'
            .'</div>';
	}

	return $html_str;
}
add_shortcode( 'simple_partners_shortcode', 'partners_shortcode_func' );
add_action( 'init', 'partners_init' );
?>
