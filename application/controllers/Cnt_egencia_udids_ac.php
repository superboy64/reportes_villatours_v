<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cnt_egencia_udids_ac extends CI_Controller {

  public function __construct()
  {
        parent::__construct();
        $this->load->model('Mod_egencia_udids_ac');
        $this->load->model('Mod_catalogos_filtros');
  }

  public function get_html_egencia_udids(){

    $title = $this->input->post('title');
    $param['title'] = $title;

    $this->load->view('Egencia_udids_ac/view_egencia_udids_ac',$param);
    
  }

  public function get_html_actualizar_aereolinea_CFDI(){

    $row_aereolinea = $this->input->post('row_aereolinea');

    $param["row_aereolinea"] = $row_aereolinea;

    $this->load->view('Aereolineas_CFDI/view_actualizar_aereolineas_CFDI',$param);

  }

  public function get_catalogo_udids_ac(){

    
    $rest_catalogo_udids_ac = $this->Mod_egencia_udids_ac->get_catalogo_udids_ac();

    echo json_encode($rest_catalogo_udids_ac);

    

  }

  public function get_html_agregar_udids(){

      $param["reportes"] = ''; //$reportes;
      $this->load->view('Egencia_udids_ac/view_agregar_udids',$param);

  }

  public function get_html_actualizar_udids(){

      $param["reportes"] = ''; //$reportes;
      $this->load->view('Egencia_udids_ac/view_actualizar_udids',$param);


  }

  public function eliminar_udids(){

    $id_cliente = $this->input->post('id_cliente');
    
    $rest = $this->Mod_egencia_udids_ac->eliminar_udids($id_cliente);

    echo json_encode($rest);

  }


  public function guardar_analisis_cliente(){

    $arr_cli = $this->input->post('arr_cli');
    $arr_analis = $this->input->post('arr_analis');
    $group_id = $this->input->post('group_id');

   
    $rest = $this->Mod_egencia_udids_ac->guardar_analisis_cliente($arr_cli,$arr_analis,$group_id);
    
    echo json_encode($rest);



  }

  public function guardar_actualizacion_aereolineas_CFDI(){

    
    $slc_cat_aereolinea_edit = $this->input->post('slc_cat_aereolinea_edit');
    $slc_cat_cuenta_edit = $this->input->post('slc_cat_cuenta_edit');
    $hidden_aereolinea_edit = $this->input->post('hidden_aereolinea_edit');
    $txt_CODIGO_NUMERICO_edit = $this->input->post('txt_CODIGO_NUMERICO_edit');
    $txt_CODIGO_TIMBRE_edit = $this->input->post('txt_CODIGO_TIMBRE_edit');
    
    $rest = $this->Mod_egencia_udids_ac->guardar_actualizacion_aereolineas_CFDI($slc_cat_aereolinea_edit,$slc_cat_cuenta_edit,$hidden_aereolinea_edit,$txt_CODIGO_NUMERICO_edit,$txt_CODIGO_TIMBRE_edit);

    echo json_encode($rest);

  }
  

}
