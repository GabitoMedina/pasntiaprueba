<?php $__env->startSection('contenido'); ?>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Nueva Ingreso</h3>
			<?php if(count($errors)>0): ?>
			<div class="alert alert-danger">
				<ul>
					<?php foreach($errors->all() as $error): ?>
					<li><?php echo e($error); ?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?php endif; ?>
		</div>
	</div>

			<!-- <?php echo Form::open(array('url'=>'compras/ingreso','method'=>'POST','autocomplete'=>'off')); ?>

			<?php echo e(Form::token()); ?> -->
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="proveedor">Proveedor</label>
				
				
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label >Comprobante</label>
				<select name="tipo_comprobante" class="form-control">
					<option value="Boleta">Boleta</option>
					<option value="Factura">Factura</option>
					<option value="Ticket">Ticket</option>
				</select>
				
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="num_comprobante">Num Comprobante</label>
				<input type="text" name="num_comprobante"  value="<?php echo e(old('num_comprobante')); ?>" class="form-control" placeholder="Número Comprobante">
			</div>
		</div>
	</div>
		<div class="row">
			<div class="panel panel-primary">
				<div class="panel-body">
					<div class="col-lg-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label>Articulo</label>
							<select name="pidarticulo" class="form-control" id="pidarticulo">
								
							</select>

						</div>

					</div>
					
				</div>
			</div>
		</div>

				
	
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
			</div>
		

			<?php echo Form::close(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>