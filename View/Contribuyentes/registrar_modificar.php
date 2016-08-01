<h1><?=$titulo?></h1>
<p><?=$descripcion?></p>

<?php
$f = new \sowerphp\general\View_Helper_Form();
echo $f->begin(['id'=>$form_id, 'onsubmit'=>'Form.check() && Form.checkSend()']);
?>

<script type="text/javascript">
var impuestos_adicionales_tasa = <?=json_encode($impuestos_adicionales_tasa)?>;
$(function() {
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
    }
});
</script>

<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#datos" aria-controls="datos" role="tab" data-toggle="tab">Empresa</a></li>
        <li role="presentation"><a href="#ambientes" aria-controls="ambientes" role="tab" data-toggle="tab">Ambientes</a></li>
        <li role="presentation"><a href="#correos" aria-controls="correos" role="tab" data-toggle="tab">Correos</a></li>
        <li role="presentation"><a href="#facturacion" aria-controls="facturacion" role="tab" data-toggle="tab">Facturación</a></li>
        <li role="presentation"><a href="#contabilidad" aria-controls="contabilidad" role="tab" data-toggle="tab">Contabilidad</a></li>
        <li role="presentation"><a href="#api" aria-controls="api" role="tab" data-toggle="tab">API</a></li>
        <li role="presentation"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>
    </ul>
    <div class="tab-content">

