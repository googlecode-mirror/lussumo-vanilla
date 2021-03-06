<?php
/**
 * The PageEnd control renders the very last items on the page.
 *
 * Copyright 2003 Mark O'Sullivan
 * This file is part of Lussumo's Software Library.
 * Lussumo's Software Library is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 * Lussumo's Software Library is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with Vanilla; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 * The latest source code is available at www.vanilla1forums.com
 * Contact Mark O'Sullivan at mark [at] lussumo [dot] com
 *
 * @author Mark O'Sullivan
 * @copyright 2003 Mark O'Sullivan
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL 2
 * @package Framework
 */


/**
 * Ends the page body.
 * @package Framework
 */
class PageEnd extends Control {
	function PageEnd(&$Context) {
		$this->Name = 'PageEnd';
		$this->Control($Context);
	}
	function Render() {
		$this->CallDelegate('PreRender');
		include(ThemeFilePath($this->Context->Configuration, 'overall_footer.php'));
		include(ThemeFilePath($this->Context->Configuration, 'page_end.php'));
		$this->CallDelegate('PostRender');
	}
}
?>