<?phprequire_once 'inc/functions.php';require_once 'mod/header.php';//Extraemos los datos de configuración de xml/config.xml$xml = file_get_contents("xml/config.xml");$DOM = new DOMDocument('1.0', 'utf-8');$DOM->loadXML($xml);$config = $DOM->getElementsByTagName('SERVER_CONFIG')->item(0);$server = $config->getElementsByTagName("SERVER")->item(0)->nodeValue;$user = $config->getElementsByTagName("USER")->item(0)->nodeValue;$pass = $config->getElementsByTagName("PASS")->item(0)->nodeValue;$db = $config->getElementsByTagName("DB")->item(0)->nodeValue;//VARIABLES DE PATH $urlNow = "http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'];$pathFolder = dirname($urlNow);# Establecer la conexión a la Base de Datos$conexion = mysqli_connect($server, $user, $pass, $db);# Consulta SQL que devuelve los nombres de las tablas de la Base de Datos$tablas = mysqli_query($conexion,'SHOW TABLES') or die('Imposible mostrar tablas');if(!isset($_GET["t"])){    echo '<table class="table table-striped table-bordered table-condensed" cellpadding="0" cellspacing="0">            <thead>                <th>Table Name</th>                <th>API Link</th>                <th>View Table</th>                <th>Advance Results</th>            </thead>        <tbody>';    while($tabla = mysqli_fetch_row($tablas)) {    $nombreTabla = $tabla[0];            echo '<tr>';        echo '<td>';        echo "<a href='?t=".$nombreTabla."'>".$nombreTabla."</a>";        echo '</td>';        echo '<td>';        $urlJson = $pathFolder."/getData.php?f=json&t=".$nombreTabla;        echo '<a href="'.$urlJson.'">';        echo $urlJson;        echo '</a>';        echo '</td>';        echo '<td>';        $urlJson = $pathFolder."/getData.php?f=table&t=".$nombreTabla;        echo '<a href="'.$urlJson.'">';        echo "Show ".$nombreTabla;        echo '</a>';        echo '</td>';        echo '<td>';        $urlJson = $pathFolder."/advance.php?t=".$nombreTabla;        echo '<a href="'.$urlJson.'">';        echo "Advance Result of ".$nombreTabla;        echo '</a>';        echo '</td>';        echo '</tr>';    }     echo '</tbody></table><br />';}else{    while($tabla = mysqli_fetch_row($tablas)) {        $nombreTabla = $tabla[0];        if($nombreTabla==$_GET["t"]){    	            echo '<h3>Tabla: '.$nombreTabla.'</h3>';            # Consulta SQL que devuelve los campos de cada tabla            $campos = mysqli_query($conexion,'SHOW COLUMNS FROM '.$nombreTabla) or die('Imposible mostrar campos de '.$nombreTabla);            //Número de campos            $num_campos = $campos -> num_rows;            $count = 0;                        # Muestra como tabla HTML los detalles de los campos de la tabla correspondiente            if(mysqli_num_rows($campos)) {                    echo '<form>';                    echo '<table class="table table-striped table-bordered table-condensed" cellpadding="0" cellspacing="0">                            <thead>                                <th>Campo</th>                                <th>API Link</th>                                <th>View Table</th>                                <th>Select</th>                                <th>Advance Results</th>                            </thead><tbody>';                    while($detalles = mysqli_fetch_row($campos)) {                            echo '<tr>';                            echo '<td>';                            echo $detalles[0];                            echo '</td>';                            echo '<td>';                            $urlJson = $pathFolder."/getData.php?f=json&t=".$nombreTabla."&c=".$detalles[0];                            echo '<a href="'.$urlJson.'">';                            echo $urlJson;                            echo '</a>';                            echo '</td>';                            echo '<td>';                            $urlJson = $pathFolder."/getData.php?f=table&t=".$nombreTabla."&c=".$detalles[0];                            echo '<a href="'.$urlJson.'">';                            echo "Show ".$detalles[0];                            echo '</a>';                            echo '</td>';                            echo '<td>';                            echo '<input id="cbc'.$count.'" type="checkbox" value='.$detalles[0].' onchange="customSelect('.$num_campos.')">';                            echo '</td>';                            echo '<td>';                            $urlJson = $pathFolder."/advance.php?t=".$nombreTabla."&c=".$detalles[0];                            echo '<a href="'.$urlJson.'">';                            echo "Advance Result of ".$detalles[0];                            echo '</a>';                            echo '</td>';                            echo '</tr>';                            $count++;                    }                    echo '</tbody></table><br />';                           echo '</form>';                                }        }    }}#Cerrar la conexión a la Base de Datosmysqli_close($conexion);if(isset($_GET["t"])){    $urlJson = $pathFolder."/getData.php?f=json&t=".$_GET["t"];    $viewTable = $pathFolder."/getData.php?f=table&t=".$_GET["t"];    $advance = $pathFolder."/advance.php?t=".$_GET["t"];   ?>    <table id="customTable" class="table table-striped table-bordered table-condensed" cellpadding="0" cellspacing="0">            <thead>                <th>Table</th>                <th>Select Fields</th>                <th>API Link</th>                <th>View Table</th>                <th>Advance</th>            </thead><tbody>'        <tr>                   <td>                <?php                    //TABLA                    echo $_GET["t"];                ?>            </td>            <td>                <!--CAMPOS-->                <div id ="campos">                </div>            </td>            <td>                             <a target= "_blank" id="camp_link"><span id="camp"></span></a>            </td>            <td>                <!--Table-->                <a target= "_blank" id="table_link">Show Custom Table</span></a>            </td>            <td>                <!--Table-->                <a target= "_blank" id="advance_link">Advance Custom Results</span></a>            </td>        </tr>    </table>    <?php //cerrar isset } require_once 'mod/footer.php';?>