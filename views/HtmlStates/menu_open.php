<?php	
namespace views\HtmlStates;

use views\HtmlStates\Interfaces\menu_state;

	class menu_open implements menu_state	
	{
		public function current_state()
		{
			return array("img_class"=>"normal_pos","menu_class"=>" ");
		}

	}

?>