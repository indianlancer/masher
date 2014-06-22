<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('nohtmldata'))
{
	function nohtmldata($text)
	{
            $text=cleaninputdata($text);
            $text=  htmlspecialchars($text);
            return $text;
	}
}
if ( ! function_exists('htmldata'))
{
	function htmldata($text)
	{
            $text=uncleaninputdata($text);
            $text=  htmlspecialchars_decode($text);
            return $text;
	}
}
if ( ! function_exists('cleaninputdata'))
{        
        function cleaninputdata($text)
        {
            
            return stripslashes($text);
        }
}
if ( ! function_exists('uncleaninputdata'))
{        
        function uncleaninputdata($text)
        {
            
            return addslashes($text);
        }
}

if ( ! function_exists('spacetounderscore'))
{        
        function spacetounderscore($text)
        {
            return str_replace(" ","_", $text); 
        }
}

if ( ! function_exists('cleanIdData'))
{        
        function cleanIdData($v)
        {
            $retour = str_replace(" ", "_",$v);
            $retour = str_replace(",","_",$retour);
            $retour = str_replace("-","_",$retour);
            $retour = str_replace(" ","_",$retour);
            $retour = str_replace(".","_",$retour);
            $retour = str_replace("*","_",$retour);	
            $retour = str_replace("#","_",$retour);
            $retour = str_replace("@","_",$retour);
            $retour = str_replace("&amp;","_",$retour);
            $retour = str_replace("|","_",$retour);
            $retour = str_replace("&","_",$retour);
            $retour = str_replace("(","_",$retour);
            $retour = str_replace(";","_",$retour);
            $retour = str_replace(")","_",$retour);
            $retour = str_replace(",","_",$retour);
            $retour = str_replace("/","_",$retour);
            $retour = str_replace("+","_",$retour);
            $retour = str_replace("=","_",$retour);
            $retour = str_replace("]","_",$retour);
            $retour = str_replace("[","_",$retour);
            $retour = str_replace("°","_",$retour);
            $retour = str_replace("?","_",$retour);
            $retour = str_replace("!","_",$retour);
            $retour = str_replace("%","_",$retour);
            $retour = str_replace("µ","_",$retour);
            $retour = str_replace("§","_",$retour);
            $retour = str_replace("$","_",$retour);
            $retour = str_replace("£","_",$retour);
            $retour = str_replace("¤","_",$retour);
            $retour = str_replace("\xE2\x82\xAc","_",$retour);
            return $retour;
        }
}