<!-- INICIO DATOS EMPRESA -->
<div role="tabpanel" class="tab-pane active" id="datos">
<?php
if ($form_id=='registrarContribuyente') {
    echo $f->input([
        'name' => 'rut',
        'label' => 'RUT',
        'check' => 'notempty rut',
        'attr' => 'maxlength="12" onblur="Contribuyente.setDatos(\'registrarContribuyente\')"',
    ]);
}
echo $f->input([
    'name' => 'razon_social',
    'label' => 'Razón social',
    'value' => isset($Contribuyente) ? $Contribuyente->razon_social : null,
    'check' => 'notempty',
    'attr' => 'maxlength="100"',
]);
echo $f->input([
    'name' => 'config_extra_nombre_fantasia',
    'label' => 'Nombre fantasía',
    'value' => isset($Contribuyente) ? $Contribuyente->config_extra_nombre_fantasia : null,
    'attr' => 'maxlength="100"',
]);
echo $f->input([
    'type' => 'select',
    'name' => 'actividad_economica',
    'label' => 'Actividad principal',
    'value' => isset($Contribuyente) ? $Contribuyente->actividad_economica : null,
    'help' => 'Indique la actividad económica principal de la empresa',
    'options' => [''=>'Seleccionar una actividad económica'] + $actividades_economicas,
    'check' => 'notempty',
    'attr'=>'onchange="document.getElementById(\'giroField\').value = this.options[this.selectedIndex].text.substr(this.options[this.selectedIndex].text.indexOf(\'-\')+2, 80)"',
]);
echo $f->input([
    'name' => 'giro',
    'label' => 'Giro',
    'value' => isset($Contribuyente) ? $Contribuyente->giro : null,
    'check' => 'notempty',
    'attr' => 'maxlength="80"',
]);
$config_extra_otras_actividades = [];
if (isset($Contribuyente) and $Contribuyente->config_extra_otras_actividades) {
    foreach ($Contribuyente->config_extra_otras_actividades as $a) {
        $config_extra_otras_actividades[] = ['config_extra_otras_actividades'=>$a];
    }
}
echo $f->input([
    'type' => 'js',
    'id' => 'otras_actividades',
    'label' => 'Otras actividades',
    'titles' => ['Actividad económica'],
    'inputs' => [
        [
            'type' => 'select',
            'name' => 'config_extra_otras_actividades',
            'options' => [''=>'Seleccionar una actividad económica'] + $actividades_economicas,
            'check' => 'notempty',
        ]
    ],
    'values' => $config_extra_otras_actividades,
    'help' => 'Indique las actividades económicas secundarias de la empresa',
]);
echo $f->input([
    'name' => 'direccion',
    'label' => 'Dirección',
    'value' => isset($Contribuyente) ? $Contribuyente->direccion : null,
    'help' => 'Dirección casa matriz',
    'check' => 'notempty',
    'attr' => 'maxlength="70"',
]);
echo $f->input([
    'type' => 'select',
    'name' => 'comuna',
    'label' => 'Comuna',
    'value' => isset($Contribuyente) ? $Contribuyente->comuna : null,
    'help' => 'Comuna casa matriz',
    'options' => [''=>'Seleccionar una comuna'] + $comunas,
    'check' => 'notempty',
]);
$config_extra_sucursales = [];
if (isset($Contribuyente) and $Contribuyente->config_extra_sucursales) {
    foreach ($Contribuyente->config_extra_sucursales as $sucursal) {
        $config_extra_sucursales[] = [
            'config_extra_sucursales_codigo' => $sucursal->codigo,
            'config_extra_sucursales_sucursal' => $sucursal->sucursal,
            'config_extra_sucursales_direccion' => $sucursal->direccion,
            'config_extra_sucursales_comuna' => $sucursal->comuna,
        ];
    }
}
echo $f->input([
    'type' => 'js',
    'id' => 'sucursales',
    'label' => 'Sucursales',
    'titles' => ['Código SII', 'Nombre', 'Dirección', 'Comuna'],
    'inputs' => [
        [
            'name' => 'config_extra_sucursales_codigo',
            'check' => 'notempty integer',
        ],
        [
            'name' => 'config_extra_sucursales_sucursal',
            'check' => 'notempty',
            'attr' => 'maxlength="20"',
        ],
        [
            'name' => 'config_extra_sucursales_direccion',
            'check' => 'notempty',
            'attr' => 'maxlength="70"',
        ],
        [
            'type' => 'select',
            'name' => 'config_extra_sucursales_comuna',
            'options' => [''=>'Seleccionar una comuna'] + $comunas,
            'check' => 'notempty',
        ]
    ],
    'values' => $config_extra_sucursales,
    'help' => 'Sucursales de la empresa con código asignado por el SII',
]);
echo $f->input([
    'name' => 'telefono',
    'label' => 'Teléfono',
    'value' => isset($Contribuyente) ? $Contribuyente->telefono : null,
    'placeholder' => '+56 9 88776655',
    'help' => 'Ejemplos: celular +56 9 88776655 / Santiago +56 2 22334455 / Santa Cruz +56 72 2821122',
    'check' => 'telephone',
    'attr' => 'maxlength="20"',
]);
echo $f->input([
    'name' => 'email',
    'label' => 'Email',
    'value' => isset($Contribuyente) ? $Contribuyente->email : null,
    'check' => 'email',
    'attr' => 'maxlength="80"',
]);
echo $f->input([
    'name' => 'config_extra_representante_rut',
    'label' => 'RUT representante',
    'value' => isset($Contribuyente) ? $Contribuyente->config_extra_representante_rut : null,
    'check' => 'rut',
]);
echo $f->input([
    'name' => 'config_extra_contador_rut',
    'label' => 'RUT contador',
    'value' => isset($Contribuyente) ? $Contribuyente->config_extra_contador_rut : null,
    'check' => 'rut',
]);
echo $f->input([
    'name' => 'config_extra_web',
    'label' => 'Web',
    'value' => isset($Contribuyente) ? $Contribuyente->config_extra_web : null,
    'attr' => 'maxlength="80"',
]);
echo $f->input([
    'type' => 'file',
    'name' => 'logo',
    'label' => 'Logo',
    'help' => 'Imagen en formato PNG con el logo de la empresa',
    'attr' => 'accept="image/png"',
]);
?>
<?php if (isset($Contribuyente)) : ?>
    <img src="../logo/<?=$Contribuyente->rut?>.png" alt="Logo <?=$Contribuyente->razon_social?>" class="responsive thumbnail center" />
<?php endif; ?>
</div>
<!-- FIN DATOS EMPRESA -->

