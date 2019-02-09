@extends('layouts/common')

@section('title', 'jinono')

@section('content')
    <div>
        <div class="uk-card uk-card-default uk-card-hover uk-card-body" style="overflow-x: scroll">
            <div style="display: block;width: 2000px">
            {!! $tree_view !!}
            </div>
        </div>
    </div>

@stop