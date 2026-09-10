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
class UserModel extends Model
{
    protected $table = 'users';

    public function __construct()
    {
        parent::__construct();
        $this->call->library('database');
    }

    public function findByUsername($username)
    {
        return $this->db->table($this->table)
                         ->where('username', $username)
                         ->get()
                         ->getRow();
    }
}