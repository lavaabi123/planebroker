<?php

use App\Libraries\Recaptcha;
use App\Models\Locations\CityModel;
use App\Models\Locations\CountyModel;
use App\Models\Locations\StateModel;
use App\Models\UsersModel;
use Config\ForeignCharacters;;
use App\Models\CategoriesSubModel;


$CI4 = new \App\Controllers\BaseController;

if (!function_exists('register_CI4')) {
    function register_CI4(&$_ci)
    {
        global $CI4;
        $CI4 = $_ci;
    }
}

if (!function_exists('get_general_settings')) {
    function get_general_settings()
    {
        $db = \Config\Database::connect();
        return $db->table('general_settings')->get()->getRow();
    }
}

if (!function_exists('get_langguage')) {
    function get_langguage()
    {
        $db = \Config\Database::connect();
        return  $db->table('languages')->getWhere(['status' => 1])->getResult();
    }
}

if (!function_exists('get_langguage_default')) {
    function get_langguage_default()
    {
        $db = \Config\Database::connect();
        return  $db->table('languages')->getWhere(['id' => 1])->getRow();
    }
}

if (!function_exists('get_langguage_id')) {
    function get_langguage_id($id)
    {
        $db = \Config\Database::connect();
        return  $db->table('languages')->getWhere(['id' => $id])->getRow();
    }
}

if (!function_exists('get_site_lang')) {
    function get_site_lang()
    {
        return get_langguage_id(get_general_settings()->site_lang);
    }
}


if (!function_exists('site_lang')) {
    function site_lang()
    {
        if (empty(get_site_lang())) {
            return get_langguage_default();
        } else {
            return get_site_lang();
        }
    }
}

if (!function_exists('selected_lang')) {
    function selected_lang()
    {
        return site_lang();
    }
}

//get get_translation_array 
if (!function_exists('get_translation_array')) {
    function get_translation_array($land_id)
    {
        $db = \Config\Database::connect();

        $translations = $db->table('language_translations')->getWhere(['lang_id' => $land_id])->getResult();

        $array = array();
        if (!empty($translations)) {
            foreach ($translations as $translation) {
                $array[$translation->label] = $translation->translation;
            }
        }
        return $array;
    }
}

if (!function_exists('language_translations')) {
    function language_translations()
    {
        return get_translation_array(selected_lang()->id);
    }
}

if (!function_exists('trans')) {
    function trans($string)
    {
        $translation = language_translations();

        if (!empty($translation[$string])) {
            return $translation[$string];
        }
        return $string;
    }
}

//clean number
if (!function_exists('clean_number')) {
    function clean_number($num)
    {
        $num = trim($num ?? '');
        $num = intval($num);
        return $num;
    }
}

//generate unique id
if (!function_exists('generate_unique_id')) {
    function generate_unique_id()
    {
        $id = uniqid("", TRUE);
        $id = str_replace(".", "-", $id);
        return $id . "-" . rand(10000000, 99999999);
    }
}

//generate slug
if (!function_exists('str_slug')) {
    function str_slug($str)
    {
        $str = trim($str ?? '');
        return url_title(convert_accented_characters($str), "-", true);
    }
}

//clean string
if (!function_exists('clean_str')) {
    function clean_str($str)
    {
        $str = remove_special_characters($str, false);
        return $str;
    }
}

