<?php
/**
 * Kunena Component
 * @package Kunena.Framework
 * @subpackage Form
 *
 * @copyright (C) 2008 - 2011 Kunena Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.org
 **/
defined ( '_JEXEC' ) or die ();

jimport('joomla.html.html');
jimport('joomla.form.formfield');

require_once JPATH_ADMINISTRATOR . '/components/com_kunena/api.php';

JHTML::addIncludePath(KPATH_ADMIN . '/libraries/html/html');
KunenaFactory::loadLanguage('com_kunena');

class JFormFieldKunenaCategoryList extends JFormField {
	protected $type = 'KunenaCategoryList';

	protected function getInput() {
		$none = $this->element['none'];

		$size = $this->element['size'];
		$class = $this->element['class'];

		$attribs = ' ';
		if ($size) {
			$attribs .= 'size="' . $size . '"';
		}
		if ($class) {
			$attribs .= 'class="' . $class . '"';
		} else {
			$attribs .= 'class="inputbox"';
		}
		if (!empty($this->element['multiple'])) {
			$attribs .= ' multiple="multiple"';
		}

		// Get the field options.
		$options = $this->getOptions();

		return JHTML::_('kunenaforum.categorylist', $this->name, 0, $options, $this->element, $attribs, 'value', 'text', $this->value);
	}

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 * @since   11.1
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();

		foreach ($this->element->children() as $option) {

			// Only add <option /> elements.
			if ($option->getName() != 'option') {
				continue;
			}

			// Create a new option object based on the <option /> element.
			$tmp = JHtml::_('select.option', (string) $option['value'], JText::alt(trim((string) $option), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text', ((string) $option['disabled']=='true'));

			// Set some option attributes.
			$tmp->class = (string) $option['class'];

			// Set some JavaScript option attributes.
			$tmp->onclick = (string) $option['onclick'];

			// Add the option object to the result set.
			$options[] = $tmp;
		}

		reset($options);

		return $options;
	}
}
