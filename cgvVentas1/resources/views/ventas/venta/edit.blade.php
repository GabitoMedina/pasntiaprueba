@extends ('layouts.admin')
@section ('contenido')
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Editar Proveedor: {{ $persona->nombre }}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>

			{!!Form::model($persona,['method'=>'PATCH','route'=>['compras.proveedor.update',$persona->idpersona]])!!}
			{{Form::token()}}
		<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" required value="{{$persona->nombre}}" class="form-control" placeholder="Nombre">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="direccion">Dirección</label>
				<input type="text" name="direccion" value="{{$persona->direccion}}" class="form-control" placeholder="Dirección">
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="tipo_documento">Documento</label>
				<select name="tipo_documento" class="form-control">
					@if ($persona->tipo_documento=='CI')
					<option value="CI" selected>CI</option>
					<option value="RUC">RUC</option>
					@else
					<option value="CI" >CI</option>
					<option value="RUC" selected>RUC</option>
					@endif
				</select>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="num_documento">Número Documento</label>
				<input type="text" name="num_documento"  value="{{$persona->num_documento}}" class="form-control" placeholder="Número del documento">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="telefono">Teléfono</label>
				<input type="text" name="telefono" value="{{$persona->telefono}}" class="form-control" placeholder="Teléfono">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" name="email" value="{{$persona->email}}" class="form-control" placeholder="Email">
			</div>
		</div>
	
		<dir class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
	</div>
			{!!Form::close()!!}

@endsection