<!-- INICIO AMBIENTES -->
<div role="tabpanel" class="tab-pane" id="ambientes">
<?php
echo $f->input([
    'type' => 'select',
    'name' => 'config_ambiente_en_certificacion',
    'label' => 'Ambiente',
    'options' => ['Producción', 'Certificación'],
    'value' => isset($Contribuyente) ? $Contribuyente->config_ambiente_en_certificacion : 1,
    'help' => 'Si está seleccionado el sistema funcionará en ambiente de certificación',
    'check' => 'notempty',
    'attr' => 'onchange="ambiente_set(this.value)"',
]);
echo $f->input([
    'type' => 'date',
    'name' => 'config_ambiente_produccion_fecha',
    'label' => 'Fecha resolución',
    'value' => isset($Contribuyente) ? $Contribuyente->config_ambiente_produccion_fecha : null,
    'help' => 'Fecha de la resolución que autoriza la emisión de DTE en ambiente de producción',
    'check' => 'notempty date',
    'attr' => isset($Contribuyente) ? ($Contribuyente->config_ambiente_en_certificacion?'disabled="disabled"':'') : 'disabled="disabled"',
]);
echo $f->input([
    'name' => 'config_ambiente_produccion_numero',
    'label' => 'Número resolución',
    'value' => isset($Contribuyente) ? $Contribuyente->config_ambiente_produccion_numero : null,
    'help' => 'Número de la resolución que autoriza la emisión de DTE en ambiente de producción',
    'check' => 'notempty integer',
    'attr' => isset($Contribuyente) ? ($Contribuyente->config_ambiente_en_certificacion?'disabled="disabled"':'') : 'disabled="disabled"',
]);
echo $f->input([
    'type' => 'date',
    'name' => 'config_ambiente_certificacion_fecha',
    'label' => 'Fecha certificación',
    'value' => isset($Contribuyente) ? $Contribuyente->config_ambiente_certificacion_fecha : null,
    'help' => 'Fecha de la autorización para emisión de DTE en ambiente de certificación',
    'check' => 'notempty date',
    'attr' => isset($Contribuyente) ? ($Contribuyente->config_ambiente_en_certificacion?'':'disabled="disabled"') : '',
]);
?>
</div>
<!-- FIN AMBIENTES -->

<!-- INICIO EMAILS -->
<div role="tabpanel" class="tab-pane" id="correos">
    <p>Aquí debe configurar las dos casillas de correo para operar con facturación electrónica. Puede revisar la <a href="http://wiki.libredte.cl/doku.php/faq/libredte/sowerphp/config/email">documentación de las casillas de correo</a> para obtener detalles de qué opciones debe usar.</p>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-envelope"></i>
                    Correo contacto SII
                </div>
                <div class="panel-body">
<?php
$f->setColsLabel(3);
echo $f->input([
    'name' => 'config_email_sii_user',
    'label' => 'Correo',
    'check' => 'email',
    'value' => isset($Contribuyente) ? $Contribuyente->config_email_sii_user : null,
    'attr' => 'maxlength="50" onblur="config_email_set(this, \'sii\')"',
    'check' => 'notempty email',
]);
echo $f->input([
    'name' => 'config_email_sii_pass',
    'value' => isset($Contribuyente) ? $Contribuyente->config_email_sii_pass : null,
    'label' => 'Contraseña',
    'check' => 'notempty',
]);
echo $f->input([
    'name' => 'config_email_sii_smtp',
    'label' => 'Servidor SMTP',
    'value' => isset($Contribuyente) ? $Contribuyente->config_email_sii_smtp : null,
    'help' => 'Ejemplo: ssl://smtp.gmail.com:465',
    'attr' => 'maxlength="50"',
    'check' => 'notempty',
]);
echo $f->input([
    'name' => 'config_email_sii_imap',
    'label' => 'Mailbox IMAP',
    'value' => isset($Contribuyente) ? $Contribuyente->config_email_sii_imap : null,
    'help' => 'Ejemplo: {imap.gmail.com:993/imap/ssl}INBOX',
    'attr' => 'maxlength="100"',
    'check' => 'notempty',
]);
?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-envelope-o"></i>
                    Correo contacto empresas (intercambio)
                </div>
                <div class="panel-body">
