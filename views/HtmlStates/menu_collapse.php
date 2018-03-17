<?php
namespace views\HtmlStates;

use views\HtmlStates\Interfaces\menu_state;

	class menu_collapse implements menu_state	
	{
		public function current_state()
		{
			return array("img_class"=>"rotate90","menu_class"=>"sidenav-toggled");
		}

	}

?>