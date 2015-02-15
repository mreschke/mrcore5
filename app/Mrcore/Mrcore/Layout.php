<?php namespace Mrcore\Mrcore;

/**
 * This is the layout API layer used from the Mrcore class/facade
 * This layer allows us to change our model columns/properties while
 * maintaining a consistent interface for the wiki users
 */
class Layout implements LayoutInterface
{
	public function title($value = null)
	{
		return \Layout::title($value);
	}

	public function css($value = null, $prepend = false)
	{
		return \Layout::css($value, $prepend);
	}

	public function removeCss($value)
	{
		return \Layout::removeCss($value);
	}

	public function printCss($value = null, $prepend = false)
	{
		return \Layout::printCss($value, $prepend);
	}

	public function js($value = null, $prepend = false)
	{
		return \Layout::js($value, $prepend);
	}

	public function removeJs($value)
	{
		return \Layout::removeJs($value);
	}

	public function script($value = null)
	{
		return \Layout::script($value);
	}

	public function mode($value = null)
	{
		return \Layout::mode($value);
	}

	public function modeIs($value)
	{
		return \Layout::modeIs($value);
	}

	public function hideAll($value = null)
	{
		return \Layout::hideAll($value);
	}

	public function hideHeaderbar($value = null)
	{
		return \Layout::hideHeaderbar($value);
	}

	public function hideFooterbar($value = null)
	{
		return \Layout::hideFooterbar($value);
	}

	public function hideTitlebar($value = null)
	{
		return \Layout::hideTitlebar($value);
	}

	public function hideMenubar($value = null)
	{
		return \Layout::hideMenubar($value);
	}

	public function viewport($value = null)
	{
		return \Layout::viewport($value);
	}

	public function container($value = null)
	{
		return \Layout::container($value);
	}
}
