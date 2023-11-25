<?php

namespace Repository;



use PgSql;

class AppointmentRepository
{
    private $db;

    public function __construct()
    {
        require 'DB/PgSql.php';
        $this->db = new PgSql();
    }

    // Implementing the GetOne method
    public function getOne($id)
    {
        // SQL query
        $sql = "SELECT * FROM appointment a " .
            "INNER JOIN users d ON d.id = a.doctor_id " .
            "INNER JOIN users p ON p.id = a.patient_id " .
            "WHERE a.id = $id;";

        return $this->db->getRow($sql);
    }

    // Implementing the FindAll method
    public function findAll()
    {
        // SQL query
        $sql = "SELECT *, " .
            "d.last_name AS doctor_lastname, " .
            "d.first_name AS doctor_firstname, " .
            "d.email AS doctor_email, " .
            "p.first_name AS patient_firstname, " .
            "p.last_name AS patient_lastname, " .
            "p.email AS patient_email " .
            "FROM appointment a " .
            "INNER JOIN users d ON d.id = a.doctor_id " .
            "INNER JOIN users p ON p.id = a.patient_id;";

        return $this->db->getRows($sql);
    }

    // Implementing the FindAllByDoctorId method
    public function findAllByDoctorId($id)
    {
        // SQL query
        $sql = "SELECT *, " .
            "d.first_name AS doctor_firstname, " .
            "d.last_name AS doctor_lastname, " .
            "d.email AS doctor_email, " .
            "p.first_name AS patient_firstname, " .
            "p.last_name AS patient_lastname, " .
            "p.email AS patient_email " .
            "FROM appointment a " .
            "INNER JOIN users d ON d.id = a.doctor_id " .
            "INNER JOIN users p ON p.id = a.patient_id " .
            "WHERE a.doctor_id = $id;";

        return $this->db->getRows($sql);
    }

    // Implementing the Save method
    public function save($appointment)
    {
        $doctorId = $appointment['doctor'];
        $patientId = $appointment['patient'];
        $time = $appointment['time'];

        $sql = "INSERT INTO appointment (doctor_id, patient_id, time) " .
            "VALUES ($doctorId, $patientId, '$time') " .
            "ON CONFLICT (id) DO UPDATE SET " .
            "doctor_id = EXCLUDED.doctor_id, " .
            "patient_id = EXCLUDED.patient_id, " .
            "time = EXCLUDED.time;";

        return $this->db->insert($sql);
    }

    // Implementing the Delete method
    public function delete($id)
    {
        $sql = "DELETE FROM appointment WHERE id = $id;";
        return $this->db->exec($sql);
    }

    // Implementing a generic Update method (as it's not implemented in C#)
    public function update($appointment)
    {
        $id = $appointment['id'];
        $doctorId = $appointment['doctor_id'];
        $patientId = $appointment['patient_id'];
        $time = $appointment['time'];

        $sql = "UPDATE appointment SET " .
            "doctor_id = $doctorId, " .
            "patient_id = $patientId, " .
            "time = '$time' " .
            "WHERE id = $id;";

        return $this->db->exec($sql);
    }

    // Implementing a test method similar to C#
    public function test()
    {
        $sql = "INSERT INTO appointment (doctor_id, patient_id, time) " .
            "VALUES (1, 1, '2023-02-22');";

        return $this->db->insert($sql);
    }

}