<?php
class Usuario{
	private $id;
	private $nombre;
	private $contrasena;
	private $fechaNacimiento;
	private $edad;
	public function __construct($_id, $_nombre, $_contrasena, $_fechaNacimiento){
		$this->id = $_id;
		$this->nombre = $_nombre;
		$this->contrasena = $_contrasena;
		$this->fechaNacimiento = $_fechaNacimiento;
		$cumpleanos = new DateTime($_fechaNacimiento);
		$hoy = new DateTime();
		$annos = $hoy->diff($cumpleanos);
		echo $annos->y;
		$this->edad = $annos->y;
	}
	public function getId(){
		return $this -> id;
	}

	public function getName(){
		return $this -> nombre;
	}

	public function getAge(){
		return $this -> edad;
	}

	public function printData(){
		echo "Id: ".$this -> id;
		echo "<br>";
		echo "Nombre: ".$this->nombre;
		echo "<br>";
		echo "Contraseña: ".$this->contrasena;
		echo "<br>";
		echo "Fecha de nacimiento: ".$this->fechaNacimiento;
		echo "<br>";
		echo "Edad: ".$this->edad;
		echo "<br>";
	}
}
?>