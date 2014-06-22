<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Form 
{
    private $edit;    
    public function __construct() 
    {
        $this->CI =& get_instance();
        
        $action = $this->CI->router->fetch_method();
        $main_action = uri_string();
        $main_action = explode("/", $main_action);
        $action_key = array_search($action,$main_action);
        $def_path = array_slice($main_action, 1,$action_key); 
        if(isset($def_path[0]) && $def_path[0]=='edit')
        {
            $this->edit=true;
        }
        
    }
    
	function open($action = '', $attributes = '', $hidden = array())
	{
	

		if ($attributes == '')
		{
			$attributes = 'method="post"';
		}

		// If an action is not a full URL then turn it into one
		if ($action && strpos($action, '://') === FALSE)
		{
			$action = $this->CI->config->site_url($action);
		}

		// If no action is provided then set to the current url
		$action OR $action = $this->CI->config->site_url($this->CI->uri->uri_string());

		$form = '<form action="'.$action.'"';

		$form .= _attributes_to_string($attributes, TRUE);

		$form .= '>';

		// Add CSRF field if enabled, but leave it out for GET requests and requests to external websites	
		if ($this->CI->config->item('csrf_protection') === TRUE AND ! (strpos($action, $this->CI->config->base_url()) === FALSE OR strpos($form, 'method="get"')))	
		{
			$hidden[$this->CI->security->get_csrf_token_name()] = $this->CI->security->get_csrf_hash();
		}

		if (is_array($hidden) AND count($hidden) > 0)
		{
			$form .= sprintf("<div style=\"display:none\">%s</div>", form_hidden($hidden));
		}

		return $form;
	}

// ------------------------------------------------------------------------

/**
 * Form Declaration - Multipart type
 *
 * Creates the opening portion of the form, but with "multipart/form-data".
 *
 * @access	public
 * @param	string	the URI segments of the form destination
 * @param	array	a key/value pair of attributes
 * @param	array	a key/value pair hidden data
 * @return	string
 */
	function open_multipart($action = '', $attributes = array(), $hidden = array())
	{
		if (is_string($attributes))
		{
			$attributes .= ' enctype="multipart/form-data"';
		}
		else
		{
			$attributes['enctype'] = 'multipart/form-data';
		}

		return form_open($action, $attributes, $hidden);
	}

// ------------------------------------------------------------------------

/**
 * Hidden Input Field
 *
 * Generates hidden fields.  You can pass a simple key/value string or an associative
 * array with multiple values.
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @return	string
 */
	function hidden($name, $value = '', $recursing = FALSE)
	{
		static $form;

		if ($recursing === FALSE)
		{
			$form = "\n";
		}

		if (is_array($name))
		{
			foreach ($name as $key => $val)
			{
				hidden($key, $val, TRUE);
			}
			return $form;
		}
                //echo $this->CI->class_name();
                if(strlen($value>0) || !empty ($value))
                {
                    if ( ! is_array($value))
                    {
                            $form .= '<input type="hidden" name="'.$name.'" value="'.form_prep($value, $name).'" />'."\n";
                    }
                    else
                    {
                            foreach ($value as $k => $v)
                            {
                                    $k = (is_int($k)) ? '' : $k;
                                    form_hidden($name.'['.$k.']', $v, TRUE);
                            }
                    }
                }

		return $form;
	}


// ------------------------------------------------------------------------

/**
 * Text Input Field
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
	function input($data = '', $value = '', $extra = '')
	{
            if($this->edit==true)
            {
                if(isset($this->CI->request->data[$data['name']]))
                {
                    
                
                
                    if(isset($data['allow_html']) && $data['allow_html'])
                       $val_data =  $this->CI ->request->data[$data['name']];
                    else
                        $val_data =  nohtmldata($this->CI ->request->data[$data['name']]);
                    $data['value'] = $val_data;
                    unset($data['allow_html']);
                }
            }
            return form_input($data);
	}


// ------------------------------------------------------------------------

/**
 * Password Field
 *
 * Identical to the input function but adds the "password" type
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
	function password($data = '', $value = '', $extra = '')
	{
		if ( ! is_array($data))
		{
			$data = array('name' => $data);
		}

		$data['type'] = 'password';
		return input($data, $value, $extra);
	}

// ------------------------------------------------------------------------

/**
 * Upload Field
 *
 * Identical to the input function but adds the "file" type
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
	function upload($data = '', $value = '', $extra = '')
	{
		if ( ! is_array($data))
		{
			$data = array('name' => $data);
		}

		$data['type'] = 'file';
		return $this->input($data, $value, $extra);
	}

// ------------------------------------------------------------------------

/**
 * Textarea field
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
	function textarea($data = '', $value = '', $extra = '')
	{
            $editor_data = "";
            if($this->edit==true)
            {
                if(!isset($this->CI->request->data[$data['name']]))
                {

                
                    if(isset($data['allow_html']) && $data['allow_html'])
                       $val_data =  $this->CI ->request->data[$data['name']];
                    else
                        $val_data =  nohtmldata($this->CI ->request->data[$data['name']]);
                    $data['value'] = $val_data;
                    unset($data['allow_html']);
                }
            }
            if(isset($data['editor']) && $data['editor'])
               $editor_data =  "<script>$('".$data['editor']."').jqte();</script>";
            else
                $editor_data =  "";
            return form_textarea($data)."\n".$editor_data;
	}

// ------------------------------------------------------------------------

/**
 * Multi-select menu
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	mixed
 * @param	string
 * @return	type
 */
	function multiselect($name = '', $options = array(), $selected = array(), $extra = '')
	{
		if ( ! strpos($extra, 'multiple'))
		{
			$extra .= ' multiple="multiple"';
		}

		return dropdown($name, $options, $selected, $extra);
	}


// --------------------------------------------------------------------

/**
 * Drop-down Menu
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	string
 * @param	string
 * @return	string
 */
	function dropdown($name = '', $options = array(), $selected = array(), $extra = '')
	{
		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$name]))
			{
				$selected = array($_POST[$name]);
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";

		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val) && ! empty($val))
			{
				$form .= '<optgroup label="'.$key.'">'."\n";

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$form .= '</optgroup>'."\n";
			}
			else
			{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

				$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
			}
		}

		$form .= '</select>';

		return $form;
	}


