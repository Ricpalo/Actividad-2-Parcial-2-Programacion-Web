<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <title>Diagnosticos</title>
  </head>
  <body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">SW17</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=site_url('pacientes')?>">Pacientes</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Diagnósticos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=site_url('medicaciones')?>">Medicación</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=site_url('tratamientos')?>">Tratamientos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=site_url('visitas')?>">Visitas</a>
                </li>
			</ul>
		</div>
	</nav>

	<div class="container-fluid">
        <div class="row mt-2">
            <div class="col-12">
                <form action="<?=site_url('diagnosticos/registrar_diagnostico/'.@$diagnostico_seleccionado->id_diagnostico);?>" method="post">
                    <div class="row">
                        <div class="col-4 form-group">
                            <label for="text">Texto del diagnostico:</label>
                            <input type="text" class="form-control" name="text" value="<?=@$diagnostico_seleccionado->text_diagnostico;?>">
                            <small class="help-text text-danger"><?=@$this->session->flashdata('errores')['text'];?></small>
                        </div>

                        <div class="col-4 form-group">
                            <label for="fecha">Fecha del Diagnostico:</label>
                            <input type="date" class="form-control" name="fecha" value="<?=@$diagnostico_seleccionado->fecha_diagnostico;?>">
                            <small class="help-text text-danger"><?=@$this->session->flashdata('errores')['fecha'];?></small>
                        </div>

                        <div class="col-4 form-group">
                            <label for="diagnostico">Diagnosticado Por:</label>
                            <input type="text" class="form-control" name="diagnostico" value="<?=@$diagnostico_seleccionado->diagnostico_por;?>">
                            <small class="help-text text-danger"><?=@$this->session->flashdata('errores')['diagnostico'];?></small>
                        </div>

                        <div class="col-4 form-group">
                            <label for="paciente">Paciente</label>
                            <select name="paciente" class="form-control">
                                <option value="" selected disabled>--Selecciona una opcion--</option>
                                <?php foreach ($pacientes as $paciente){ ?>
                                    <option value="<?=$paciente->id_paciente;?>" <?=@$diagnostico_seleccionado->fk_paciente == $paciente->id_paciente ? 'selected' : '';?>><?=$paciente->nombre_paciente;?></option>
                                <?php } ?>
                            </select>
                            <small class="help-text text-danger"><?=@$this->session->flashdata('errores')['paciente'];?></small>
                        </div>
                    </div>
                    <?php if(@$diagnostico_seleccionado) { ?>
                        <a href="<?=site_url('diagnosticos/borrar_diagnostico/'.$diagnostico_seleccionado->id_diagnostico)?>" class="btn btn-danger">Borrar</a>
                    <?php } ?>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
                <table id="table_diagnosticos" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Texto</th>
                            <th>Fecha de Diagnotico</th>
                            <th>Diagnosticado Por</th>
                            <th>Paciente</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($diagnosticos as $diagnostico) { ?>
                            <tr>
                                <td><?=$diagnostico->text_diagnostico;?></td>
                                <td><?=$diagnostico->fecha_diagnostico;?></td>
                                <td><?=$diagnostico->diagnostico_por;?></td>
                                <td><?=$diagnostico->nombre_paciente;?></td>
                                <td>
                                    <a href="<?=site_url('diagnosticos/ver_detalle/'.$diagnostico->id_diagnostico);?>" class="btn btn-info">Ver detalle</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
	</div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src=""></script>
    <!-- https://code.jquery.com/jquery-3.5.1.js -->
  </body>
  <script>
    $(function(){
        $('#table_diagnosticos').DataTable();
    });
  </script>
</html>