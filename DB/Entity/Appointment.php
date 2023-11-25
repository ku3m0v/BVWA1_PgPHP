<?php

class Appointment
{
    public $id;
    public $doctor;
    public $patient;
    public $time;

    public function __construct($id = null, $doctor = null, $patient = null, $time = null)
    {
        $this->id = $id;
        $this->doctor = $doctor;
        $this->patient = $patient;
        $this->time = $time;
    }

}