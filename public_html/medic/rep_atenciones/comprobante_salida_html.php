<style>
    .contenedor_impr{
        border-top: 1px solid black;
        border-left: 1px solid black;
        border-bottom: 1px solid black;
        border-right: 1px solid black;
        height: 300px;
    }
    table{
        background-color: white;
    }
    body{
        margin-top: 0px;
        padding-top: 0px;
        margin-bottom: 0px;
        padding-bottom: 0px;
        margin-left: 0px;
        padding-left: 0px;
        margin-right: 0px;
        padding-right: 0px;
    }
</style>
<div class="container-fluid theme-showcase" role="main">
    <div class="contenedor_impr">
        <table border="0" cell-padding="0" cellspaciong="0">
            <tr>
                <td>{logoInstitucion}</td>
                <td  style="text-align: right"><h5>Permiso de Salida</h5></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td style="text-align: right">No. {codigo_atencion}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td style="text-align: right">Guayaquil, {fecha_atencion}</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td style="text-align: right">REG.3.3.5.02</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td style="text-align: right">Certificado médico</td>
            </tr>
            <tr>
                <td colspan="2"><hr/></td>
            </tr>
            <tr>
                <td colspan="2">Nombre: {nombre_alumno}</td>
            </tr>
            <tr>
                <td>Curso: {curso_deta}</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Descripción: {enfe_descripcion}</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Observación: {aten_observacion}</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr><tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
</div><!-- /container -->