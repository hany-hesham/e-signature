<?php

	class Spo_item_model extends CI_Model{
	
  		function __contruct(){
			parent::__construct;
		}

		function create_item($data) {
			$this->db->insert('spo_items', $data);
			return ($this->db->affected_rows() == 1)? $this->db->insert_id() : FALSE;
		}
		function get_spo_items($request_id) {
        	$this->load->database();
			$this->db->where('spo_items.spo_id', $request_id);
			$query = $this->db->get('spo_items');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}
		function percentage ($spo_id){
			$this->load->database();
			$this->db->select('spo_items.Discount_percentage');
			$this->db->where('spo_items.spo_id', $spo_id);
			$max = $this->db->get('spo_items');
			$query = max($max->result_array());
			return $query;
		}

		function update_item($data, $spo_id, $item_id) {
			$this->load->database();
			$this->db->where('spo_items.spo_id', $spo_id);	
			$this->db->where('spo_items.id', $item_id);		
			$this->db->update('spo_items', $data);
			$query = $this->db->get('spo_items');
			return $query;
		}
		function get_chairman_items() {
        	$this->load->database();
        	$this->db->select('spo_items.*,spo.hotel_id,hotels.name as hotel_name');
			$this->db->join('spo', 'spo_items.spo_id = spo.id');
			$this->db->join('hotels', 'spo.hotel_id = hotels.id');
        	$x = array('0' => 62, '1' => 64, '2' => 65, '3' => 66, '4' => 67, '5' => 68, '6' => 69, '7' => 70, '8' => 71, '9' => 104, '10' => 105, '11' => 106, '12' => 108, '13' => 109, '14' => 110, '15' => 111, '16' => 112, '17' => 113, '18' => 114, '19' => 115, '20' => 116, '21' => 117, '22' => 118, '23' => 119, '24' => 120, '25' => 121, '26' => 122, '27' => 123, '28' => 124, '29' => 125, '30' => 126, '31' => 127, '32' => 128, '33' => 129, '34' => 130, '35' => 131, '36' => 132, '37' => 133, '38' => 134, '39' => 135, '40' => 136, '41' => 140, '42' => 187, '43' => 211, '44' => 224, '45' => 226, '46' => 233, '47' => 238, '48' => 247, '49' => 252, '50' => 253, '51' => 260, '52' => 261, '53' => 262, '54' => 266, '55' => 270, '56' => 273, '57' => 275, '58' => 276, '59' => 277, '60' => 281, '61' => 282, '62' => 285, '63' => 292, '64' => 294, '65' => 295, '66' => 296, '67' => 297, '68' => 298, '69' => 299, '70' => 300, '71' => 310, '72' => 312, '73' => 313, '74' => 318, '75' => 319, '76' => 320, '77' => 321, '78' => 322, '79' => 324, '80' => 325, '81' => 326, '82' => 327, '83' => 329, '84' => 330, '85' => 331, '86' => 334, '87' => 337, '88' => 338, '89' => 345, '90' => 346, '91' => 393, '92' => 394, '93' => 402, '94' => 405, '95' => 477, '96' => 499);
			$this->db->where_in('spo_items.spo_id', $x);	
			$query = $this->db->get('spo_items');
			return ($query->num_rows() > 0 )? $query->result_array() : FALSE;
		}
}
?>