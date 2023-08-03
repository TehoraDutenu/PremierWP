<?php
class Ern_Random_Photo_Widget extends WP_Widget
{
    // on surcharge son constructor
    public function __construct()
    {
        // on déclare une variable avec les options du widget
        $widget_ops = array( // on ajoute des options au widget
            // ajout d'une classe css
            "className" => "ern_random_photo",
            // ajout d'une description
            "description" => __("Show Random Photo"), // on traduit le texte
            // pour éviter de rafraîchir la fenêtre du navigateur
            'customize_selective_refresh' => true,
        );
        // on surcharge le constructor
        parent::__construct(
            // on donne une nom au widget
            'photos',
            // on lui donne un titre
            __("Random Photo"),
            // on lui donne des options
            $widget_ops
        );
    }

    // création du formulaire de configuration du widget
    public function form($instance)
    {
        // création d'un tableau par défaut
        // wp_parse_args permet de fusionner les valeurs dans un tableau
        $instance = wp_parse_args((array) $instance, [
            "query" => "",
            "nbr" => "",
            "cle" => ""
        ]);
?>

        <!-- Création de nos inputs -->
        <div>
            <label for="<?php echo $this->get_field_id('query') ?>">Mot de recherche</label>
            <input type="text" name="<?php echo $this->get_field_name('query') ?>" id="<?php echo $this->get_field_id('query') ?>" value="<?php esc_attr($instance['query']) ?>">
        </div>
        <div>
            <label for="<?php echo $this->get_field_id('nbr') ?>">Nombre de photos</label>
            <input type="text" name="<?php echo $this->get_field_name('nbr') ?>" id="<?php echo $this->get_field_id('nbr') ?>" value="<?php esc_attr($instance['nbr']) ?>">
        </div>
        <div>
            <label for="<?php echo $this->get_field_id('cle') ?>">Clé unsplash</label>
            <input type="text" name="<?php echo $this->get_field_name('cle') ?>" id="<?php echo $this->get_field_id('cle') ?>" value="<?php esc_attr($instance['cle']) ?>">
        </div>
<?php
    }

    // création de la fonction update pour modifier les valeurs
    // du formulaire et générer d'autres images
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        // sanitize_text_field permet de nettoyer les données
        $instance['query'] = sanitize_text_field($new_instance['query']);
        $instance['nbr'] = sanitize_text_field($new_instance['nbr']);
        $instance['cle'] = sanitize_text_field($new_instance['cle']);

        return $instance;
    }

    // création de la fonction widget pour afficher les images
    public function widget($args, $instance)
    {
        // on définit le titre
        $title = "Photos";
        // nombre de photos minimum
        ($instance['nbr'] != 0) ? $nbr = $instance['nbr'] : $nbr = 1;
        // construction de l'url de l'API Unsplash
        $url = "https://api.unsplash.com/search/photos?query=" . $instance['query'] . "&per_page=" . $nbr;

        // configurer les headers pour autoriser la consommation de l'API
        $argCle = [
            'headers' => [
                'Authorization' => 'Client-ID ' . $instance['cle']
            ]
        ];

        // on fait appel à l'API grâce à wp_remote_get
        $request = wp_remote_get($url, $argCle);

        // gestion d'erreurs de retour
        if (is_wp_error($request)) {
            return false;
        }

        // si ok, on récupère le body de la réponse sous forme de json
        $body = wp_remote_retrieve_body($request);
        // on décode le json
        $data = json_decode($body, true);

        // on construit le rendu html pour affichage
        echo $args['before_widget'];
        // on affiche le titre
        echo $args['before_title'] . $title . $args['after_title'];
        // on affiche les images
        echo "<div class='photo'>";

        // on va boucler sur les images reçues
        if (!empty($data)) {
            for ($i = 0; $i < $nbr; $i++) {
                echo "<p>" . $data['results'][$i]['id'] . "</p>";
                echo "<img src='" . $data['results'][$i]['urls']['thumb'] . "' alt='" . $data['results'][$i]['description'] . "' />";
            }
        }
        echo "</div>";
        echo $args['after_widget'];
        return '';
    }
}
