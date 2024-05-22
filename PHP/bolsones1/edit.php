<html>
<style>
    
body {
    margin:0;
    font-family: Arial;
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
    position: fixed;
    top: 0;
    width: 100%;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

li a:hover:not(.active) {
    background-color: #111;
    text-decoration: none;  
    color: #fff;
}

.active {
    background-color: #04AA6D;
    color: #fff;
    text-decoration: none;
}

.enviar {
    margin: 10px 0px 10px 0px;
    padding: 10px 30% 10px 30%;
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>
  

<head>
  <title>Problema</title>
</head>

<body>
<ul>
    <li><a class="active" href="apptabla.php">Tabla</a></li>
    <li><a href="insertar.php">Insertar</a></li>
    <li><a href="entregados.php">Bolsones entregados</a></li>
</ul>
  <?php    
  
  include("conexion.php");
  ob_start();

  
  $registros = mysqli_query($conexion, "select *
                                        from personas") or
    die("Problemas en el select:" . mysqli_error($conexion));
    ?>
  <div style="padding:20px;margin-top:30px;">
  Editar datos:
    <form class="p-4" method="post" action="editpro.php">
        <label class="form-label">Nombre: </label>
        <input type="text" class="form-control" name="nombre" value="<?php echo $_GET['nombre']; ?>" placeholder="<?php echo $_GET['nombre']; ?>">
        <label class="form-label">Apellido: </label>
        <input type="text" class="form-control" name="apellido" value="<?php echo $_GET['apellido']; ?>">
        <label class="form-label">DNI: </label>
        <input type="number" class="form-control" name="dni" value="<?php echo $_GET['dni']; ?>">
        <label class="form-label">Padre/Madre/Tutor: </label>
        <input type="text" class="form-control" name="padremadretutor" value="<?php echo $_GET['padremadretutor']; ?>">
        <label class="form-label">Division: </label>
        <input type="text" class="form-control" name="division" value="<?php echo $_GET['division']; ?>">
        <input type="hidden" name="idr" value=$_GET['id']>
        <input type="submit" class="btn btn-primary" value="editar">

        <br>
        <?php echo $_GET['id']; ?>
        
    </form>    
</div>

  <?php
  mysqli_close($conexion);
  ?>
</body>

</html>