<?php

class EmailTemplate
{
	/**
	 * This var will be used to get default template that website use
	 * @var String
	 */
	public $templateDir;
	
	/**
	 * Construct function to get template
	 */
	function __construct()
	{
		$app = JFactory::getApplication();
		$this->templateDir = JPATH_ROOT . DS . 'templates' . DS . $app->getTemplate();
	}
	
	/**
	 * Function to get email template
	 * @param String $tmpl
	 * 
	 * @return String: Content of file $tmpl.php
	 */
	function getEmailTemplate($tmpl = null)
	{
		if(!$tmpl)
			return false;
			
		$fileName = $this->templateDir . DS . 'email_templates' . DS . $tmpl . '.php';
		
		$content = file_get_contents($fileName);
		
		return $content;
	}
	
	/**
	 * Function to return content after process template
	 * @param String $tmpl
	 * @param Array $vars Should be array('username' => $username, 'email' => $email);
	 * 
	 * @return String with full info
	 */
	function content($tmpl, $vars = array())
	{
		$content = $this->getEmailTemplate($tmpl);
		
		$arrSearch = array();
		$arrReplace = array();
		
		foreach ($vars as $key => $var)
		{
			$arrSearch[] = '%%'.$key.'%%';
			$arrReplace[] = $var;
		}
		
		$content = str_replace($arrSearch, $arrReplace, $content);
		
		return $content;
	}
}