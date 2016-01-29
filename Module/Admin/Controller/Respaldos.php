<?php

/**
 * LibreDTE
 * Copyright (C) SASCO SpA (https://sasco.cl)
 *
 * Este programa es software libre: usted puede redistribuirlo y/o
 * modificarlo bajo los términos de la Licencia Pública General GNU
 * publicada por la Fundación para el Software Libre, ya sea la versión
 * 3 de la Licencia, o (a su elección) cualquier versión posterior de la
 * misma.
 *
 * Este programa se distribuye con la esperanza de que sea útil, pero
 * SIN GARANTÍA ALGUNA; ni siquiera la garantía implícita
 * MERCANTIL o de APTITUD PARA UN PROPÓSITO DETERMINADO.
 * Consulte los detalles de la Licencia Pública General GNU para obtener
 * una información más detallada.
 *
 * Debería haber recibido una copia de la Licencia Pública General GNU
 * junto a este programa.
 * En caso contrario, consulte <http://www.gnu.org/licenses/gpl.html>.
 */

// namespace del controlador
namespace website\Dte\Admin;

/**
 * Clase exportar e importar datos de un contribuyente
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
 * @version 2016-01-29
 */
class Controller_Respaldos extends \Controller_App
{

    /**
     * Acción que permite exportar todos los datos de un contribuyente
     * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
     * @version 2016-01-29
     */
    public function exportar()
    {
        $Emisor = $this->getContribuyente();
        $Respaldo = new Model_Respaldo();
        $this->set([
            'Emisor' => $Emisor,
            'tablas' => $Respaldo->getTablas(),
        ]);
        if (isset($_POST['submit'])) {
            try {
                $dir = $Respaldo->generar($Emisor->rut, $_POST['tablas']);
                \sowerphp\general\Utility_File::compress(
                    $dir, ['format'=>'zip', 'delete'=>true]
                );
            } catch (\Exception $e) {
                \sowerphp\core\Model_Datasource_Session::message(
                    'No fue posible exportar los datos: '.$e->getMessage(), 'error'
                );
            }
        }
    }

}