<?php
echo $f->input([
    'name' => 'config_email_intercambio_user',
    'label' => 'Correo',
    'check' => 'email',
    'value' => isset($Contribuyente) ? $Contribuyente->config_email_intercambio_user : null,
    'attr' => 'maxlength="50" onblur="config_email_set(this, \'intercambio\')"',
    'check' => 'notempty email',
]);
echo $f->input([
    'name' => 'config_email_intercambio_pass',
    'value' => isset($Contribuyente) ? $Contribuyente->config_email_intercambio_pass : null,
    'label' => 'Contraseña',
    'check' => 'notempty',
]);
echo $f->input([
    'name' => 'config_email_intercambio_smtp',
    'label' => 'Servidor SMTP',
    'value' => isset($Contribuyente) ? $Contribuyente->config_email_intercambio_smtp : null,
    'help' => 'Ejemplo: ssl://smtp.gmail.com:465',
    'attr' => 'maxlength="50"',
    'check' => 'notempty',
]);
echo $f->input([
    'name' => 'config_email_intercambio_imap',
    'label' => 'Mailbox IMAP',
    'value' => isset($Contribuyente) ? $Contribuyente->config_email_intercambio_imap : null,
    'help' => 'Ejemplo: {imap.gmail.com:993/imap/ssl}INBOX',
    'attr' => 'maxlength="100"',
    'check' => 'notempty',
]);
$f->setColsLabel();
?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN EMAILS -->

<!-- INICIO CONFIGURACIÓN FACTURACIÓN -->
<div role="tabpanel" class="tab-pane" id="facturacion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-send-o"></i>
            Emisión DTE
        </div>
        <div class="panel-body">
