<?php
class ProductModel extends Model
{
    protected $table = 'products';

    public function __construct()
    {
        parent::__construct();
        $this->call->library('database');
    }

    public function getAll()
    {
        return $this->db->table($this->table)->result();
    }

    public function find($id)
    {
        return $this->db->table($this->table)->where('id', $id)->row();
    }

    public function create($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    public function update($id, $data)
    {
        return $this->db->table($this->table)->where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return $this->db->table($this->table)->where('id', $id)->delete();
    }
}