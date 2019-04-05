<?php
class Articulo
{
    private $id;
    private $titulo;
    private $subtitulo;
    private $contenido;
    private $fecha;
    private $idTema;
    private $gusta;
    //TODO: Agregar autor
    public function __construct($_id, $_titulo, $_subtitulo, $_contenido, $_fecha, $_idTema, $_gusta)
    {
        $this->id = $_id;
        $this->titulo = $_titulo;
        $this->subtitulo = $_subtitulo;
        $this->contenido = $_contenido;
        $this->fecha = $_fecha;
        $this->idTema = $_idTema;
        $this->gusta = $_gusta;
    }

    public function __construct2()
    {
    }

    public function getId()
    {
        return $this->id;
    }
    public function getTitulo()
    {
        return $this->titulo;
    }
    public function getSubtitulo()
    {
        return $this->subtitulo;
    }
    public function getContenido()
    {
        return $this->contenido;
    }
    public function getFecha()
    {
        return $this->fecha;
    }
    public function getIdTema()
    {
        return $this->idTema;
    }
    public function getGusta()
    {
        return $this->gusta;
    }
    public function printData()
    {
        echo "Id: " . $this->id;
        echo "<br>";
        echo "Titulo: " . $this->titulo;
        echo "<br>";
        echo "Subtitulo: " . $this->subtitulo;
        echo "<br>";
        echo "Contenido: " . $this->contenido;
        echo "<br>";
        echo "Fecha: " . $this->fecha;
        echo "<br>";
        echo "Id tema: " . $this->idTema;
        echo "<br>";
        echo "Gusta: " . $this->gusta;
        echo "<br>";
    }

    public function saveInArticuloJSON()
    {
        $myJSON = json_encode(get_object_vars($this));
        //echo $myJSON;
        $file = 'articuloSeleccionado.txt';
        file_put_contents($file, $myJSON);
    }

    public function saveInXmlFile($ListOfArticulos)
    {
        //Creación del xml
        $xml = new DOMDocument('1.0');
        $xml->formatOutput = true;

        $articulos = $xml->createElement("articulos");
        $xml->appendChild($articulos);

        for ($x = 0; $x < sizeof($ListOfArticulos); $x++) {
            $articulo = $xml->createElement("articulo");
            $articulo->setAttribute("id", $ListOfArticulos[$x]->getId());
            $articulos->appendChild($articulo);

            $titulo = $xml->createElement("titulo", $ListOfArticulos[$x]->getTitulo());
            $articulo->appendChild($titulo);
            $subtitulo = $xml->createElement("subtitulo", $ListOfArticulos[$x]->getSubtitulo());
            $articulo->appendChild($subtitulo);
            $contenido = $xml->createElement("contenido", $ListOfArticulos[$x]->getContenido());
            $articulo->appendChild($contenido);

            $fecha = $xml->createElement("fecha", $ListOfArticulos[$x]->getFecha());
            $articulo->appendChild($fecha);

            $idTema = $xml->createElement("idTema", $ListOfArticulos[$x]->getIdTema());
            $articulo->appendChild($idTema);
            $gusta = $xml->createElement("gusta", $ListOfArticulos[$x]->getGusta());
            $articulo->appendChild($gusta);
        }
        $xml->save("articulos.xml");
    }
}