<?php
echo $f->input([
    'type' => 'select',
    'name' => 'config_sii_envio_automatico',
    'label' => 'Envío automático',
    'options' => ['No', 'Si'],
    'value' => isset($Contribuyente) ? $Contribuyente->config_sii_envio_automatico : 0,
    'help' => '¿Se deben enviar automáticamente los DTE al SII sin pasar por previsualización?',
]);
echo $f->input([
    'type' => 'select',
    'name' => 'config_extra_exenta',
    'label' => 'Empresa exenta',
    'options' => ['No', 'Si'],
    'value' => isset($Contribuyente) ? $Contribuyente->config_extra_exenta : 0,
    'help' => '¿El contribuyente es exento de IVA en todas sus actividades económicas?',
]);
echo $f->input([
    'type' => 'select',
    'name' => 'config_extra_indicador_servicio',
    'label' => 'Indicador servicio',
    'options' => [''=>'No', 4=>'Servicios de hotelería'],
    'value' => isset($Contribuyente) ? $Contribuyente->config_extra_indicador_servicio : 0,
    'help' => '¿Se debe usar un indicador de servicio por defecto?',
]);
/*echo $f->input([
    'type' => 'select',
    'name' => 'config_extra_constructora',
    'label' => 'Empresa constructora',
    'options' => ['No', 'Si'],
    'value' => isset($Contribuyente) ? $Contribuyente->config_extra_constructora : 0,
    'help' => '¿El contribuyente es una empresa constructora (para crédito del 65%)?',
]);*/
echo $f->input([
    'type' => 'select',
    'name' => 'config_extra_agente_retenedor',
    'label' => 'Agente retenedor',
    'options' => ['No', 'Si'],
    'value' => isset($Contribuyente) ? $Contribuyente->config_extra_agente_retenedor : 0,
    'help' => '¿El contribuyente actúa como agente retenedor de algún producto?',
]);
$config_extra_impuestos_adicionales = [];
if (isset($Contribuyente) and $Contribuyente->config_extra_impuestos_adicionales) {
    foreach ($Contribuyente->config_extra_impuestos_adicionales as $impuesto) {
        $config_extra_impuestos_adicionales[] = [
            'config_extra_impuestos_adicionales_codigo' => $impuesto->codigo,
            'config_extra_impuestos_adicionales_tasa' => $impuesto->tasa,
        ];
    }
}
echo $f->input([
    'type' => 'js',
    'id' => 'impuestos_adicionales',
    'label' => 'Impuestos adicionales',
    'titles' => ['Impuesto adicional', 'Tasa por defecto'],
    'inputs' => [
        [
            'type' => 'select',
            'name' => 'config_extra_impuestos_adicionales_codigo',
            'options' => [''=>'Seleccionar un impuesto adicional'] + $impuestos_adicionales,
            'check' => 'notempty',
            'attr' => 'onblur="impuesto_adicional_sugerir_tasa(this, impuestos_adicionales_tasa)"'
        ],
        [
            'name' => 'config_extra_impuestos_adicionales_tasa',
            'check' => 'notempty',
        ]
    ],
    'values' => $config_extra_impuestos_adicionales,
    'help' => 'Indique los impuestos adicionales o retenciones que desea utilizar en la emisión de documentos',
]);
if (!empty($tipos_dte)) {
    echo $f->input([
        'type' => 'select',
        'name' => 'config_emision_dte_defecto',
        'label' => 'DTE defecto',
        'options' => $tipos_dte,
        'value' => isset($Contribuyente) ? $Contribuyente->config_emision_dte_defecto : 33,
        'help' => '¿Qué documento debe estar seleccionado por defecto al emitir?',
    ]);
    $config_emision_observaciones = [];
    if (isset($Contribuyente) and $Contribuyente->config_emision_observaciones) {
        foreach ($Contribuyente->config_emision_observaciones as $dte => $glosa) {
            $config_emision_observaciones[] = [
                'config_emision_observaciones_dte' => $dte,
                'config_emision_observaciones_glosa' => $glosa,
            ];
        }
    }
    echo $f->input([
        'type' => 'js',
        'id' => 'config_emision_observaciones',
        'label' => 'Observación emisión',
        'titles' => ['Documento', 'Observación'],
        'inputs' => [
            [
                'type' => 'select',
                'name' => 'config_emision_observaciones_dte',
                'options' => [''=>'Seleccionar un tipo de documento'] + $tipos_dte,
                'check' => 'notempty',
            ],
            [
                'name' => 'config_emision_observaciones_glosa',
                'check' => 'notempty',
                'attr' => 'maxlength="100"',
            ]
        ],
        'values' => $config_emision_observaciones,
        'help' => 'Observación por defecto según tipo de DTE emitido',
    ]);
}
?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-file-pdf-o"></i>
            PDF
        </div>
        <div class="panel-body">
<?php
echo $f->input([
    'type' => 'select',
    'name' => 'config_pdf_dte_papel',
    'label' => 'Papel PDF',
    'options' => \sasco\LibreDTE\Sii\PDF\Dte::$papel,
    'value' => isset($Contribuyente) ? $Contribuyente->config_pdf_dte_papel : 0,
    'help' => 'Permite indicar si se usará hoja carta en las versiones en PDF del DTE o bien papel contínuo',
]);
echo $f->input([
    'type' => 'select',
    'name' => 'config_pdf_dte_cedible',
    'label' => 'Incluir cedible',
    'options' => ['No', 'Si'],
    'value' => isset($Contribuyente) ? $Contribuyente->config_pdf_dte_cedible : 0,
    'help' => '¿Se debe incluir la copia cedible por defecto en los PDF?',
]);
echo $f->input([
    'name' => 'config_pdf_copias_tributarias',
    'label' => 'Copias tributarias',
    'value' => isset($Contribuyente) ? $Contribuyente->config_pdf_copias_tributarias : 1,
    'help' => '¿Copias tributarias que saldrán por defecto en la pestaña PDF?',
    'check' => 'notempty integer',
]);
echo $f->input([
    'name' => 'config_pdf_copias_cedibles',
    'label' => 'Copias cedibles',
    'value' => isset($Contribuyente) ? $Contribuyente->config_pdf_copias_cedibles : 1,
    'help' => '¿Copias cedibles que saldrán por defecto en la pestaña PDF?',
    'check' => 'notempty integer',
]);
?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-eye"></i>
            SII
        </div>
        <div class="panel-body">
