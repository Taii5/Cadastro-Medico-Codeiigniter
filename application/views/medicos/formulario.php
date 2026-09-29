<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?= $medico ? 'Editar Médico' : 'Novo Médico' ?></title>

	<link
    	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    	rel="stylesheet"
	>
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-4">
	<div class="container">
    	<span class="navbar-brand">
        	Cadastro de Médicos
    	</span>
	</div>
</nav>

<div class="container">

	<div class="card mx-auto" style="max-width: 800px;">

    	<div class="card-body p-4">

        	<h3 class="mb-4">
            	<?= $medico ? 'Editar médico' : 'Cadastrar médico' ?>
        	</h3>

        	<?php if (!empty($erro)): ?>
            	<div class="alert alert-danger">
                	<?= $erro ?>
            	</div>
        	<?php endif; ?>

        	<?php if (validation_errors()): ?>
            	<div class="alert alert-danger">
                	<?= validation_errors(); ?>
            	</div>
        	<?php endif; ?>

        	<?php
            	if ($medico) {
                	$action = site_url('medicos/atualizar/' . $medico->id);
            	} else {
                	$action = site_url('medicos/salvar');
            	}
        	?>

        	<form method="post" action="<?= $action ?>">

            	<div class="mb-3">
                	<label class="form-label">
                    	Nome completo *
                	</label>

                	<input
    type="text"
    name="nome_completo"
    class="form-control"
    value="<?= $medico ? html_escape($medico->nome_completo) : set_value('nome_completo'); ?>"
    minlength="3"
    maxlength="100"
    required
>
            	</div>

            	<div class="row">

                	<div class="col-md-6 mb-3">
                    	<label class="form-label">
                        	CRM *
                    	</label>

                    	<input
    type="text"
    name="crm"
    class="form-control"
    value="<?= $medico ? html_escape($medico->crm) : set_value('crm'); ?>"
    maxlength="20"
    required
>
                	</div>

                	<div class="col-md-6 mb-3">
                    	<label class="form-label">
                        	Especialidade *
                    	</label>
<input
    type="text"
    name="especialidade"
    class="form-control"
    value="<?= $medico ? html_escape($medico->especialidade) : set_value('especialidade'); ?>"
    minlength="3"
    maxlength="100"
    required
>
                	</div>

            	</div>

            	<div class="mb-3">
                	<label class="form-label">
                    	Telefone *
                	</label>

                	<input
    type="text"
    name="telefone"
    class="form-control"
    value="<?= $medico ? html_escape($medico->telefone) : set_value('telefone'); ?>"
    minlength="10"
    maxlength="20"
    required
>
            	</div>

            	<div class="mb-4">
                	<label class="form-label">
                    	E-mail *
                	</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="<?= $medico ? html_escape($medico->email) : set_value('email'); ?>"
                    maxlength="100"
                    required
                >
            	</div>

            	<div class="d-flex justify-content-end gap-2">

                	<a
                    	href="<?= site_url('medicos'); ?>"
                    	class="btn btn-secondary"
                	>
                    	Voltar
                	</a>

                	<button
                    	type="submit"
                    	class="btn btn-primary"
                	>
                    	<?= $medico ? 'Salvar alterações' : 'Cadastrar' ?>
                	</button>

            	</div>

        	</form>

    	</div>
	</div>

</div>

</body>
</html>
