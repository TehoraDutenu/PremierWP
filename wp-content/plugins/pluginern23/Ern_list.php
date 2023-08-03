<?php
// dans certaines version de WP il n'arrive pas à étendre la class WP_List_Table
// pour ce cas il faut charger manuellement cette classe
if (!class_exists("WP_List_Table")) {
    require_once ABSPATH . "wp-admin/includes/class-wp-list-table.php";
}

// on importe notre classe de service
require_once plugin_dir_path(__FILE__) . "service/Ern_Database_Service.php";


class Ern_List extends WP_List_Table
{
    // on va créer une variable en private qui va contenir l'instance de notre service
    private $dal;

    // 1.
    public function __construct() // on déclare le constructeur
    {
        // on va surcharger le constructeur de la class parente de WP_List_Table
        // pour redéfinir le nom de la table (singulier et au pluriel)
        parent::__construct(
            array(
                "singular" => __("Client"),
                "plural" => __("Clients")
            )
        );
        // on instancie notre service
        $this->dal = new Ern_Database_Service();
    }

    // 2.
    // on surcharge la méthode prepare_items()
    public function prepare_items() // fonction du parent
    {
        // on va définir toutes nos variables
        $columns = $this->get_columns(); // on va chercher les colonnes
        $hidden = $this->get_hidden_columns(); // on ajoute cette variable si on veut cacher des colonnes 
        $sortable = $this->get_sortable_columns(); // pour trier les rangs

        // PAGINATION
        $perPage = $this->get_items_per_page("clients_per_page", 10); // on choisit le nombre d'éléments par page
        $currentPage = $this->get_pagenum(); // on va chercher le numéro de la page courante

        // LES DONNÉES
        $data = $this->dal->findAll(); // on récupère les données dans la bdd
        $totalPage = count($data); // on va compter le nombre de données

        // TRI
        // &$this : pour faire référence à notre classe
        usort($data, array(&$this, "usort_reorder")); // on va trier les données

        $paginationData = array_slice($data, (($currentPage - 1) * $perPage), $perPage);

        // on va définir les valeurs de la pagination
        $this->set_pagination_args(
            array(
                "total_items" => $totalPage, // on passe le nombre total d'éléments
                "per_page" => $perPage // on passe le nombre d'éléments par page
            )
        );
        $this->_column_headers = array($columns, $hidden, $sortable); // on construit les en-têtes des colonnes

        // on alimente les données
        $this->items = $paginationData;
    }

    // 3.
    public function get_columns()
    {
        $columns = [
            'cb' => "<input type='checkbox' />", // case à cocher pour la suppression
            'id' => 'id',
            'nom' => 'Nom',
            'prenom' => 'Prenom',
            'email' => 'Email',
            'telephone' => 'Téléphone',
            'fidelite' => 'Fidélité'
        ];
        return $columns;
    }

    // 4.
    public function get_hidden_columns()
    {
        return [];
        // exemple : si on veut cacher la colonne id
        // return ['id' => 'id',];
    }

    // fonction pour le tri
    public function usort_reorder($a, $b)
    {
        // si je passe un paramètre de tri dans l'url
        // sinon on trie par défaut
        $orderBy = (!empty($_GET["orderby"])) ? $_GET["orderby"] : "id";
        // idem pour l'ordre de tri
        $order = (!empty($_GET["order"])) ? $_GET["order"] : "desc";
        $result = strcmp($a->$orderBy, $b->$orderBy); // on compare les deux valeurs
        return ($order === "asc") ? $result : -$result; // on retourne le résultat si asc, sinon on inverse le résultat
    }

    // 5.
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'id':
            case 'nom':
            case 'prenom':
            case 'email':
            case 'telephone':
            case 'fidelite':
                return $item->$column_name;
                break;
            default:
                return print_r($item, true);
        }
    }

    // 6.
    public function get_sortable_columns()
    {
        $sortable = [
            'id' => ['id', true],
            'nom' => ['nom', true],
            'prenom' => ['prenom', true],
            'email' => ['email', true],
            'telephone' => ['telephone', true],
            'fidelite' => ['fidelite', true],
        ];
        return $sortable;
    }


    // 7.
    public function column_cb($item)
    {
        $item = (array) $item; // on cast l'objet en tableau (pour pouvoir utiliser la méthode sprintf)
        return sprintf(
            '<input type="checkbox" name="delete-client[]" value="%s" />',
            $item["id"]
        );
    }

    // 7.
    public function get_bulk_actions()
    {
        $actions = [
            "delete-client" => __("Delete")
        ];
        return $actions;
    }
}
