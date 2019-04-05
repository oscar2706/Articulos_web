function modificaMeGusta(idUsuario, idArticulo, estadoPulsado, posicionBoton){
   if(estadoPulsado === "gusta"){
      console.log("Al usuario: " + idUsuario + ", Le gusta el articulo: " + idArticulo);
      //document.getElementById(posicionBoton+"gusta").className = "btn btn-primary";
   }
   else if(estadoPulsado === "noGusta"){
      console.log("Al usuario: " + idUsuario + ", No le gusta el articulo: " + idArticulo);
      //document.getElementById(posicionBoton+"noGusta").className = "btn btn-primary";
   }
   else
      console.log("Estado no reconocido");
}

function setMeGusta(idArticulo, usuario){
   console.log("Le gusta el articulo");
}

function cargaDocXML(rutaxml) {
   if (window.XMLHttpRequest) {
      xhttp = new XMLHttpRequest();
   }
   else {
      xhttp = new ActiveXObject("Microsoft.XMLHTTP");
   }
   xhttp.open("GET", rutaxml, true);
   xhttp.send();
   return xhttp.responseXML;
}