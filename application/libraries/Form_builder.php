<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Form Builder Class
 *
 * @package	CodeIgniter
 * @subpackage	Libraries
 * @category	Forms
 * @author      Brad Traversy
 */
class Form_builder
{
	// *** Member Variable Declaration ***

	protected $attribution = true;
	protected $fields = array();
	protected $seperator;
	protected $recaptchaPublicKey = null;
	protected $recaptchaPrivateKey = null;
	protected $disallowedTypes = array("exe", "dll", "vbs", "js", "bat", "bin", "php", "phps", "asp", "aspx", "js", "scr");	
		
	// *** Public Member Functions ***
	
	/* 
	Function: Constructor
	Purpose: Called upon instantiated to perform initial setup of the form fields if a specific '$type' is passed.
	Arguments:
		$type - Determines the type of form to generate
		$width - Overrides default width of form fields (in pixels) - useful for making form fit (in sidebars for example)
	*/	
	public function __construct($config)
	{   
            $type = $config['type'];
            $width = $config['width'];
            if ($type) $this->setup($type, $width);
	}
	
	
        
	
	/* 
	Function: setSeperator
	Purpose: Used to set the character or string which seperates the form field names from the data entry elements
	Arguments:
		$seperator - Character or string used to seperate form field names from data entry elements (e.g. ':', ' -' or ':-')
	*/
	public function setSeperator($seperator)
	{
		$this->seperator = $seperator;
	}
	
	/* 
	Function: setAttribution
	Purpose: Sets whether or not the attribution text, 'Powered by Contacular', is displayed on generated forms
	Recommendation: Leaving this text displayed gives credit to the original author, and helps promote Contacular
	Arguments:
		$attribution - Boolean used to determine whether or not the 'Powered by Contacular' text is displayed
	*/
	public function setAttribution($attribution = true)
	{
		$this->attribution = $attribution;
	}
	
	/* 
	Function: setDisallowedTypes
	Purpose: Allows you to override thhe default array of disallowed file types for uploaded files
	Arguments:
		$disallowedTypes - Array of file extensions which are disallowed for the upload of files.
	*/
	public function setDisallowedTypes($disallowedTypes)
	{
		$this->disallowedTypes = $disallowedTypes;
	}
	
	/* 
	Function: setRecaptchaPublicKey
	Purpose: Sets the Recaptcha public key obtained from recaptcha.net and enables Recaptcha checking
	Arguments:
		$recaptchaPublicKey - Recaptcha public key obtained from recaptcha.net
	*/
	public function setRecaptchaPublicKey($recaptchaPublicKey)
	{
		$this->recaptchaPublicKey = $recaptchaPublicKey;
	}
	
	/* 
	Function: setRecaptchaPrivateKey
	Purpose: Sets the Recaptcha public key obtained from recaptcha.net and enables Recaptcha checking
	Arguments:
		$recaptchaPublicKey - Recaptcha public key obtained from recaptcha.net
	*/
	public function setrecaptchaPrivateKey($recaptchaPrivateKey)
	{
		$this->recaptchaPrivateKey = $recaptchaPrivateKey;
	}
	
	/* 
	Function: setAdvancedValidation
	Purpose: Sets whether or not advanced validation checking is performed (such as DNS A record checking on e-mail address validation)
	Recommendation: Enabled by default (recommended) to ensure maximum validation, but could potentially cause false positives.
	Arguments:
		$advancedValidation - Boolean used to determine whether or not advanced validation techniques are used
	*/
	public function setAdvancedValidation($advancedValidation = true)
	{
		$this->advancedValidation = $advancedValidation;
	}
	