if ( ! function_exists('convert_special_simple'))
{ 
    function convert_special_simple($txt) {
        $transliterationTable = array(
                                        'á' => 'a', 'Á' => 'A', 'à' => 'a', 'À' => 'A', 'ă' => 'a', 'Ă' => 'A', 'â' => 'a',
                                        'Â' => 'A', 'å' => 'a', 'Å' => 'A', 'ã' => 'a', 'Ã' => 'A', 'ą' => 'a', 'Ą' => 'A', 
                                        'ā' => 'a', 'Ā' => 'A', 'ä' => 'ae', 'Ä' => 'AE', 'æ' => 'ae', 'Æ' => 'AE', 'ḃ' => 'b',
                                        'Ḃ' => 'B', 'ć' => 'c', 'Ć' => 'C', 'ĉ' => 'c', 'Ĉ' => 'C', 'č' => 'c', 'Č' => 'C', 'ċ' => 'c',
                                        'Ċ' => 'C', 'ç' => 'c', 'Ç' => 'C', 'ď' => 'd', 'Ď' => 'D', 'ḋ' => 'd', 'Ḋ' => 'D', 'đ' => 'd',
                                        'Đ' => 'D', 'ð' => 'dh', 'Ð' => 'Dh', 'é' => 'e', 'É' => 'E', 'è' => 'e', 'È' => 'E', 'ĕ' => 'e', 
                                        'Ĕ' => 'E', 'ê' => 'e', 'Ê' => 'E', 'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'ė' => 'e', 
                                        'Ė' => 'E', 'ę' => 'e', 'Ę' => 'E', 'ē' => 'e', 'Ē' => 'E', 'ḟ' => 'f', 'Ḟ' => 'F', 'ƒ' => 'f', 
                                        'Ƒ' => 'F', 'ğ' => 'g', 'Ğ' => 'G', 'ĝ' => 'g', 'Ĝ' => 'G', 'ġ' => 'g', 'Ġ' => 'G', 'ģ' => 'g', 
                                        'Ģ' => 'G', 'ĥ' => 'h', 'Ĥ' => 'H', 'ħ' => 'h', 'Ħ' => 'H', 'í' => 'i', 'Í' => 'I', 'ì' => 'i', 
                                        'Ì' => 'I', 'î' => 'i', 'Î' => 'I', 'ï' => 'i', 'Ï' => 'I', 'ĩ' => 'i', 'Ĩ' => 'I', 'į' => 'i', 
                                        'Į' => 'I', 'ī' => 'i', 'Ī' => 'I', 'ĵ' => 'j', 'Ĵ' => 'J', 'ķ' => 'k', 'Ķ' => 'K', 'ĺ' => 'l', 
                                        'Ĺ' => 'L', 'ľ' => 'l', 'Ľ' => 'L', 'ļ' => 'l', 'Ļ' => 'L', 'ł' => 'l', 'Ł' => 'L', 'ṁ' => 'm', 
                                        'Ṁ' => 'M', 'ń' => 'n', 'Ń' => 'N', 'ň' => 'n', 'Ň' => 'N', 'ñ' => 'n', 'Ñ' => 'N', 'ņ' => 'n', 
                                        'Ņ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ò' => 'o', 'Ò' => 'O', 'ô' => 'o', 'Ô' => 'O', 'ő' => 'o',
                                        'Ő' => 'O', 'õ' => 'o', 'Õ' => 'O', 'ø' => 'oe', 'Ø' => 'OE', 'ō' => 'o', 'Ō' => 'O', 'ơ' => 'o',
                                        'Ơ' => 'O', 'ö' => 'oe', 'Ö' => 'OE', 'ṗ' => 'p', 'Ṗ' => 'P', 'ŕ' => 'r', 'Ŕ' => 'R', 'ř' => 'r',
                                        'Ř' => 'R', 'ŗ' => 'r', 'Ŗ' => 'R', 'ś' => 's', 'Ś' => 'S', 'ŝ' => 's', 'Ŝ' => 'S', 'š' => 's', 
                                        'Š' => 'S', 'ṡ' => 's', 'Ṡ' => 'S', 'ş' => 's', 'Ş' => 'S', 'ș' => 's', 'Ș' => 'S', 'ß' => 'SS',
                                        'ť' => 't', 'Ť' => 'T', 'ṫ' => 't', 'Ṫ' => 'T', 'ţ' => 't', 'Ţ' => 'T', 'ț' => 't', 'Ț' => 'T',
                                        'ŧ' => 't', 'Ŧ' => 'T', 'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ŭ' => 'u', 'Ŭ' => 'U', 
                                        'û' => 'u', 'Û' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ű' => 'u', 'Ű' => 'U', 'ũ' => 'u', 'Ũ' => 'U',
                                        'ų' => 'u', 'Ų' => 'U', 'ū' => 'u', 'Ū' => 'U', 'ư' => 'u', 'Ư' => 'U', 'ü' => 'ue', 'Ü' => 'UE',
                                        'ẃ' => 'w', 'Ẃ' => 'W', 'ẁ' => 'w', 'Ẁ' => 'W', 'ŵ' => 'w', 'Ŵ' => 'W', 'ẅ' => 'w', 'Ẅ' => 'W', 
                                        'ý' => 'y', 'Ý' => 'Y', 'ỳ' => 'y', 'Ỳ' => 'Y', 'ŷ' => 'y', 'Ŷ' => 'Y', 'ÿ' => 'y', 'Ÿ' => 'Y', 
                                        'ź' => 'z', 'Ź' => 'Z', 'ž' => 'z', 'Ž' => 'Z', 'ż' => 'z', 'Ż' => 'Z', 'þ' => 'th', 'Þ' => 'Th',
                                        'µ' => 'u', 'а' => 'a', 'А' => 'a', 'б' => 'b', 'Б' => 'b', 'в' => 'v', 'В' => 'v', 'г' => 'g', 
                                        'Г' => 'g', 'д' => 'd', 'Д' => 'd', 'е' => 'e', 'Е' => 'e', 'ё' => 'e', 'Ё' => 'e', 'ж' => 'zh',
                                        'Ж' => 'zh', 'з' => 'z', 'З' => 'z', 'и' => 'i', 'И' => 'i', 'й' => 'j', 'Й' => 'j', 'к' => 'k', 
                                        'К' => 'k', 'л' => 'l', 'Л' => 'l', 'м' => 'm', 'М' => 'm', 'н' => 'n', 'Н' => 'n', 'о' => 'o', 
                                        'О' => 'o', 'п' => 'p', 'П' => 'p', 'р' => 'r', 'Р' => 'r', 'с' => 's', 'С' => 's', 'т' => 't', 
                                        'Т' => 't', 'у' => 'u', 'У' => 'u', 'ф' => 'f', 'Ф' => 'f', 'х' => 'h', 'Х' => 'h', 'ц' => 'c', 
                                        'Ц' => 'c', 'ч' => 'ch', 'Ч' => 'ch', 'ш' => 'sh', 'Ш' => 'sh', 'щ' => 'sch', 'Щ' => 'sch', 
                                        'ъ' => '', 'Ъ' => '', 'ы' => 'y', 'Ы' => 'y', 'ь' => '', 'Ь' => '', 'э' => 'e', 'Э' => 'e', 
                                        'ю' => 'ju', 'Ю' => 'ju', 'я' => 'ja', 'Я' => 'ja');
        $txt = str_replace(array_keys($transliterationTable), array_values($transliterationTable), $txt);
        return $txt;
    }
}

