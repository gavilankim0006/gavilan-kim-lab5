<?php
class UserModel extends Model
{
    protected $table = 'users';

    public function findByUsername($username)
    {
        return $this->db->table($this->table)
                         ->where('username', $username)
                         ->get()
                         ->getRow();
    }
}