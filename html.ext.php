<?php



class EXT_Html extends SYS_Model_Database
{
	//--------------------------------------------------------------------------
	
	public $table = 'html';
	
//	public $name       = 'Текст страницы (HTML)';
//	public $add_action = FALSE;
	
	//--------------------------------------------------------------------------
	
	public function init()
	{
		$this->fields['html'] = array(
			'id' => NULL,
			'type' => NULL,
			'status' => array(
				'label'   => 'Статус',
				'field'   => 'radiogroup',
				'options' => 'status_list',
				'default' => 1,
			),
			'rel_id' => NULL,
			'body' => array(
				'label'  => '',
				'field' => 'html',
			),
		);
	}
	
	//--------------------------------------------------------------------------
	
	public function view($type, $rel_id = 0, $create_row = TRUE)
	{
		$this->db->where('type=? AND rel_id=?', $type, $rel_id);
		$data = $this->get_row();

		if ($data->id)
		{
			return $this->render($data);
		}
		elseif ($create_row)
		{
			$id = $this->insert(NULL, array(
				'type'   => $type,
				'rel_id' => $rel_id
			));
			
			$this->db->where('id=?', $id);
			return $this->render($this->get_row());
		}
	}
	
	//--------------------------------------------------------------------------
	
	public function render(&$data)
	{
		if ( ! $data->status && $this->user->group_id !=1) return;
		return $data->admin_buttons . $data->body;
	}
	
	//--------------------------------------------------------------------------
	
	public function status_list($val = NULL)
	{
		static $list = array(
			0 => 'Отключен',
			1 => 'Включен',
		);
		
		if ($val !== NULL) return $list[$val];
		
		return $list;
	}
	
	//--------------------------------------------------------------------------
}