//remove special characters
if (!function_exists('remove_special_characters')) {
    function remove_special_characters($str, $is_slug = false)
    {
        $str = trim($str ?? '');
        $str = str_replace('#', '', $str);
        $str = str_replace(';', '', $str);
        $str = str_replace('!', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('$', '', $str);
        $str = str_replace('%', '', $str);
        $str = str_replace('(', '', $str);
        $str = str_replace(')', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('+', '', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace('\'', '', $str);
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('=', '', $str);
        $str = str_replace('?', '', $str);
        $str = str_replace('[', '', $str);
        $str = str_replace(']', '', $str);
        $str = str_replace('\\', '', $str);
        $str = str_replace('^', '', $str);
        $str = str_replace('`', '', $str);
        $str = str_replace('{', '', $str);
        $str = str_replace('}', '', $str);
        $str = str_replace('|', '', $str);
        $str = str_replace('~', '', $str);
        if ($is_slug == true) {
            $str = str_replace(" ", '-', $str);
            $str = str_replace("'", '', $str);
        }
        return $str;
    }
}


//remove forbidden characters
if (!function_exists('remove_forbidden_characters')) {
    function remove_forbidden_characters($str)
    {
        $str = str_replace(';', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('$', '', $str);
        $str = str_replace('%', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace('\'', '', $str);
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('=', '', $str);
        $str = str_replace('?', '', $str);
        $str = str_replace('[', '', $str);
        $str = str_replace(']', '', $str);
        $str = str_replace('\\', '', $str);
        $str = str_replace('^', '', $str);
        $str = str_replace('`', '', $str);
        $str = str_replace('{', '', $str);
        $str = str_replace('}', '', $str);
        $str = str_replace('|', '', $str);
        $str = str_replace('~', '', $str);
        return $str;
    }
}

//convert xml characters
if (!function_exists('convert_to_xml_character')) {
    function convert_to_xml_character($string)
    {
        $str = str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
        $str = str_replace('#45;', '', $str);
        return $str;
    }
}

if (!function_exists('is_admin')) {
    function is_admin()
    {
        $user_model = new UsersModel();
        return $user_model->is_admin();
    }
}
if (!function_exists('is_superadmin')) {
    function is_superadmin()
    {
        $user_model = new UsersModel();
        return $user_model->is_superadmin();
    }
}

//check admin
if (!function_exists('check_admin')) {
    function check_admin()
    {
        if (!is_admin()) {
            return redirect()->to(admin_url());
        }
    }
}

//admin url
if (!function_exists('admin_url')) {
    function admin_url()
    {

        return base_url() . "/admin/";
    }
}

//lang base url
if (!function_exists('lang_base_url')) {
    function lang_base_url()
    {
        global $CI4;
        return $CI4->lang_base_url;
    }
}

//print date
if (!function_exists('formatted_date')) {
    function formatted_date($timestamp, $format = '')
    {
        if(!empty($format)){
            return date($format, strtotime($timestamp));
        }else{
            return date("Y-m-d / H:i", strtotime($timestamp));
        }        
    }
}

//print date
if (!function_exists('formatted_dateonly')) {
    function formatted_dateonly($timestamp)
    {
        return date("Y-m-d", strtotime($timestamp));
    }
}

//get logged user
if (!function_exists('user')) {
    function user()
    {
        $user_model = new UsersModel();
        $user = $user_model->get_logged_user();
        if (empty($user)) {
            return $user_model->logout();
        } else {
            return $user;
        }
    }
}

//check auth
if (!function_exists('auth_check')) {
    function auth_check()
    {
        $user_model = new UsersModel();

        return $user_model->is_logged_in();
    }
}

//set cookie
if (!function_exists('helper_setcookie')) {
    function helper_setcookie($name, $value)
    {
        return set_cookie([
            'name' => config('cookie')->prefix . '_' . $name,
            'value' => $value,
            'expire' => time() + (86400 * 30),
            'domain' => base_url(),
            'path' => '/'

        ]);
    }
}

//get cookie
if (!function_exists('helper_getcookie')) {
    function helper_getcookie($name, $data_type = 'string')
    {
        if (get_cookie(config('cookie')->prefix . '_' . $name)) {
            return get_cookie(config('cookie')->prefix . '_' . $name);
        }
        if ($data_type == 'int') {
            return 0;
        }
        return "";
    }
}

//delete cookie
if (!function_exists('helper_deletecookie')) {
    function helper_deletecookie($name)
    {
        if (!empty(helper_getcookie($name))) {
            /*set_cookie([
                'name' => config('cookie')->prefix . '_' . $name,
                'value' => "",
                'expire' => time() - 3600,
                'domain' => base_url(),
                'path' => '/'

            ]);*/
        }
    }
}

//set session
if (!function_exists('helper_setsession')) {
    function helper_setsession($name, $value)
    {
        global $CI4;
        $CI4->session->set($name, $value);
    }
}

//get session
if (!function_exists('helper_getsession')) {
    function helper_getsession($name, $data_type = 'string')
    {
        global $CI4;
        if (!empty($CI4->session->get($name))) {
            return $CI4->session->get($name);
        }
        if ($data_type == 'int') {
            return 0;
        }
        return "";
    }
}

//get recaptcha
if (!function_exists('recaptcha_status')) {
    function recaptcha_status()
    {

        if (empty(get_general_settings()->recaptcha_site_key) || empty(get_general_settings()->recaptcha_secret_key)) {
            return false;
        }

        return true;
    }
}

//set cached data
if (!function_exists('set_cache_data')) {
    function set_cache_data($key, $data)
    {

        $key = $key . "_lang" . selected_lang()->id;
        if (get_general_settings()->cache_system == 1) {
            $cache = \Config\Services::cache();

            $cache->save($key, $data, get_general_settings()->cache_refresh_time);
        }
    }
}

//set cached data by lang
if (!function_exists('set_cache_data_by_lang')) {
    function set_cache_data_by_lang($key, $data, $lang_id)
    {

        $key = $key . "_lang" . $lang_id;
        if (get_general_settings()->cache_system == 1) {
            $cache = \Config\Services::cache();
            $cache->save($key, $data, get_general_settings()->cache_refresh_time);
        }
    }
}


//get cached data
if (!function_exists('get_cached_data')) {
    function get_cached_data($key)
    {

        $key = $key . "_lang" . selected_lang()->id;
        if (get_general_settings()->cache_system == 1) {
            $cache = \Config\Services::cache();
            if ($data = $cache->get($key)) {
                return $data;
            }
        }
        return false;
    }
}

//get cached data by lang
if (!function_exists('get_cached_data_by_lang')) {
    function get_cached_data_by_lang($key, $lang_id)
    {

        $key = $key . "_lang" . $lang_id;
        if (get_general_settings()->cache_system == 1) {
            $cache = \Config\Services::cache();
            if ($data = $cache->get($key)) {
                return $data;
            }
        }
        return false;
    }
}

//reset cache data
if (!function_exists('reset_cache_data')) {
    function reset_cache_data()
    {
        $cache = \Config\Services::cache();
        return $cache->clean();
    }
}

//reset cache data on change
if (!function_exists('reset_cache_data_on_change')) {
    function reset_cache_data_on_change()
    {
        if (get_general_settings()->refresh_cache_database_changes == 1) {
            return reset_cache_data();
        }
    }
}

//get location
if (!function_exists('get_location')) {
    function get_location($object)
    {
        $cityModel = new CityModel();
        $stateModel = new StateModel();
        $countyModel = new CountyModel();

        $location = "";
        if (!empty($object)) {
            if (!empty($object->address)) {
                $location = $object->address;
            }

            if (!empty($object->city_id)) {
                $city = $cityModel->asObject()->find($object->city_id);

                if (!empty($city)) {
                    if (!empty($object->address) || !empty($object->zip_code)) {
                        $location .= ", ";
                    }
                    $location .= $city->name;
                }
            }
            if (!empty($object->state_id)) {
                $state = $stateModel->asObject()->find($object->state_id);

                if (!empty($state)) {
                    if (!empty($object->address) || !empty($object->zip_code) || !empty($object->city_id)) {
                        $location .= ", ";
                    }
                    $location .= $state->name;
                }
            }
            if (!empty($object->county_id)) {
                $county = $countyModel->asObject()->find($object->county_id);
                if (!empty($county)) {
                    if (!empty($object->state_id) || $object->city_id || !empty($object->address) || !empty($object->zip_code)) {
                        $location .= ", ";
                    }
                    $location .= $county->name;
                }
            }

            if (!empty($object->zip_code)) {
                $location .= ", " . $object->zip_code;
            }
        }
        return $location;
    }
}

//get recaptcha
if (!function_exists('generate_recaptcha')) {
    function generate_recaptcha()
    {
        $recaptchaLib = new Recaptcha();

        if (recaptcha_status()) {
            echo '<div class="form-group">';
            echo $recaptchaLib->getWidget();
            echo $recaptchaLib->getScriptTag();
            echo ' </div>';
        }
    }
}

if (!function_exists('convert_accented_characters')) {
    /**
     * Convert Accented Foreign Characters to ASCII
     *
     * @param string $str Input string
     */
    function convert_accented_characters(string $str): string
    {
        static $arrayFrom, $arrayTo;

        if (!is_array($arrayFrom)) {
            $config = new ForeignCharacters();

            if (empty($config->characterList) || !is_array($config->characterList)) {
                $arrayFrom = [];
                $arrayTo   = [];

                return $str;
            }
            $arrayFrom = array_keys($config->characterList);
            $arrayTo   = array_values($config->characterList);

            unset($config);
        }

        return preg_replace($arrayFrom, $arrayTo, $str);
    }
}

if (!function_exists('html_escape')) {
    /**
     * Returns HTML escaped variable.
     *
     * @param	mixed	$var		The input string or array of strings to be escaped.
     * @param	bool	$double_encode	$double_encode set to FALSE prevents escaping twice.
     * @return	mixed			The escaped string or array of strings as a result.
     */
    function html_escape($var, $double_encode = TRUE)
    {
        if (empty($var)) {
            return $var;
        }

        if (is_array($var)) {
            foreach (array_keys($var) as $key) {
                $var[$key] = html_escape($var[$key], $double_encode);
            }

            return $var;
        }

        return htmlspecialchars($var, ENT_QUOTES, 'UTF-8', $double_encode);
    }
}


//get logo
if (!function_exists('get_logo')) {
    function get_logo($visual_settings)
    {
        if (!empty($visual_settings)) {
            if (!empty($visual_settings->logo_light) && file_exists(FCPATH . "/" . $visual_settings->logo_light)) {
                return base_url() . '/' . $visual_settings->logo_light;
            } else {
                return base_url() . "/assets/admin/img/logo.png";
            }
        } else {
            return base_url() . "/assets/admin/img/logo.png";
        }
    }
}

//get favicon
if (!function_exists('get_logo_sm')) {
    function get_logo_sm($visual_settings)
    {
        if (!empty($visual_settings)) {
            if (!empty($visual_settings->favicon) && file_exists(FCPATH . $visual_settings->favicon)) {
                return base_url() . $visual_settings->favicon;
            } else {
                return base_url() . "/assets/admin/img/logo_sm.png";
            }
        } else {
            return base_url() . "/assets/admin/img/logo_sm.png";
        }
    }
}

//get logo footer
if (!function_exists('get_logo_dark')) {
    function get_logo_dark($visual_settings)
    {
        if (!empty($visual_settings)) {
            if (!empty($visual_settings->logo_dark) && file_exists(FCPATH . "/" . $visual_settings->logo_dark)) {
                return base_url() . '/' . $visual_settings->logo_dark;
            } else {
                return base_url() . "/assets/admin/img/logo-dark.png";
            }
        } else {
            return base_url() . "/assets/admin/img/logo-dark.png";
        }
    }
}

//get favicon
if (!function_exists('get_logo_sm_dark')) {
    function get_logo_sm_dark($visual_settings)
    {
        if (!empty($visual_settings)) {
            if (!empty($visual_settings->favicon) && file_exists(FCPATH . $visual_settings->favicon)) {
                return base_url() . $visual_settings->favicon;
            } else {
                return base_url() . "/assets/admin/img/logo_sm_dark.png";
            }
        } else {
            return base_url() . "/assets/admin/img/logo_sm_dark.png";
        }
    }
}

//get logo email
if (!function_exists('get_logo_email')) {
    function get_logo_email($visual_settings)
    {
        if (!empty($visual_settings)) {
            if (!empty($visual_settings->logo_email) && file_exists(FCPATH . "/" . $visual_settings->logo_email)) {
                return base_url() . '/' . $visual_settings->logo_email;
            } else {
                return base_url() . "/assets/admin/img/logo.png";
            }
        } else {
            return base_url() . "/assets/admin/img/logo.png";
        }
    }
}

//get favicon
if (!function_exists('get_favicon')) {
    function get_favicon($visual_settings)
    {
        if (!empty($visual_settings)) {
            if (!empty($visual_settings->favicon) && file_exists(FCPATH . $visual_settings->favicon)) {
                return base_url() . $visual_settings->favicon;
            } else {
                return base_url() . "/assets/admin/img/favicon.png";
            }
        } else {
            return base_url() . "/assets/admin/img/favicon.png";
        }
    }
}

//date diff
if (!function_exists('date_difference')) {
    function date_difference($date1, $date2, $format = '%a')
    {
        $datetime_1 = date_create($date1);
        $datetime_2 = date_create($date2);
        $diff = date_diff($datetime_1, $datetime_2);
        return $diff->format($format);
    }
}

//date difference in hours
if (!function_exists('date_difference_in_hours')) {
    function date_difference_in_hours($date1, $date2)
    {
        $datetime_1 = date_create($date1);
        $datetime_2 = date_create($date2);
        $diff = date_diff($datetime_1, $datetime_2);
        $days = $diff->format('%a');
        $hours = $diff->format('%h');
        return $hours + ($days * 24);
    }
}

//date difference in hours
if (!function_exists('date_difference_in_minutes')) {
    function date_difference_in_minutes($date1, $date2)
    {
        $datetime_1 = new DateTime($date1);
        $datetime_2 = new DateTime($date2);
        $diff =  ($datetime_1->getTimestamp() - $datetime_2->getTimestamp()) / 60;

        return $diff;
    }
}
//check cron time
if (!function_exists('check_cron_time')) {
    function check_cron_time($hour)
    {

        if (empty(get_general_settings()->last_cron_update) || date_difference_in_hours(date('Y-m-d H:i:s'), get_general_settings()->last_cron_update) >= $hour) {
            return true;
        }
        return false;
    }
}

//check cron time
if (!function_exists('check_cron_time_minutes')) {
    function check_cron_time_minutes($minutes)
    {

        if (empty(get_general_settings()->last_cron_update) || date_difference_in_minutes(date('Y-m-d H:i:s'), get_general_settings()->last_cron_update) >= $minutes) {
            return true;
        }
        return false;
    }
}

//check if dark mode enabled
if (!function_exists('check_dark_mode_enabled')) {
    function check_dark_mode_enabled()
    {

        $dark_mode = get_general_settings()->dark_mode;
        $ck_name = config('cookie')->prefix . '_vr_dark_mode';
        if (isset($_COOKIE[$ck_name])) {
            if ($_COOKIE[$ck_name] == 1 || $_COOKIE[$ck_name] == 0) {
                $dark_mode = $_COOKIE[$ck_name];
            }
        }
        return $dark_mode;
    }
}

//get user avatar
if (!function_exists('get_user_avatar')) {
    function get_user_avatar($avatar_path)
    {
        if (!empty($avatar_path)) {
            if (file_exists(FCPATH . $avatar_path)) {
                return base_url() . $avatar_path;
            } else {
                return $avatar_path;
            }
        } else {
            return base_url() . "/assets/admin/img/user.png";
        }
    }
}

//delete image from server
if (!function_exists('delete_image_from_server')) {
    function delete_image_from_server($path)
    {
        $full_path = FCPATH . $path;
        if (strlen($path) > 15 && file_exists($full_path)) {
            unlink($full_path);
        }
    }
}

//delete file from server
if (!function_exists('delete_file_from_server')) {
    function delete_file_from_server($path)
    {
        $full_path = FCPATH . $path;
        if (strlen($path) > 15 && file_exists($full_path)) {
            unlink($full_path);
        }
    }
}
if (!function_exists('phoneFormat')) {
    function phoneFormat($p){
        if(!empty($p)){
            return substr($p, 0, 3).'-'.substr($p, 3, 3).'-'.substr($p, 6, 4);
        }else{
            return '';
        }
    }
}


function changeQuery($key='', $val='', $add=false, $uri=false, $ignore=false){
	$qs = ''; $replaced = false;
	$arr = $_GET;
	if(!empty($ignore)){
		foreach($ignore as $k){
			unset($arr[$k]);
		}
	}
	
	foreach($arr as $k=>$v){
		if(!is_array($key)){
			if($k == $key){
				if(!empty($val) && !empty($key)){
					$qs .= $key.'='.$val.'&';
					$replaced = true;
				}
			}else{
				$qs .= $k.'='.$v.'&';
			}
		}else{
			$index = array_search($k, $key);
			if(false !== $index) {
				if(!empty($val[$index]) && !empty($key[$index])){ 
					$qs .= $key[$index].'='.$val[$index].'&';
					$replaced[$index] = true;
				}
			}else{
				$qs .= $k.'='.$v.'&';
			}
		}
	}
	if(!is_array($key)){
		if(!$replaced && !empty($val) && !empty($key)){
			$qs .= $key.'='.$val.'&';
		}
	}else{
		$total = count($key);
		for($i=0; $i<$total;$i++){
			if(empty($replaced[$i]) && !empty($val[$i]) && !empty($key[$i])){
				$qs .= $key[$i].'='.$val[$i].'&';
			}
		}
	}

	$qs = rtrim($qs, '&');
	if(!empty($qs)){
		$qs = '?'.$qs;
	}
		
	if(!$uri){
		$uri = strtok($_SERVER["REQUEST_URI"],'?');
	}
	if(empty($key)){
		$uri = str_replace('/'.$val, '', $uri);
		if($add){
			$uri .= '/'.$val;
		}
	}
	return $uri.$qs;
}

if (!function_exists('moneyFormat')) {
    function moneyFormat($value){
        return str_replace('.00', '', number_format($value, 2, '.', ','));
    }
}

function getPlanId($user_id)
{
    $db       = \Config\Database::connect();
    $user_detail  = $db->table('users')->select('plan_id')
        ->where(['users.id' => $user_id])
        ->get()->getRow();
    return $user_detail->plan_id;
}

function getFirstName($user_id)
{
    $db       = \Config\Database::connect();
    $user_detail  = $db->table('users')->select('first_name')
        ->where(['users.id' => $user_id])
        ->get()->getRow();
    return $user_detail->first_name;
}

function getUserLevel($user_id)
{
    $db       = \Config\Database::connect();
    $user_detail  = $db->table('users')->select('user_level')
        ->where(['users.id' => $user_id])
        ->get()->getRow();
    return $user_detail->user_level;
}

function cleanURL($textURL) {
	$URL = strtolower(preg_replace( array('/[^a-z0-9\- ]/i', '/[ \-]+/'), array('', '-'), $textURL));
		return $URL;
}


if (!function_exists('get_seo')) {
    function get_seo($page)
    {
        $db = \Config\Database::connect();
        return  $db->table('web_seo')->getWhere(['page_name' => $page,'deleted_at'=>NULL])->getRow();
    }
}

if (!function_exists('get_listing_seo')) {
    function get_listing_seo($permalink)
    {
        $db = \Config\Database::connect();
        return  $db->table('categories')->getWhere(['permalink' => $permalink])->getRow();
    }
}

function getSubcategoryName($id)
{
    $db       = \Config\Database::connect();
    $user_detail = $db->table('categories_sub')->select("GROUP_CONCAT(CONCAT(id, '-', name) SEPARATOR ', ') AS category_names")
        ->whereIn('id', $id)
        ->get()->getRow();
    return $user_detail->category_names;
}

function getCategoryName($id)
{
    $db       = \Config\Database::connect();
    $user_detail = $db->table('categories')->select("in_house")
        ->where('id', $id)
        ->get()->getRow();
    return !empty($user_detail->in_house) ? str_replace('Listings','Listing',$user_detail->in_house) : '';
}

function getCategory_Name($id)
{
    $db       = \Config\Database::connect();
    $user_detail = $db->table('categories')->select("name")
        ->where('id', $id)
        ->get()->getRow();
    return !empty($user_detail->name) ? $user_detail->name : '';
}
function getAllCategories()
{
    $db       = \Config\Database::connect();
    $categories = $db->table('categories')->select("name,permalink")
        ->where('status', 1)->orderBy('id','ASC')
        ->get()->getResult();
    return $categories;
}

function get_all_blog($cat='')
{
	$db       = \Config\Database::connect();
	if($cat==''){
		$sql = "SELECT * FROM blogs WHERE status = 1 AND deleted_at IS NULL";
	}else{
		$sql = "SELECT * FROM blogs WHERE category=".$cat." AND status = 1 AND deleted_at IS NULL";
	}
	
	$query = $db->query($sql);
	return $query->getResultArray();
}

function check_listing($user_id)
{
    $db       = \Config\Database::connect();
    $products  = $db->table('products')->select('id')
        ->where(['user_id' => $user_id,'draft_status' => 0])
        ->get()->getResult();
    return count($products);
}

function check_aircraft_status($product_id)
{
    $db       = \Config\Database::connect();
    $products  = $db->query('select * from products_dynamic_fields where product_id = '.$product_id.' and field_id = (SELECT id FROM `fields` where name = "Aircraft Status")')->getRow();
    return !empty($products->field_value) ? $products->field_value : 'Available';
}

if (!function_exists('addWatermarkFromUrls')) {
/**
 * Add a bottom-right watermark that scales for any image size.
 *
 * @param string   $mainImageUrl  URL or local path of the base image (any format; AVIF supported via fallbacks)
 * @param string   $watermarkUrl  URL or local path of the watermark (prefer PNG with alpha)
 * @param string   $savePath      Local path to save result (.jpg or .png). Do NOT use .avif unless your server supports it.
 * @param float    $opacity       0.0–1.0 base opacity multiplier; actual used is adaptive (background-aware)
 * @param float    $sizeRatio     Target watermark width as fraction of the image's shorter side
 * @param int      $minWmPx       Lower clamp for watermark width in px
 * @param int      $maxWmPx       Upper clamp for watermark width in px
 * @param int|null $paddingPx     If null, auto: 2% of shorter side (clamped 8–60px). Otherwise fixed px.
 * @throws Exception
 */
function addWatermarkFromUrls(
    string $mainImageUrl,
    string $watermarkUrl,
    string $savePath,
    float  $opacity   = 0.5,
    float  $sizeRatio = 0.22,
    int    $minWmPx   = 120,
    int    $maxWmPx   = 600,
    ?int   $paddingPx = null
) {
    // --- Load binaries (with generous timeouts)
    $ctx = stream_context_create([
        'http' => ['timeout' => 20, 'follow_location' => 1],
        'https'=> ['timeout' => 20, 'follow_location' => 1],
    ]);

    $mainData = @file_get_contents($mainImageUrl, false, $ctx);
    if ($mainData === false) throw new Exception("Failed to read main image: $mainImageUrl");

    $wmData = @file_get_contents($watermarkUrl, false, $ctx);
    if ($wmData === false) throw new Exception("Failed to read watermark: $watermarkUrl");

    // --- Create GD images (AVIF-aware)
    [$mainImg, $mainMime] = loadGdFromDataOrAvif($mainData, 'main image');
    [$wmImg,   $wmMime]   = loadGdFromDataOrAvif($wmData, 'watermark', /*allowAvif*/false); // watermark should be PNG; allowAvif=false still tries normal GD first

    // Ensure alpha on watermark
    imagealphablending($wmImg, false);
    imagesavealpha($wmImg, true);

    // --- Dimensions ---
    $W  = imagesx($mainImg);
    $H  = imagesy($mainImg);
    $wW = imagesx($wmImg);
    $wH = imagesy($wmImg);

    // Auto padding if not provided: 2% of shorter side, clamped 8–60 px
    $short = min($W, $H);
    if ($paddingPx === null) {
        $paddingPx = max(8, min(60, (int)round($short * 0.02)));
    }

    // Target width: percentage of shorter side, clamped, and never overflow canvas
    $targetW = (int) round($short * $sizeRatio);
    $targetW = max($minWmPx, min($maxWmPx, $targetW));
    $targetW = min($targetW, max(1, $W - 2*$paddingPx)); // don't overflow canvas

    // Preserve aspect ratio; never upscale watermark
    $scale   = min($targetW / $wW, 1.0);
    $newW    = (int) max(1, round($wW * $scale));
    $newH    = (int) max(1, round($wH * $scale));

    // Resize watermark if needed
    if ($newW !== $wW || $newH !== $wH) {
        $resized = imagecreatetruecolor($newW, $newH);
        imagesavealpha($resized, true);
        $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
        imagefill($resized, 0, 0, $transparent);
        imagealphablending($resized, false);

        imagecopyresampled($resized, $wmImg, 0, 0, 0, 0, $newW, $newH, $wW, $wH);
        imagedestroy($wmImg);
        $wmImg = $resized;
        $wW = $newW; $wH = $newH;
    }

    // --- Position: bottom-right with padding ---
    $dstX = max(0, $W - $wW - $paddingPx);
    $dstY = max(0, $H - $wH - $paddingPx);

    // --- Adaptive opacity based on background luminance under the watermark ---
    imagealphablending($mainImg, true);
    $adaptiveOpacity = autoAdjustOpacity($mainImg, $wW, $wH, $dstX, $dstY, max(0.0, min(1.0, $opacity*0.5)), max(0.0, min(1.0, $opacity*1.7)));

    // --- Merge (preserves per-pixel alpha in watermark) ---
    imagecopymerge_alpha($mainImg, $wmImg, $dstX, $dstY, 0, 0, $wW, $wH, $adaptiveOpacity);

    // --- Save (JPG/PNG only unless your stack supports AVIF encode) ---
    $ext = strtolower(pathinfo($savePath, PATHINFO_EXTENSION));
    switch ($ext) {
        case 'jpg':
        case 'jpeg':
            imageinterlace($mainImg, true);
            imagejpeg($mainImg, $savePath, 90);
            break;
        case 'png':
            imagesavealpha($mainImg, true);
            imagepng($mainImg, $savePath, 6);
            break;
        default:
            imagedestroy($mainImg);
            imagedestroy($wmImg);
            throw new Exception("Unsupported output image format: .$ext (use .jpg or .png)");
    }

    imagedestroy($mainImg);
    imagedestroy($wmImg);
    return true;
} // addWatermarkFromUrls
}

/** ---------------- Low-level helpers (AVIF-aware loader, alpha-merge, opacity) ---------------- */

if (!function_exists('loadGdFromDataOrAvif')) {
function loadGdFromDataOrAvif(string $data, string $label = 'image', bool $allowAvif = true): array
{
    $mime = 'application/octet-stream';
    if (function_exists('finfo_open')) {
        $fi = finfo_open(FILEINFO_MIME_TYPE);
        if ($fi) { $mime = finfo_buffer($fi, $data) ?: $mime; finfo_close($fi); }
    }

    // 1) Try GD directly
    $img = @imagecreatefromstring($data);
    if ($img !== false) {
        return [$img, $mime];
    }

    // 2) If it's AVIF/HEIC/HEIF, try all fallbacks
    $isHeifFamily = (stripos($mime, 'image/avif') !== false) ||
                    (stripos($mime, 'image/heic') !== false) ||
                    (stripos($mime, 'image/heif') !== false) ||
                    // some servers mislabel; quick sniff by extension in first bytes
                    (strncmp($data, '....ftyp', 8) === 0); // harmless heuristic; optional

    if ($allowAvif && $isHeifFamily) {
        // 2a) Native GD AVIF support
        if (function_exists('imagecreatefromavif')) {
            $tmpAvif = tempnam(sys_get_temp_dir(), 'avif_') . '.avif';
            @file_put_contents($tmpAvif, $data);
            $img = @imagecreatefromavif($tmpAvif);
            @unlink($tmpAvif);
            if ($img !== false) return [$img, 'image/avif'];
        }

        // 2b) Imagick (with libheif)
        if (class_exists('Imagick')) {
            try {
                $im = new Imagick();
                $im->readImageBlob($data); // will throw if no delegate
                if ($im->getNumberImages() > 1) {
                    $im = $im->coalesceImages();
                    $im->setIteratorIndex(0);
                }
                $im->setImageAlphaChannel(Imagick::ALPHACHANNEL_ACTIVATE);
                $im->setImageColorspace(Imagick::COLORSPACE_SRGB);
                $im->setImageFormat('png32');
                $png = $im->getImagesBlob();
                $im->clear(); $im->destroy();

                $img = @imagecreatefromstring($png);
                if ($img !== false) return [$img, 'image/png'];
            } catch (\Throwable $e) {
                // fall through to CLI tools
            }
        }

        // 2c) CLI tools fallback: only if exec() is available
		if (function_exists('exec')) {
			$tmpAvif = tempnam(sys_get_temp_dir(), 'avif_') . '.avif';
			$tmpPng  = tempnam(sys_get_temp_dir(), 'avif_') . '.png';
			@file_put_contents($tmpAvif, $data);

			$cmd = null;
			if (command_exists('magick')) {
				$cmd = "magick ".escapeshellarg($tmpAvif)." -alpha on -colorspace sRGB PNG32:".escapeshellarg($tmpPng);
			} elseif (command_exists('convert')) {
				$cmd = "convert ".escapeshellarg($tmpAvif)." -alpha on -colorspace sRGB PNG32:".escapeshellarg($tmpPng);
			} elseif (command_exists('ffmpeg')) {
				$cmd = "ffmpeg -y -i ".escapeshellarg($tmpAvif)." -frames:v 1 ".escapeshellarg($tmpPng);
			} elseif (command_exists('heif-convert')) {
				$cmd = "heif-convert ".escapeshellarg($tmpAvif)." ".escapeshellarg($tmpPng)." >/dev/null 2>&1";
			}

			if ($cmd) {
				$out = []; $ret = 1;
				safe_exec($cmd, $out, $ret);
				if ($ret === 0 && is_file($tmpPng)) {
					$img = @imagecreatefrompng($tmpPng);
					@unlink($tmpAvif); @unlink($tmpPng);
					if ($img !== false) return [$img, 'image/png'];
				}
			}
			@unlink($tmpAvif ?? ''); @unlink($tmpPng ?? '');
		}
		// If exec() isn’t available, we just skip CLI fallback and continue to throw later.

    }

    // If we got here, we couldn’t decode it
    throw new Exception("$label: unsupported format or no AVIF decoder available (MIME: $mime)");
}
}

if (!function_exists('command_exists')) {
function command_exists(string $name): bool
{
    // If exec is disabled, we simply report "not found"
    if (!function_exists('exec')) return false;

    $probe = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? 'where' : 'command -v';
    @exec("$probe " . escapeshellarg($name), $out, $code);
    return $code === 0 && !empty($out);
}
}
if (!function_exists('safe_exec')) {
function safe_exec(string $cmd, ?array &$out = null, ?int &$code = null): bool
{
    if (!function_exists('exec')) { $out = []; $code = 127; return false; }
    @exec($cmd, $out, $code);
    return $code === 0;
}
}


if (!function_exists('imagecopymerge_alpha')) {
function imagecopymerge_alpha($dstImg, $srcImg, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $baseOpacity)
{
    $baseOpacity = max(0.0, min(1.0, $baseOpacity));

    $dstW = imagesx($dstImg);
    $dstH = imagesy($dstImg);

    for ($x = 0; $x < $src_w; $x++) {
        for ($y = 0; $y < $src_h; $y++) {
            $dx = $dst_x + $x;
            $dy = $dst_y + $y;
            if ($dx < 0 || $dy < 0 || $dx >= $dstW || $dy >= $dstH) continue;

            $rgba = imagecolorat($srcImg, $src_x + $x, $src_y + $y);
            $c = imagecolorsforindex($srcImg, $rgba);
            if ($c['alpha'] === 127) continue; // fully transparent pixel

            // Sample destination background pixel
            $bgRgba = imagecolorat($dstImg, $dx, $dy);
            $bg = imagecolorsforindex($dstImg, $bgRgba);
            $bgBrightness = ($bg['red'] + $bg['green'] + $bg['blue']) / 3;

            // Contrast-aware boost
            $contrastBoost = ($bgBrightness > 200) ? 1.0
                            : (($bgBrightness > 150) ? 0.6 : 0.2);

            $effectiveOpacity = min(1.0, $baseOpacity * (1 + $contrastBoost));

            // Combine watermark alpha + overall opacity
            $finalAlpha = $c['alpha'] + (127 - $c['alpha']) * (1 - $effectiveOpacity);
            $finalAlpha = (int) max(0, min(127, round($finalAlpha)));

            $col = imagecolorallocatealpha($dstImg, $c['red'], $c['green'], $c['blue'], $finalAlpha);
            imagesetpixel($dstImg, $dx, $dy, $col);
        }
    }
}
}

if (!function_exists('autoAdjustOpacity')) {
function autoAdjustOpacity($dstImg, $wmWidth, $wmHeight, $dstX, $dstY, float $minOpacity = 0.25, float $maxOpacity = 0.85): float
{
    $dstW = imagesx($dstImg);
    $dstH = imagesy($dstImg);

    $stepX = max(1, (int)($wmWidth  / 20));
    $stepY = max(1, (int)($wmHeight / 20));

    $sampleCount = 0;
    $totalLum = 0;

    // Sample a grid of pixels under the watermark area safely within bounds
    for ($x = 0; $x < $wmWidth; $x += $stepX) {
        for ($y = 0; $y < $wmHeight; $y += $stepY) {
            $px = $dstX + $x;
            $py = $dstY + $y;
            if ($px < 0 || $py < 0 || $px >= $dstW || $py >= $dstH) continue;

            $rgba = imagecolorat($dstImg, $px, $py);
            $c = imagecolorsforindex($dstImg, $rgba);
            // perceived luminance
            $lum = 0.2126*$c['red'] + 0.7152*$c['green'] + 0.0722*$c['blue'];
            $totalLum += $lum;
            $sampleCount++;
        }
    }

    $avgLum = $sampleCount > 0 ? $totalLum / $sampleCount : 128;
    $t = max(0.0, min(1.0, $avgLum / 255));

    return $minOpacity*(1-$t) + $maxOpacity*$t; // bright bg → higher opacity
}
}

function getFileIconClass($filename) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    switch ($ext) {
        case 'pdf':
            return 'fa-file-pdf text-danger';
        case 'doc':
        case 'docx':
            return 'fa-file-word text-primary';
        case 'xls':
        case 'xlsx':
            return 'fa-file-excel text-success';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'fa-file-image text-info';
        case 'zip':
        case 'rar':
            return 'fa-file-archive text-secondary';
        case 'txt':
            return 'fa-file-alt text-muted';
        default:
            return 'fa-file text-dark';
    }
}

function get_ad($page_name, $page_position){
	$db = \Config\Database::connect();
	$result = $db->query("SELECT * FROM ads WHERE page_name='".$page_name."' AND page_position='".$page_position."' AND start_date <= NOW() AND end_date >= NOW() AND status = 1 AND deleted_at IS NULL")->getResultArray();
	$new_array = array();
	if(!empty($result)){
		foreach($result as $row){
			if(!empty($row['image']) && !empty($row['ad_link'])){
				$new_array[] = $row;
			}
		}
	}
	return $new_array;
}


if (! function_exists('wm_user_dir')) {
    function wm_user_dir(int $userId): string {
        return rtrim(FCPATH . 'uploads/userimages/' . $userId . '/', '/\\') . '/';
    }
}
if (! function_exists('wm_original_path')) {
    function wm_original_path(int $userId, string $fileName): string {
        return wm_user_dir($userId) . 'originals/' . $fileName;
    }
}
if (! function_exists('wm_target_path')) {
    function wm_target_path(int $userId, string $fileName): string {
        return wm_user_dir($userId) . $fileName;
    }
}
/**
 * Delete current watermarked copy, then re-generate from originals/.
 */
// app/Helpers/watermark_batch_helper.php

if (! function_exists('wm_rebuild_one')) {
function wm_rebuild_one(int $userId, string $fileName, string $watermarkPath, array $opts = []): bool
{
    try {
        $orig = wm_original_path($userId, $fileName);
        $dest = wm_target_path($userId, $fileName);

        // Skip if original missing
        if (!is_file($orig)) {
            log_message('warning', "[WM] Skip: missing original u{$userId}/{$fileName}");
            return false;
        }

        // Ensure dest dir exists
        if (!is_dir(dirname($dest)) && !@mkdir(dirname($dest), 0775, true)) {
            log_message('error', "[WM] Cannot create dir: ".dirname($dest));
            return false;
        }

        // Delete existing watermarked file (ignore errors)
        if (is_file($dest)) @unlink($dest);

        // Defaults
        $opacity   = $opts['opacity']   ?? 0.5;
        $sizeRatio = $opts['sizeRatio'] ?? 0.22;
        $minWmPx   = $opts['minWmPx']   ?? 120;
        $maxWmPx   = $opts['maxWmPx']   ?? 600;
        $paddingPx = $opts['paddingPx'] ?? null;

        // Apply — wrap to prevent throw from bubbling
        try {
            return addWatermarkFromUrls($orig, $watermarkPath, $dest, $opacity, $sizeRatio, $minWmPx, $maxWmPx, $paddingPx);
        } catch (\Throwable $e) {
            log_message('error', "[WM] Apply failed {$userId}/{$fileName}: ".$e->getMessage());
            return false;
        }
    } catch (\Throwable $e) {
        // absolutely never break the batch
        log_message('error', "[WM] Unexpected failure {$userId}/{$fileName}: ".$e->getMessage());
        return false;
    }
}}


