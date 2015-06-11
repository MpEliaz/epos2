<div class="col-md-6">
    <div class="form-group">
        {!!Form::label('codigo_descuento', 'Codigo',['class' => 'col-md-4'])!!}
        <div class="col-sm-8">
            {!!Form::text('codigo_descuento', null, ['class' => 'form-control', 'placeholder' => 'Codigo de descuento'])!!}
        </div>
    </div>
    <div class="form-group">
        {!!Form::label('titulo', 'Titulo',['class' => 'col-md-4'])!!}
        <div class="col-sm-8">
            {!!Form::text('titulo', null, ['class' => 'form-control', 'placeholder' => 'titulo del descuento'])!!}
        </div>
    </div>
    <div class="form-group">
        {!!Form::label('descripcion', 'Descripción',['class' => 'col-md-4'])!!}
        <div class="col-sm-8">
            {!!Form::text('descripcion', null, ['class' => 'form-control', 'placeholder' => 'Descripción del descuento'])!!}
        </div>
    </div>
    <div class="form-group">
        {!!Form::label('descuento', 'Descuento',['class' => 'col-md-4'])!!}
        <div class="col-sm-8">
            {!!Form::number('descuento', null, ['class' => 'form-control', 'placeholder' => 'Descuento'])!!}
        </div>
    </div>
    <div class="form-group">
        {!!Form::label('estado', 'Estado',['class' => 'col-sm-4'])!!}
        <div class="col-sm-8">
            {!!Form::checkbox('estado', null, ['class' => 'form-control'])!!}
        </div>
    </div>
</div>

