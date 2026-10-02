<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* CodeIgniter
*
* An open source application development framework for PHP 5.1.6 or newer
*
* @package     CodeIgniter
* @author      ExpressionEngine Dev Team
* @copyright   Copyright (c) 2008 - 2011, EllisLab, Inc.
* @license     http://codeigniter.com/user_guide/license.html
* @link        http://codeigniter.com
* @since       Version 1.0
* @filesource
*/

// Obtener frase traducida
if ( ! function_exists('get_phrase'))
{
    function get_phrase($phrase = '') {
        $CI =& get_instance();
        $CI->load->database();
        $language_code = $CI->db->get_where('settings', array('key' => 'language'))->row()->value;
        $key = strtolower(preg_replace('/\s+/', '_', $phrase));
        $langArray = openJSONFile($language_code);
        
        if (!isset($langArray[$key])) {
            // Si no existe, la creamos en la BD
            $valor_predeterminado = ucfirst(str_replace('_', ' ', $key));
            $CI->db->insert('language', array(
                'phrase'  => $key,
                'english' => $valor_predeterminado,
                'spanish' => ''
            ));
            $langArray[$key] = $valor_predeterminado;
        }
        return $langArray[$key];
    }
}

// Obtener frase desde sesión
if ( ! function_exists('site_phrase'))
{
    function site_phrase($phrase = '') {
        $CI =& get_instance();
        if (!$CI->session->userdata('language')) {
            $CI->session->set_userdata('language', get_settings('language'));
        }
        $language_code = $CI->session->userdata('language');
        $key = strtolower(preg_replace('/\s+/', '_', $phrase));
        $langArray = openJSONFile($language_code);
        
        if (!isset($langArray[$key])) {
            $valor_predeterminado = ucfirst(str_replace('_', ' ', $key));
            $CI->db->insert('language', array(
                'phrase'  => $key,
                'english' => $valor_predeterminado,
                'spanish' => ''
            ));
            $langArray[$key] = $valor_predeterminado;
        }
        return $langArray[$key];
    }
}

// LEER DESDE BASE DE DATOS
if ( ! function_exists('openJSONFile'))
{
    function openJSONFile($code)
    {
        $CI =& get_instance();
        $CI->load->database();
        $jsonString = array();
        
        // Leer TODO desde la tabla language
        $query = $CI->db->select('phrase, english, spanish')->get('language');
        $result = $query->result_array();
        
        foreach ($result as $row) {
            if ($code === 'spanish' && !empty($row['spanish'])) {
                $jsonString[$row['phrase']] = $row['spanish'];
            } else {
                $jsonString[$row['phrase']] = $row['english'];
            }
        }
        return $jsonString;
    }
}

// Ya no creamos archivos, todo está en BD
if ( ! function_exists('saveDefaultJSONFile'))
{
    function saveDefaultJSONFile($language_code){
        return true;
    }
}

// GUARDAR EN BASE DE DATOS en lugar de archivo
if ( ! function_exists('saveJSONFile'))
{
    function saveJSONFile($language_code, $updating_key, $updating_value){
        $CI =& get_instance();
        $columna = ($language_code === 'spanish') ? 'spanish' : 'english';
        
        $CI->db->where('phrase', $updating_key);
        $CI->db->update('language', array($columna => $updating_value));
        return true;
    }
}

if ( ! function_exists('escapeJsonString'))
{
    function escapeJsonString($value) {
        $value = str_replace('"', "'", $value);
        $escapers =     array("\\",     "/",   "\"",  "\n",  "\r",  "\t", "\x08", "\x0c");
        $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t",  "\\f",  "\\b");
        $result = str_replace($escapers, $replacements, $value);
        return $result;
    }
}
/* End of file language_helper.php */
/* Location: ./system/helpers/language_helper.php */