	/* 
	Function: getCode
	Purpose: Generate the defined form HTML code and return it for output or other use
	Returns: String - Generated HTML code for form
	Arguments:
		None
	*/
	public function getCode()
	{
		// Check sanity of ContacularForm object
		if ($sanity = $this->sanityCheck()) return $sanity;
		
		// Generate HTML code
		$url = $this->getURL();
		if ($this->attribution)
		{
			$code = "\n<!-- Contacular Form Start (http://contacular.co.uk/) -->\n";
		}
		$code .= "<form method=\"post\" action=\"".$url."\" name=\"contacularform\" enctype=\"multipart/form-data\">";		
		$code .= "<table>";
		foreach ($this->fields as $field)
		{
			$code .= "<tr>";
			$code .= "<td><label for=\"".$field['name']."\">".$field['label'].$this->seperator." </label></td>";
			$code .= "<td>";
			$code .= $this->getFormFieldText($field);
			$code .= "</td>";
			$code .= "</tr>";
		}
		if ($this->recaptchaPublicKey && $this->recaptchaPrivateKey)
		{
			require_once('recaptchalib.php');
			$code .= "<tr><td></td><td>";
			$code .= recaptcha_get_html($this->recaptchaPublicKey);
			$code .="</td></tr>";
		}
			$code .= "<tr><td></td><td><input style=\"font-family: inherit;\" type=\"submit\" name=\"contacularform_submit\" value=\"Send\" /> </td></tr>";
		$code .= "</table>";
		$code .= "</form>";
		if ($this->attribution)
		{
			$code .= "\n<!-- Contacular Form End -->\n";
		}
		return $code;
	}
	
	
	/* 
	Function: addField
	Purpose: Adds a field to the Contacular form object
	Arguments:
		$name - Internal identifier of form field
		$label - Human readably, friendly name of form field
		$type - Contacular form field type
		$height - Height of form field, defaults to 25 pixels
		$width - Width of form field, defaults to 250 pixels
		$options - Array of options for use with 'select' form field type
	*/
	public function addField($name, $label, $type="text", $height=null, $width=null, $options=array())
	{
		if (!$height) $height = 25;
		if (!$width) $width = 250;
		$newField = &$this->fields[];
		$newField['name'] = $name;
		$newField['label'] = $label;
		$newField['type'] = $type;
		$newField['width'] = $width;
		$newField['height'] = $height;
		$newField['options'] = $options;
	}
       
	// *** Private Member Functions ***
	