<?php
echo $f->input([
    'type' => 'select',
    'name' => 'config_sii_estado_dte_webservice',
    'label' => 'Estado DTE',
    'options' => ['Correo electrónico (más lento pero con detalles)', 'Servicio web (más rápido pero sin detalles)'],
    'value' => isset($Contribuyente) ? $Contribuyente->config_sii_estado_dte_webservice : 0,
    'help' => 'Permite definir cómo se consultará el estado de los DTE emitidos por defecto en la aplicación web',
]);
?>
        </div>
    </div>
</div>
<!-- FIN CONFIGURACIÓN FACTURACIÓN -->

<!-- INICIO CONTABILIDAD -->
<div role="tabpanel" class="tab-pane" id="contabilidad">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-dollar"></i>
            Formulario 29
        </div>
        <div class="panel-body">
<?php
echo $f->input([
    'name' => 'config_contabilidad_ppm',
    'label' => 'Porcentaje PPM',
    'value' => isset($Contribuyente) ? (float)$Contribuyente->config_contabilidad_ppm : 0,
    'help' => 'Porcentaje que se pagará mensualmente como PPM obligatorio',
    'check' => 'notempty real',
]);
?>
        </div>
    </div>
</div>
<!-- FIN CONTABILIDAD -->

<!-- INICIO API -->
<div role="tabpanel" class="tab-pane" id="api">
    <p>LibreDTE puede comunicarse con la aplicación web de su empresa a través de servicios web. A continuación puede ingresar las URL para diferentes consultas que LibreDTE debería poder hacer a su aplicación. Puede revisar la <a href="http://wiki.libredte.cl/doku.php/sowerphp/integracion">documentación de la integración</a> para obtener detalles de las salidas esperadas para cada consulta.</p>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-key"></i>
            Autenticación
        </div>
        <div class="panel-body">
<?php
echo $f->input([
    'name' => 'config_api_auth_user',
    'label' => 'Usuario o token',
    'value' => isset($Contribuyente) ? $Contribuyente->config_api_auth_user : null,
    'help' => 'Usuario o token opcional para autenticación a través de <em>HTTP Basic Auth</em>',
    'attr' => 'maxlength="255"',
]);
echo $f->input([
    'name' => 'config_api_auth_pass',
    'label' => 'Contraseña',
    'value' => isset($Contribuyente) ? $Contribuyente->config_api_auth_pass : null,
    'help' => 'Si no se especifíca la contraseña se enviará al servicio web el usuario/token y una X como contraseña',
    'attr' => 'maxlength="255"',
]);
?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-list-alt"></i>
            Recursos
        </div>
        <div class="panel-body">
<?php
echo $f->input([
    'name' => 'config_api_url_items',
    'label' => 'Items',
    'value' => isset($Contribuyente) ? $Contribuyente->config_api_url_items : null,
    'help' => 'URL para consultar por GET los items a través de su código. Ejemplos: https://example.com/api/items/ o https://example.com/api/items?codigo=',
    'attr' => 'maxlength="255"',
]);
?>
        </div>
    </div>
</div>
<!-- FIN API -->

<!-- INICIO CONFIGURACIÓN GENERAL -->
<div role="tabpanel" class="tab-pane" id="general">
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-cogs"></i>
            Soporte
        </div>
        <div class="panel-body">
<?php
echo $f->input([
    'type' => 'select',
    'name' => 'config_app_soporte',
    'label' => 'Permitir soporte',
    'options' => ['No', 'Si'],
    'value' => isset($Contribuyente) ? $Contribuyente->config_app_soporte : 0,
    'help' => 'Se permite al equipo de soporte de LibreDTE trabajar con el contribuyente',
]);
?>
        </div>
    </div>
</div>
<!-- FIN CONFIGURACIÓN GENERAL -->

    </div>
</div>

<?php
echo $f->end($boton);
