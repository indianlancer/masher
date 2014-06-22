<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//CURRENCY FUNCTIONS

if ( ! function_exists('cust_money_format'))
{
        function cust_money_format($value) 
        {
            return sprintf("%01.".MONEY_PLACE."f", $value);
        }
}

if ( ! function_exists('currency_sym_place'))
{
        function currency_sym_place($value) 
        {
            $value=number_format($value, MONEY_PLACE);
            $CI =& get_instance();
            $setting_data=$CI->coresession->userdata('SETTINGS_DATA');
            
            $currency_code=$setting_data['currency_code'];
           
            $currencyObj= new Currency_model();
            /* Convert */
            $value=input_money($value);
            
            $arrCurrency = $currencyObj->convert('EUR', $currency_code, $value);
            $value = $arrCurrency['to_amount'];
            //$value=print_money($value);
            $ret_val = $value;
            return $ret_val;
        }
}


if ( ! function_exists('input_money'))
{
	function input_money($value,$call_only=false)
	{
            if($call_only)
            $value=number_format($value, MONEY_PLACE);
            $CI =& get_instance();
            $commonObj=new Common_model(); // common model object created 
            $setting_data=$CI->coresession->userdata('SETTINGS_DATA');
            
            $all_seprator=$commonObj->get_money_format_seprators();
            foreach($all_seprator as $sept)
            {
                // Drop all thousands separator
                $value = str_replace($sept->seprator, '', $value);
            }
            
            // Drop decimal symbol 
            $value = str_replace($setting_data['decimal_symbol'], '', $value);
            
            $num_divider=1;
            for($i=1;$i<=MONEY_PLACE;$i++)
                $num_divider=$num_divider*10;
            
            $value=number_format(($value/$num_divider), MONEY_PLACE,".","");

            
            //echo "<br>".$value."<br>";
            return $value;
	}
}
if ( ! function_exists('input_money_euro'))
{
	function input_money_euro($value)
	{
            $value = str_replace(".", '', $value);
            $value = str_replace(",", '.', $value);
            return $value;
	}
}

if ( ! function_exists('print_money'))
{
	function print_money($value)
	{
            $CI =& get_instance();
            $commonObj=new Common_model(); // common model object created 
            $setting_data=$CI->coresession->userdata('SETTINGS_DATA');
            $value=number_format($value,MONEY_PLACE, $setting_data['decimal_symbol'], $setting_data['thousand_seprator']);
            return $value;
	}
}
if ( ! function_exists('print_money_euro'))
{
	function print_money_euro($value)
	{
            $value=number_format($value,MONEY_PLACE, ',', '.');
            return $value;
	}
}
if ( ! function_exists('add_symbol'))
{
	function add_symbol($value)
	{
            $CI =& get_instance();
            $setting_data=$CI->coresession->userdata('SETTINGS_DATA');
            $ret_val=$setting_data['currency'];
            $place=$setting_data['currency_place'];
            $space=$setting_data['currency_space'];
            switch($place)
                {
                    case 1: // 1 means first/before
                            if($space)
                            {
                                $ret_val= $ret_val." ";
                            }
                            $ret_val = $ret_val.$value;
                            break;

                    case 2: // 2 means second/after
                            if($space)
                            {
                                $ret_val= " ".$ret_val;
                            }
                            $ret_val = $value.$ret_val;
                            break;
                }
         return $ret_val;
	}
}

if ( ! function_exists('print_money_with_symbol'))
{
	function print_money_with_symbol($value,$currency_code)
	{
            $curr_sett=get_curreny_sett_by_code($currency_code);
            $decimal_symbol=$curr_sett->decimal_symbol;
            $thousand_seprator=$curr_sett->thousand_seprator;
            $CI =& get_instance();
            $value=print_money_by_data($value,$decimal_symbol, $thousand_seprator);
            $value=add_symbol_by_data($value,$curr_sett->currency_symbol,$curr_sett->place,$curr_sett->space);
            return $value;
	}
}

if ( ! function_exists('print_money_by_data'))
{
	function print_money_by_data($value,$decimal_symbol, $thousand_seprator)
	{
            $CI =& get_instance();
            $value=number_format($value,MONEY_PLACE, $decimal_symbol, $thousand_seprator);
            return $value;
	}
}
if ( ! function_exists('add_symbol_by_data'))
{
	function add_symbol_by_data($value,$currency,$place,$space)
	{
            
            $ret_val="<b>".$currency."</b>";
            
            switch($place)
                {
                    case 1: // 1 means first/before
                            if($space)
                            {
                                $ret_val= $ret_val." ";
                            }
                            $ret_val = $ret_val.$value;
                            break;

                    case 2: // 2 means second/after
                            if($space)
                            {
                                $ret_val= " ".$ret_val;
                            }
                            $ret_val = $value.$ret_val;
                            break;
                }
         return $ret_val;
	}
}

if ( ! function_exists('get_curreny_sym_by_code'))
{
	function get_curreny_sym_by_code($code)
	{
            $CI =& get_instance();
            $commonObj=new Common_model(); // common model object created 
            $currency=$commonObj->getcurrenysymbol_by_code($code);
            return $currency->currency_symbol;
	}
}
if ( ! function_exists('get_curreny_sett_by_code'))
{
	function get_curreny_sett_by_code($code)
	{
            
            $CI =& get_instance();
            $commonObj=new Common_model(); // common model object created 
            $currency=$commonObj->getcurrenysett_by_code($code);
            return $currency;
	}
}



/* End of file currency_function_helper.php */
/* Location: /helpers/currency_function_helper.php */
