<?php
class ProductModel extends Model
{
    protected $table = 'products';

    public function getAll()
    {
        return $this->db->table($this->table)->get()->getResult();
    }

    public function find($id)
    {
        return $this->db->table($this->table)->where('id', $id)->get()->getRow();
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