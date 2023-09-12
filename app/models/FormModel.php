<?php
class FormModel
{
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function insert($name, $email) {
        $this->db->query("INSERT INTO submissions (name, email) VALUES (:name, :email)");
        $this->db->bind(':name', $name);
        $this->db->bind(':email', $email);
        $this->db->execute();
    }

    public function getAll() {
        $this->db->query("SELECT * FROM submissions");
        return $this->db->resultSet();
    }
}