// ------------------------------------------------------------------------

/**
 * Checkbox Field
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	bool
 * @param	string
 * @return	string
 */
	function checkbox($data = '', $value = '', $checked = FALSE, $extra = '')
	{
		$defaults = array('type' => 'checkbox', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

		if (is_array($data) AND array_key_exists('checked', $data))
		{
			$checked = $data['checked'];

			if ($checked == FALSE)
			{
				unset($data['checked']);
			}
			else
			{
				$data['checked'] = 'checked';
			}
		}

		if ($checked == TRUE)
		{
			$defaults['checked'] = 'checked';
		}
		else
		{
			unset($defaults['checked']);
		}

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	}


// ------------------------------------------------------------------------

/**
 * Radio Button
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	bool
 * @param	string
 * @return	string
 */
	function radio($data = '', $value = '', $checked = FALSE, $extra = '')
	{
		if ( ! is_array($data))
		{
			$data = array('name' => $data);
		}

		$data['type'] = 'radio';
		return checkbox($data, $value, $checked, $extra);
	}


// ------------------------------------------------------------------------

/**
 * Submit Button
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
	function submit($data = '', $value = '', $extra = '')
	{
		$defaults = array('type' => 'submit', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	}

// ------------------------------------------------------------------------

/**
 * Reset Button
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
	function reset($data = '', $value = '', $extra = '')
	{
		$defaults = array('type' => 'reset', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value);

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	}


// ------------------------------------------------------------------------

/**
 * Form Button
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
	function button($data = '', $content = '', $extra = '')
	{
		$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'type' => 'button');

		if ( is_array($data) AND isset($data['content']))
		{
			$content = $data['content'];
			unset($data['content']); // content is not an attribute
		}

		return "<button "._parse_form_attributes($data, $defaults).$extra.">".$content."</button>";
	}

// ------------------------------------------------------------------------

/**
 * Form Label Tag
 *
 * @access	public
 * @param	string	The text to appear onscreen
 * @param	string	The id the label applies to
 * @param	string	Additional attributes
 * @return	string
 */
	function label($label_text = '', $id = '', $attributes = array())
	{

		$label = '<label';

		if ($id != '')
		{
			$label .= " for=\"$id\"";
		}

		if (is_array($attributes) AND count($attributes) > 0)
		{
			foreach ($attributes as $key => $val)
			{
				$label .= ' '.$key.'="'.$val.'"';
			}
		}

		$label .= ">$label_text</label>";

		return $label;
	}

// ------------------------------------------------------------------------
/**
 * Fieldset Tag
 *
 * Used to produce <fieldset><legend>text</legend>.  To close fieldset
 * use fieldset_close()
 *
 * @access	public
 * @param	string	The legend text
 * @param	string	Additional attributes
 * @return	string
 */
	function fieldset($legend_text = '', $attributes = array())
	{
		$fieldset = "<fieldset";

		$fieldset .= _attributes_to_string($attributes, FALSE);

		$fieldset .= ">\n";

		if ($legend_text != '')
		{
			$fieldset .= "<legend>$legend_text</legend>\n";
		}

		return $fieldset;
	}

// ------------------------------------------------------------------------

/**
 * Fieldset Close Tag
 *
 * @access	public
 * @param	string
 * @return	string
 */
	function fieldset_close($extra = '')
	{
		return "</fieldset>".$extra;
	}

// ------------------------------------------------------------------------

/**
 * Form Close Tag
 *
 * @access	public
 * @param	string
 * @return	string
 */
	function close($extra = '')
	{
		return "</form>".$extra;
	}

}
/* End of file form_helper.php */
/* Location: ./system/helpers/form_helper.php */
