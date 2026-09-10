<?php
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
                         ->row();
    }
}