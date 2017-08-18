<?php

/**
 * Count of who has liked something
 *
 *  @uses $vars['entity']
 */

$objKpax = new kpaxSrv(elgg_get_logged_in_user_entity()->username);

$list = '';

$guid = $vars['entity']->getGUID();




//TODO: using ELGG anootation
//aquest si mostra el likes, però incrementa cada vegada que recarrega la pàgina???
//$num_of_likes = likes_count($vars['entity']);
//mostra els likes incorrecta
//$num_of_likes = (string) count($objKpax->getLikesGame($_SESSION["campusSession"], $vars['entity']));

//Obtenim el joc de la BBDD
$joc =$objKpax->getGame($guid,$_SESSION["campusSession"]);
//convertir el JSON a un array
$dadesJoc = json_decode($joc['raw'], true);
//Assignem a $num_of_likes el valor corresponent (independent d'Elgg)

$num_of_likes=$dadesJoc["nlikes"];

//Comprovació de que treu el valor correcte
//printf("NLIKES");
//printf($num_of_likes);

if ($num_of_likes) {
    //display the number of likes
    if ($num_of_likes ==1) {
      $likes_string = elgg_echo('likes:userlikedthis', $num_of_likes);
    } else {
      $likes_string = elgg_echo('likes:userslikedthis', $dadesJoc['ulikes']);
    }


    $params = array(
        'text' => $likes_string,
        'title' => elgg_echo('likes:see'),
        'rel' => 'popup',
        'href' => "#likes-$guid"
    );
    $list = elgg_view('output/url', $params);
    $list .= "<div class='elgg-module elgg-module-popup elgg-likes-list hidden clearfix' id='likes-$guid'>";
    $list .= elgg_list_annotations(array('guid' => $guid, 'annotation_name' => 'likes', 'limit' => 99));
    $list .= "</div>";
    echo $list;
}


