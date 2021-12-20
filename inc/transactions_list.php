<?php
function register_my_session(){
    if( ! session_id() ) {
        session_start();
    }
}

add_action('init', 'register_my_session');

if(is_admin())
{
    new Paulund_Wp_List_Table();
}

/**
 * Paulund_Wp_List_Table class will create the page to load the table
 */
class Paulund_Wp_List_Table
{
    /**
     * Constructor will create the menu item
     */
    public function __construct()
    {
        add_action( 'admin_menu', array($this, 'add_menu_example_list_table_page' ));
    }

    /**
     * Menu item will allow us to load the page to display the table
     */
    public function add_menu_example_list_table_page()
    {
        add_menu_page( 'Tous les dons', 'Tous les dons', 'manage_options', 'all-transactions.php', array($this, 'list_table_page'), 'dashicons-awards' );
    }

    public function get_epxrt_url(){
      $url = wp_nonce_url(
        add_query_arg(
          array(
            $_SERVER['QUERY_STRING'] => '',  
            'export_xls' => 'xls',
            'export_tri' => urlencode($_SESSION['filtre_tri']),
            'export_col' => urlencode($_SESSION['filtre_col']),
          )       
        ), home_url( $wp->request ) 
      );

      return $url;
    }

    /**
     * Display the list table page
     *
     * @return Void
     */
    public function list_table_page()
    {
        $exampleListTable = new Transaction_List_Table();
        $exampleListTable->prepare_items();
        ?>
          <style type="text/css">
            .d-flex{ display: flex; align-items: center }
            .justify-space-btw{ justify-content: space-between; }
          </style>
            <div class="wrap">              
                <h2>Liste de tous les dons</h2>
                <div class="d-flex justify-space-btw">
                  <div class="d-flex filtre_wrap">
                    Filtrer par 
                    <select id="filtre_tri">
                      <option value=""></option>
                      <option value="all">Tous</option>
                      <option value="cagnotte">cagnotte</option>
                      <option value="paiement">mode de paiement</option>
                      <option value="date">date de paiement</option>
                    </select>
                    <div id="loader-bo" style="display: none;"><img style=" width: 15px; height: 15px; display: flex" src="<?= IMG_URL . 'loader.gif'?>"></div>
                    <form id="form_interne" action="<?= admin_url( 'admin.php?page=all-transactions.php' ) ?>" method="POST" style="display: none">
                      <label for="tri">&nbsp;&nbsp; Sélectionner : <span id="le_filtre"></span></label>
                      <select id="tri" name="filtre_tri">
                        <!-- auto-populate avy @ ajax -->
                      </select>
                      <input type="hidden" id="hidden_filtre" name="hidden_filtre" value="*">
                      <input type="submit" name="trier" value="GO">
                    </form>
                  </div>
                  <div class="btn-export">
                    <a href="<?= $this->get_epxrt_url(); ?>" class="page-title-action">Exporter en XLS</a>
                  </div>  
                </div>
                <div>
                  <?php 
                  if( $_SESSION['filtre_col'] != '' ):
                    $col = $_SESSION['filtre_col'] == 'id_cagnotte' ? 'cagnotte' : $_SESSION['filtre_col'];
                  ?>
                  Affichage des dons par <b><?php echo $col. ' : '. $_SESSION['filtre_tri']; ?></b>
                <?php endif; ?>
                </div>           
              <?php $exampleListTable->display(); ?>
            </div>
        <?php
    }
}

// WP_List_Table is not loaded automatically so we need to load it in our application
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class Transaction_List_Table extends WP_List_Table
{
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );

        $perPage = 20;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'cagnotte'       => 'Nom de la cagnotte',
            'donateur'       => 'Donateur',
            'montant'        => 'Montant',
            'mode_paiement'  => 'Mode de paiement',
            'benef'          => 'Bénéficiaire',
            'date'           => 'Date de paiement',
        );

        return $columns;
    }

    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array(
          'cagnotte'     => array('cagnotte', false),
          'montant'      => array('montant', false),
          'mode_paiement'=> array('mode_paiement', false),
          'date'         => array('date', false),
        );
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
        $data = array();

        // raha avy manao sumbit anlé form
        // alors afftecté submitted value à une varible de session
        // :)

        if( isset( $_POST['filtre_tri'] ) && !empty( $_POST['filtre_tri'] ) ){
          $filtre = strip_tags( $_POST['filtre_tri'] );
          $_SESSION['filtre_tri'] = $filtre;
        }elseif( isset( $_SESSION['filtre_tri'] ) && !empty(  $_SESSION['filtre_tri'] ) ){
          $filtre =  $_SESSION['filtre_tri'];
        }else{
          $filtre = '';
        }
        

        $filtre_col = strip_tags( $_POST['hidden_filtre'] );

        if( $filtre == '' ){
          $all_transactions = get_all_transactions();
        }elseif( $filtre_col == 'id_cagnotte' || $_SESSION['filtre_col'] == 'id_cagnotte' ){
          
          $all_transactions = get_all_transactions_by_cagnotte_name( $filtre );
        }elseif( $filtre_col == 'date'  || $_SESSION['filtre_col'] == 'date' ){
          $all_transactions = get_all_transactions_by_date( $filtre );
        }elseif( $filtre_col == 'paiement'  || $_SESSION['filtre_col'] == 'paiement' ){
          $all_transactions = get_all_transactions_by_paiement( $filtre );
        }

        if( is_array($all_transactions) && count($all_transactions) ){
          foreach( $all_transactions as $res ){
            $date = $res->date == '0000-00-00' ? '': $res->date;
            $benef = get_field('benef_cagnotte', $res->id_cagnotte);
            $benef = $benef[0];
            $benef = $benef->post_title != '' ? $benef->post_title : '-';

            $data[] = array(
              'cagnotte'       => get_field('nom_de_la_cagnotte', $res->id_cagnotte),
              'donateur'       => $res->lname.' '.$res->fname,
              'montant'        => (int)$res->donation,
              'mode_paiement'  => $res->paiement,
              'benef'          => $benef,
              'date'           => $date,
            );
          }
        }

        return $data;
    }

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'cagnotte':
            case 'donateur':
            case 'montant':
            case 'mode_paiement':
            case 'benef':
            case 'date':
                return $item[ $column_name ];

            default:
                return print_r( $item, true ) ;
        }
    }

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'cagnotte';
        $order = 'asc';

        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }

        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }

        if( $orderby === 'montant'){
          $result = strnatcmp( $a[$orderby], $b[$orderby] );
        }else{
          $result = strcmp( $a[$orderby], $b[$orderby] );
        }

        if( $order === 'asc' )
        {
            return $result;
        }

        return -$result;
    }
}

require_once 'export-xls.php';
