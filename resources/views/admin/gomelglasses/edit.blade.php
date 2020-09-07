@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('quickadmin.gomelglass.title')</h3>
    
    {!! Form::model($data, ['method' => 'PUT', 'route' => ['admin.gomelglasses.update', $data->id], 'files' => true,]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('quickadmin.qa_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    @if ($data->photo)
                        <img class="photo" src="{{ asset(env('UPLOAD_PATH').App\Gomelglass::PATH.$data->photo) }}">
                    @endif
                    {!! Form::label('photo', trans('quickadmin.gomelglass.fields.photo').'*', ['class' => 'control-label']) !!}
                    {!! Form::file('photo', ['class' => 'form-control', 'style' => 'margin-top: 4px;']) !!}
                    {!! Form::hidden('photo_max_size', 2) !!}
                    {!! Form::hidden('photo_max_width', 4096) !!}
                    {!! Form::hidden('photo_max_height', 4096) !!}
                    <p class="help-block"></p>
                    @if($errors->has('photo'))
                        <p class="help-block">
                            {{ $errors->first('photo') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('description', trans('quickadmin.gomelglass.fields.description').'*', ['class' => 'control-label']) !!}
                    {!! Form::textarea('description', old('description'), ['class' => 'form-control editor', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('description'))
                        <p class="help-block">
                            {{ $errors->first('description') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('sport', trans('quickadmin.gomelglass.fields.sport').'*', ['class' => 'control-label']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('sport'))
                        <p class="help-block">
                            {{ $errors->first('sport') }}
                        </p>
                    @endif
                    <div>
                        <label>
                            {!! Form::radio('sport', 'Настольный теннис', false, ['required' => '']) !!}
                            {{--{!! Form::radio('sport', 'tennis', false, ['required' => '']) !!}--}}
                            Настольный теннис
                        </label>
                    </div>
                    <div>
                        <label>
                            {!! Form::radio('sport', 'Лыжи', false, ['required' => '']) !!}
                            {{--{!! Form::radio('sport', 'ski', false, ['required' => '']) !!}--}}
                            Лыжи
                        </label>
                    </div>
                    <div>
                        <label>
                            {!! Form::radio('sport', 'Плавание', false, ['required' => '']) !!}
                            {{--{!! Form::radio('sport', 'swimming', false, ['required' => '']) !!}--}}
                            Плавание
                        </label>
                    </div>
                    <div>
                        <label>
                            {!! Form::radio('sport', 'Волейбол', false, ['required' => '']) !!}
                            {{--{!! Form::radio('sport', 'volleyball', false, ['required' => '']) !!}--}}
                            Волейбол
                        </label>
                    </div>
                    <div>
                        <label>
                            {!! Form::radio('sport', 'Многоборье', false, ['required' => '']) !!}
                            {{--{!! Form::radio('sport', 'multiathlon', false, ['required' => '']) !!}--}}
                            Многоборье
                        </label>
                    </div>
                    <div>
                        <label>
                            {!! Form::radio('sport', 'Шахматы', false, ['required' => '']) !!}
                            {{--{!! Form::radio('sport', 'chess', false, ['required' => '']) !!}--}}
                            Шахматы
                        </label>
                    </div>
                    <div>
                        <label>
                            {!! Form::radio('sport', 'Дартс', false, ['required' => '']) !!}
                            {{--{!! Form::radio('sport', 'darts', false, ['required' => '']) !!}                            Дартс--}}
                        </label>
                    </div>
                    <div>
                        <label>
                            {!! Form::radio('sport', 'Футбол', false, ['required' => '']) !!}
                            {{--{!! Form::radio('sport', 'football', false, ['required' => '']) !!}--}}
                            Футбол
                        </label>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>

    {!! Form::submit(trans('quickadmin.qa_update'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

@include('admin.block.editor')