	private function setup($type=custom,$width=null)
	{
		switch($type)
		{
			case "custom":
				//All custom fields
				break;
				
			case "simplesubject":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("subject", "Subject", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("message", "Message", "mandatorytextarea", 100, $width);
				break;
				
			case "simpleresponse":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("message", "Message", "mandatorytextarea", 100, $width);
				$this->addField("response_desired", "Response desired", "checkbox");
				break;
		
			case "callback":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_telephone", "Telephone", "mandatorytext", $width);
				break;
				
			case "enquiry":
				$this->addField("from_title", "Title", "select", null, 70, array("Mr", "Mrs", "Miss", "Dr"));
				$this->addField("from_firstname", "First name", "mandatorytext", null, $width);
				$this->addField("from_lastname", "Surname", "mandatorytext", null, $width);
				$this->addField("from_telephone", "Telephone", "text", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("enquiry", "Enquiry", "mandatorytextarea", 100, $width);
				break;
				
			case "cataloguerequest":
				$this->addField("from_title", "Title", "select", null, 70, array("Mr", "Mrs", "Miss", "Dr"));
				$this->addField("from_firstname", "First name", "mandatorytext", null, $width);
				$this->addField("from_lastname", "Surname", "mandatorytext", null, $width);
				$this->addField("from_telephone", "Telephone", "text", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("addressline1", "Address Line 1", "mandatorytext", null, $width);
				$this->addField("addressline2", "Address Line 2", "text", null, $width);
				$this->addField("addressline3", "Address Line 3", "text", null, $width);
				$this->addField("city", "City", "mandatorytext", null, $width);
				$this->addField("county", "County / State", "mandatorytext", null, $width);
				$this->addField("postcode", "Post / ZIP Code", "mandatorytext", null, $width);
				$this->addField("country", "Country", "mandatorytext", null, $width);
				break;
				
			case "contact":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("from_telephone", "Telephone", "text", null, $width);
				$this->addField("message", "Message", "mandatorytextarea", 100, $width);
				break;
				
			case "contactresponse":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("from_telephone", "Telephone", "text", null, $width);
				$this->addField("message", "Message", "mandatorytextarea", 100, $width);
				$this->addField("response_desired", "Response desired", "checkbox");
				break;
				
			case "companycontact":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("from_company", "Company", "text", null, $width);
				$this->addField("from_telephone", "Telephone", "text", null, $width);
				$this->addField("message", "Message", "mandatorytextarea", 100, $width);
				break;
				
			case "companycontactreferrer":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("from_company", "Company", "text", null, $width);
				$this->addField("from_telephone", "Telephone", "text", null, $width);
				$this->addField("referrer", "How did you find us?", "select", null, $width, array("Not sure / Do not wish to say", "Link from another site", "Search engine", "Recommended by a friend", "E-mail campaign", "Advert (Internet)", "Advert (Paper-based)", "Other"));
				$this->addField("referrer_details", "Details on how you found us", "text", null, $width);
				$this->addField("message", "Message", "mandatorytextarea", 100, $width);
				break;
				
			case "comment":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("from_website", "Website", "text", null, $width);
				$this->addField("message", "Message", "mandatorytextarea", 100, $width);
				break;
				
			case "development":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("from_subject", "Subject", "select", null, $width, array("General", "Bug Report", "Feature Request"));
				$this->addField("message", "Message", "mandatorytextarea", 100, $width);
				break;
				
			case "simplenewsletter":
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("subscribe_to_newsletter", "Subscribe to newsletter", "checkbox");
				break;
				
			case "newsletter":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("subscribe_to_newsletter", "Subscribe to newsletter", "checkbox");
				break;
				
			case "submitcv":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("from_telephone", "Telephone", "text", null, $width);
				$this->addField("cv", "Submit CV", "file", null, $width);
				break;
				
			case "submitresume":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("from_telephone", "Telephone", "text", null, $width);
				$this->addField("cv", "Submit Resume", "file", null, $width);
				break;
				
			case "submitimage":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("image", "Submit image", "file", null, $width);
				break;
			
			case "submitdocument":
				$this->addField("from_name", "Name", "mandatorytext", null, $width);
				$this->addField("from_email", "E-mail", "email", null, $width);
				$this->addField("document", "Submit document", "file", null, $width);
				break;
				
			case "custom":
				break;
				
			default:
				if ($this->attribution)
				{
					$contacularName = "Contacular";
				}
				else
				{
					$contacularName = "System";
				}
				echo $contacularName." error: Supplied form type '".$type."' is not valid.";
				break;
		}
	}
	
	private function getFormFieldText($field)
	{
		switch ($field['type'])
		{		
			case "textarea":
			case "mandatorytextarea":
				return "<textarea style=\"width: ".$field['width']."px; height: ".$field['height']."px;\" name=\"".$field['name']."\" id=\"".$field['name']."\" ></textarea>";
				break;
				
			case "checkbox":
				return "<input name=\"".$field['name']."\" id=\"".$field['name']."\" type=\"checkbox\" value=\"Ticked\" />";
				break;
				
			case "select":
				return $this->getSelectFormFieldText($field, $field['options']);
				
			case "email":
				return "<input style=\" width: ".$field['width']."px; height: ".$field['height']."px;\" type=\"text\" name=\"".$field['name']."\" id=\"".$field['name']."\" />";
				break;
			
			case "mandatorytext":
				return "<input style=\" width: ".$field['width']."px; height: ".$field['height']."px;\" type=\"text\" name=\"".$field['name']."\" id=\"".$field['name']."\" />";
				break;
				
			default:
				return "<input style=\" width: ".$field['width']."px; height: ".$field['height']."px;\" type=\"".$field['type']."\" name=\"".$field['name']."\" id=\"".$field['name']."\" />";
				break;
		}
	}
	
	private function getSelectFormFieldText($field, $options)
	{
		$code = "<select style=\"width: ".$field['width']."px; height: ".$field['height']."px;\" name=\"".$field['name']."\" id=\"".$field['name']."\">";
		foreach ($options as $option)
		{
			$code .= "<option value=\"".$option."\">".$option."</option>";
		}
		$code .= "</select>";
		return $code;
	}
	
	private function getAttributionText()
	{
		if ($this->attribution)
		{
			return "<span style=\"font-size: 75%;\">Powered by <a href=\"http://contacular.co.uk/\" target=\"_blank\" title=\"Contacular contact form\">Contacular</a></span>";
		}
		return;
	}
	
	private function getFromEmail()
	{
		if ($this->attribution)
		{
			return "contacularbot@".$_SERVER['SERVER_NAME'];
		}
		else
		{
			return "formresponse@".$_SERVER['SERVER_NAME'];
		}
	}
	
	private function sanityCheck()
	{
		if ($this->attribution)
		{
			$contacularName = "Contacular";
		}
		else
		{
			$contacularName = "System";
		}
		if (!$this->fields) return $contacularName." error: No field(s) were defined for this form.";
	}
	
	
	
	
	
	private function getURL()
	{
		$url = 'http';
		if (@$_SERVER["HTTPS"] == "on") 
		{
			$url .= "s";
		}
		$url .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") 
		{
			$url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}
		else
		{
			$url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $url;
	}
	
	private function getFileExtension($filename)
	{
		return substr(strrchr($filename,'.'),1);
	}
}

?>
