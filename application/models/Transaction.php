<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends CI_Model
{
    public $response;

    public function get_last_ten_transactions()
    {
        $query = $this->db->get('transactions', 10);

        return $query->result();
    }

    public function insert_transaction()
    {
        $this->db->insert('transactions', $this);
    }
}