function replaceTitle($retour) 
{
            
    $retour = str_replace(" ", "-",$retour);
    $retour = str_replace(",","-",$retour);
    $retour = str_replace("-","-",$retour);
    $retour = str_replace(".","-",$retour);
    $retour = str_replace("*","-",$retour);	
    $retour = str_replace("#","-",$retour);
    $retour = str_replace("@","-",$retour);
    $retour = str_replace("&amp;","-",$retour);
    $retour = str_replace("|","-",$retour);
    $retour = str_replace("&","-",$retour);
    $retour = str_replace("(","-",$retour);
    $retour = str_replace(";","-",$retour);
    $retour = str_replace(")","-",$retour);
    $retour = str_replace(",","-",$retour);
    $retour = str_replace("/","-",$retour);
    $retour = str_replace("+","-",$retour);
    $retour = str_replace("=","-",$retour);
    $retour = str_replace("]","-",$retour);
    $retour = str_replace("[","-",$retour);
    $retour = str_replace("°","-",$retour);
    $retour = str_replace("?","-",$retour);
    $retour = str_replace("!","-",$retour);
    $retour = str_replace("%","-",$retour);
    $retour = str_replace("µ","-",$retour);
    $retour = str_replace("§","-",$retour);
    $retour = str_replace(":","-",$retour);
    $retour = str_replace("$","-",$retour);
    $retour = str_replace("£","-",$retour);
    $retour = str_replace("¤","-",$retour);
    $retour = str_replace("\xE2\x82\xAc","-",$retour);
    
    return $retour;
}

function createItemUrl($url)
{
    $url=convert_special_simple($url);
    $url=replaceTitle($url);
    $url=rtrim($url, "-");
    return $url;
}

function CreateSeoUrl($title,$filter_title,$url='',$fullbase=array())
{
    $CI =& get_instance();
    return $CI->html->link($title, $url."/".createItemUrl($filter_title).".html",$fullbase);
}
if ( ! function_exists('filter_lang_file_include'))
{
    function filter_lang_file_include($txt)
    {
        $txt_arr = explode(".",$txt);
        $slice_index= (sizeof($txt_arr)-1);
        $ext = array_slice($txt_arr, $slice_index,1); 
        $txt = array_slice($txt_arr,0,$slice_index); 
        $txt=implode("_",$txt);
        $txt = spacetounderscore($txt);
        $txt = convert_special_simple($txt);
        $txt = cleanIdData($txt);
        $txt = nohtmldata($txt);
        $txt = strtolower($txt);
        return $txt.".".$ext[0];
    }
}
if ( ! function_exists('filter_lang_file_content'))
{
    function filter_lang_file_content($txt)
    {
        $txt = str_replace(" ","",$txt);
        $txt = convert_special_simple($txt);
        $txt = nohtmldata($txt);
        $txt = cleanIdData($txt);
        $txt = strtoupper($txt);
        return $txt;
    }
}

if ( ! function_exists('filter_lang_file_value'))
{
    function filter_lang_file_value($txt)
    {
        $txt = str_replace("\"","'",$txt);
        $txt = nohtmldata($txt);
        return $txt;
    }
}
    
if ( ! function_exists('get_xml_nodes'))
{        
        function get_xml_nodes($path)
        {
            $data['include_file']=array();
            $xml = simplexml_load_file($path);

            
            $i=0;
            foreach($xml->children() as $key=>$child)
            {
                if($key=="include_file")
                {
                    foreach($child->children() as $key2=>$child2)
                    {
                        array_push($data['include_file'],$child2);
                    }
                        
                }
                if($key=="langs")
                {
                    foreach($child->children() as $key2=>$child2)
                    {
                        if($key2=="comment")
                            $data['langs'][$i]['comment']=$child2;
                        else
                        {
                            if($key2=="key")
                            $data['langs'][$i]['key']=$child2;
                            if($key2=="value")
                            $data['langs'][$i]['value']=$child2;
                        }
                    }
                    $i++;
                }
            }
            return $data;
            
        }
}

if ( ! function_exists('_eco_printr')){
        function _eco_printr($value="",$echo_pre=false,$die=false,$die_val="")
        {
                
                if($echo_pre)
                    echo "<pre>";
                print_r($value);
                if($echo_pre)
                    echo "</pre>";
                if($die)
                    die($die_val);
        }
}

if ( ! function_exists('truncateHTML')){
  function truncateHTML($html, $length)
    {
        $truncatedText = substr($html, $length);
        $pos = strpos($truncatedText, ">");
        if($pos !== false)
        {
            $html = substr($html, 0,$length + $pos + 1);
        }
        else
        {
            $html = substr($html, 0,$length);
        }

        preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];

        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];

        $len_opened = count($openedtags);

        if (count($closedtags) == $len_opened)
        {
            return $html;
        }

        $openedtags = array_reverse($openedtags);
        for ($i=0; $i < $len_opened; $i++)
        {
            if (!in_array($openedtags[$i], $closedtags))
            {
                $html .= '</'.$openedtags[$i].'>';
            }
            else
            {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }


        return $html;
    }  
}

//========================================================


/* End of file common_function_helper.php */
/* Location: /helpers/common_function_helper.php */
