<h1>Mantenedor de folios DTE <?=$DteFolio->dte?></h1>

<script type="text/javascript">
$(function() {
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
    }
});
</script>

<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#caf" aria-controls="caf" role="tab" data-toggle="tab">Archivos CAF</a></li>
    </ul>
    <div class="tab-content">

<!-- INICIO ARCHIVOS CAF -->
<div role="tabpanel" class="tab-pane active" id="caf">
<?php
$cafs = $DteFolio->getCafs();
foreach ($cafs as &$caf) {
    $caf[] = '<a href="../xml/'.$DteFolio->dte.'/'.$caf['desde'].'" title="Descargar CAF que inicia en '.$caf['desde'].' del DTE '.$DteFolio->dte.'"><span class="fa fa-download btn btn-default"></span></a>';
}
array_unshift($cafs, ['Desde', 'Hasta', 'Descargar']);
new \sowerphp\general\View_Helper_Table($cafs);
?>
</div>
<!-- FIN ARCHIVOS CAF -->

    </div>
</div>

<div style="float:right;margin-bottom:1em;font-size:0.8em">
    <a href="<?=$_base?>/dte/admin/dte_folios">Volver al mantenedor de folios</a>
</div>
