<div class="navegador draggable">
    <div class="navegador-header drag-header">NAVEGADOR DE SALAS</div>
    <div class="navegador-body">
        No hay salas
    </div>
</div>
<script>
    $(document).ready(function() {
       $( ".draggable" ).draggable({ containment: "body", scroll: false, handle: ".drag-header" });
    });
</script>