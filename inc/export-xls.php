<?php

class CSVExport {
    /** Constructor */
    public function __construct() {
        if (isset($_GET['export_xls'])) {
          $csv = $this->generate_xls();
          header("Pragma: public");
          header("Expires: 0");
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Cache-Control: private", false);
          header("Content-Type: application/octet-stream");
          header("Content-Disposition: attachment; filename=\"report.csv\";");
          header("Content-Transfer-Encoding: binary");
          echo $csv;
          exit;
        }
        // Add extra menu items for admins
        // add_action('admin_menu', array($this, 'admin_menu'));
    }

    /**
     * Converting data to XLS
     */
    public function generate_xls() {
        if( !current_user_can( 'manage_options' ) ){ return false; }
        if( !is_admin() ){ return false; }
        // Nonce Check
        // $nonce = isset( $_GET['_wpnonce'] ) ? $_GET['_wpnonce'] : '';
        // if ( ! wp_verify_nonce( $nonce, 'export_don_kk' ) ) {
        //     die( 'Erreur de sécurité' );
        // }
        ob_start();
        $filename = 'Liste_don_'.date('d-m-Y_H-i-s').'.xls';
        $header_row = array( 
          __('Cagnotte','kotikota'), 
          __('Nom et Prénoms du donateur','kotikota'), 
          __('Montant donné','kotikota'), 
          __('Mode de paiement','kotikota'), 
          __('Bénéficiaire','kotikota'), 
          __('Date du don','kotikota'),
        );
        $data_rows = array();

        //# export_col = colonne any @table participation
        //# export_tri = valeur an'io export_col io ao @ table

        if( isset( $_GET['export_tri']) && !empty( $_GET['export_tri']) )
          $export_tri = strip_tags($_GET['export_tri']);

        //# possible values of $orderby: cagnotte|montant|mode_paiement|date
        //# possible values of $order: asc|desc

        if( isset( $_GET['orderby']) && !empty( $_GET['orderby']) )
          $orderby = strip_tags($_GET['orderby']);

        if( isset( $_GET['order']) && !empty( $_GET['order']) )
          $order = strip_tags($_GET['order']);

        if( strip_tags($_GET['export_col']) == 'id_cagnotte' ){ 

          if( $orderby == 'cagnotte' && $order == 'asc' ){
            $info_users = get_all_transactions_by_cagnotte_name( $export_tri, 'id_cagnotte', 'ASC' );
          }elseif( $orderby == 'cagnotte' && $order == 'desc' ){
            $info_users = get_all_transactions_by_cagnotte_name( $export_tri, 'id_cagnotte', 'DESC' );
          }elseif( $orderby == 'montant' && $order == 'asc' ){
            $info_users = get_all_transactions_by_cagnotte_name( $export_tri, 'donation', 'ASC' );
          }elseif( $orderby == 'montant' && $order == 'desc' ){
            $info_users = get_all_transactions_by_cagnotte_name( $export_tri, 'donation', 'DESC' );
          }elseif( $orderby == 'mode_paiement' && $order == 'asc' ){
            $info_users = get_all_transactions_by_cagnotte_name( $export_tri, 'paiement', 'ASC' );
          }elseif( $orderby == 'mode_paiement' && $order == 'desc' ){
            $info_users = get_all_transactions_by_cagnotte_name( $export_tri, 'paiement', 'DESC' );
          }elseif( $orderby == 'date' && $order == 'asc' ){
            $info_users = get_all_transactions_by_cagnotte_name( $export_tri, 'date', 'ASC' );
          }elseif( $orderby == 'date' && $order == 'desc' ){
            $info_users = get_all_transactions_by_cagnotte_name( $export_tri, 'date', 'DESC' );
          }else{
            $info_users = get_all_transactions_by_cagnotte_name( $export_tri );
          }
          
        }elseif( $_GET['export_col'] == 'date' ){
          if( $orderby == 'cagnotte' && $order == 'asc' ){
            $info_users = get_all_transactions_by_date( $export_tri, 'id_cagnotte', 'ASC' );
          }elseif( $orderby == 'cagnotte' && $order == 'desc' ){
            $info_users = get_all_transactions_by_date( $export_tri, 'id_cagnotte', 'DESC' );
          }elseif( $orderby == 'montant' && $order == 'asc' ){
            $info_users = get_all_transactions_by_date( $export_tri, 'donation', 'ASC' );
          }elseif( $orderby == 'montant' && $order == 'desc' ){
            $info_users = get_all_transactions_by_date( $export_tri, 'donation', 'DESC' );
          }elseif( $orderby == 'mode_paiement' && $order == 'asc' ){
            $info_users = get_all_transactions_by_date( $export_tri, 'paiement', 'ASC' );
          }elseif( $orderby == 'mode_paiement' && $order == 'desc' ){
            $info_users = get_all_transactions_by_date( $export_tri, 'paiement', 'DESC' );
          }elseif( $orderby == 'date' && $order == 'asc' ){
            $info_users = get_all_transactions_by_date( $export_tri, 'date', 'ASC' );
          }elseif( $orderby == 'date' && $order == 'desc' ){
            $info_users = get_all_transactions_by_date( $export_tri, 'date', 'DESC' );
          }else{
            $info_users = get_all_transactions_by_date( $export_tri );
          }

        }elseif( $_GET['export_col'] == 'paiement'  ){
          if( $orderby == 'cagnotte' && $order == 'asc' ){
            $info_users = get_all_transactions_by_paiement( $export_tri, 'id_cagnotte', 'ASC' );
          }elseif( $orderby == 'cagnotte' && $order == 'desc' ){
            $info_users = get_all_transactions_by_paiement( $export_tri, 'id_cagnotte', 'DESC' );
          }elseif( $orderby == 'montant' && $order == 'asc' ){
            $info_users = get_all_transactions_by_paiement( $export_tri, 'donation', 'ASC' );
          }elseif( $orderby == 'montant' && $order == 'desc' ){
            $info_users = get_all_transactions_by_paiement( $export_tri, 'donation', 'DESC' );
          }elseif( $orderby == 'mode_paiement' && $order == 'asc' ){
            $info_users = get_all_transactions_by_paiement( $export_tri, 'paiement', 'ASC' );
          }elseif( $orderby == 'mode_paiement' && $order == 'desc' ){
            $info_users = get_all_transactions_by_paiement( $export_tri, 'paiement', 'DESC' );
          }elseif( $orderby == 'date' && $order == 'asc' ){
            $info_users = get_all_transactions_by_paiement( $export_tri, 'date', 'ASC' );
          }elseif( $orderby == 'date' && $order == 'desc' ){
            $info_users = get_all_transactions_by_paiement( $export_tri, 'date', 'DESC' );
          }else{
            $info_users = get_all_transactions_by_paiement( $export_tri );
          }

        }else{
            if( $orderby == 'cagnotte' && $order == 'asc' ){
              $info_users = get_all_transactions( '*', 'id_cagnotte', 'ASC' );
            }elseif( $orderby == 'cagnotte' && $order == 'desc' ){
              $info_users = get_all_transactions( '*', 'id_cagnotte', 'DESC' );
            }elseif( $orderby == 'montant' && $order == 'asc' ){
              $info_users = get_all_transactions('*', 'donation', 'ASC' );
            }elseif( $orderby == 'montant' && $order == 'desc' ){
              $info_users = get_all_transactions( '*', 'donation', 'DESC' );
            }elseif( $orderby == 'mode_paiement' && $order == 'asc' ){
              $info_users = get_all_transactions( '*', 'paiement', 'ASC' );
            }elseif( $orderby == 'mode_paiement' && $order == 'desc' ){
              $info_users = get_all_transactions( '*', 'paiement', 'DESC' );
            }elseif( $orderby == 'date' && $order == 'asc' ){
              $info_users = get_all_transactions( '*', 'date', 'ASC' );
            }elseif( $orderby == 'date' && $order == 'desc' ){
              $info_users = get_all_transactions( '*', 'date', 'DESC' );
            }else{
              $info_users = get_all_transactions();
            }
        }   


        foreach( $info_users as $res ){
            $row = array(
              'cagnotte'       => get_field('nom_de_la_cagnotte', $res->id_cagnotte),
              'donateur'       => $res->lname.' '.$res->fname,
              'montant'        => (int)$res->donation,
              'mode_paiement'  => $res->paiement,
              'benef'          => get_field('benef_cagnotte', $res->id_cagnotte),
              'date'           => $res->date,
            );

          $data_rows[] = $row;

          }
        echo pack("CCC",0xef,0xbb,0xbf);
        header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
        header( 'Content-Description: File Transfer' );
        header( 'Content-type: application/vnd.ms-excel; charset=UTF-8' );
        header( "Content-Disposition: attachment; filename={$filename}" );
        header( 'Expires: 0' );
        header( 'Pragma: public' );
        echo '<table style="width:100%" border="1">';
        echo '<tr>';
        // print header
        foreach($header_row as $h){
            echo '<th>'.$h.'</th>';
        }
        echo '</tr>';
        // print data
        foreach ( $data_rows as $row ) {
            echo '<tr>';
            foreach( $row as $d){
                echo '<td>'.$d.'</td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        ob_end_flush();
        die();
    }
}
// Instantiate a singleton of this plugin
$csvExport = new CSVExport();
 ?>