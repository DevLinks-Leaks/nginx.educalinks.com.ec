<div id="frm_ingresoCliente" class="form-medium" >
    <div class="form-group">
        <label for="tipoPersona_add">Tipo de persona</label>
        {combo_tipoPersona}
    </div>
    <div class="form-group">
        <label for="tipoIdentificacion_add">Tipo de identificacion</label>
        {combo_tipoIdentificacion}
    </div>
    <div class="form-group">
        <label for="num_identificacion_add">Numero Identificacion</label>
        <input type="text" class="form-control" name="num_identificacion_add" id="num_identificacion_add" placeholder="0999999999" required="required">
    </div>
    <div class="form-group"> 
        <label for="nombres_add">Nombres</label>
        <input type="text" class="form-control" name="nombres_add" id="nombres_add" placeholder="Juan Javier" required="required">
    </div>
    <div class="form-group">
        <label for="apellidos_add">Apellidos</label>
        <input type="text" class="form-control" name="apellidos_add" id="apellidos_add" placeholder="Piguave Jimenez" required="required">
    </div>
    <div class="form-group"> 
        <label for="direccion_add">Direccion</label>
        <input type="text" class="form-control" name="direccion_add" id="direccion_add" placeholder="Guayaquil, Barrio Cuba" required="required">
    </div>
    <div class="form-group"> 
        <label for="telefono_add">Telefono</label>
        <input type="text" class="form-control" name="telefono_add" id="telefono_add" placeholder="5555555555" required="required">
    </div>
    <div class="form-group">
        <label for="fecha_nacimiento_add">Fecha de Nacimiento</label>
        <input type="text" class="form-control" name="fecha_nacimiento_add" id="fecha_nacimiento_add" placeholder="dd/mm/yyyy" required="required">
    </div>
    <div class="form-group"> 
        <label for="email_add">Email</label>
        <input type="email" class="form-control" name="email_add" id="email_add" placeholder="jjpiguave@dominio.com" required="required">
    </div>
    <div class="form-group">
        <label for="estadoCivil_add">Estado civil</label>
        {combo_estadoCivil}
    </div>
</div>