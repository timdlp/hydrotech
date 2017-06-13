@extends('layouts.master')
@section('content')
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Liste des sponsors
                    </h2>
                </div>
                @if(Session::has('message'))
                    <div class="alert alert-success">
                        {{ Session::get('message') }}
                    </div>
                @endif
                <div class="body">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{route('sponsor.create')}}" target="_parent"><button type="button" class="m-b-20 btn bg-green waves-effect">NOUVEAU</button></a>
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable"
                                       id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th rowspan="1" colspan="1" style="width: 20px !important;">Action</th>
                                        @foreach($columns as $column)
                                            <th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending" style="width: 210px;">
                                                {{$column}}
                                            </th>
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1" style="width: 20px !important;">Action</th>
                                        @foreach($columns as $column)
                                        <th rowspan="1" colspan="1">{{$column}}</th>
                                        @endforeach
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    {{--*/ $i = 0 /*--}}
                                    @foreach($sponsors as $sponsor)
                                        @if($sponsor->iteration % 2 == 0)
                                            {{--*/ $class = odd /*--}}
                                        @else
                                            {{--*/ $class = even /*--}}
                                        @endif
                                        {{--*/ $i++ /*--}}
                                        <tr role="row" class="odd">
                                            <td style="width: 20px !important;">
                                                <a target="_parent" href="{{ route('sponsor.edit', $sponsor->id) }}">
                                                <button type="button" class="btn btn-primary waves-effect">
                                                    <i class="material-icons">mode_edit</i>
                                                </button>
                                                </a>
{{--
                                                <a target="_parent" href="{{action('Back_office\SponsorCtrl@destroy',$sponsor->id)}}">
--}}

                                                <form method="post" action="{{action('Back_office\SponsorCtrl@destroy', $sponsor->id)}}" accept-charset="UTF-8">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn bg-red waves-effect">
                                                    <i class="material-icons">delete</i>
                                                    </button>
                                                </form>


                                            </td>
                                            <td class="sorting_1">{{$sponsor->nom}}</td>
                                            <td><img src="{{url('/') }}/storage/sponsors/{{$sponsor->nom}}.jpg" width="50px" height="50px"/></td>
                                            <td>{{$sponsor->urlSponsor}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div><img src="https://fr.wikipedia.org/wiki/Cheval#/media/File:Mangalarga_Marchador_Conforma%C3%A7%C3%A3o.jpg" alt=""/></div>
                            </div>
                        </div>
                       </div>
                </div>
            </div>
        </div>
    </div>
@endsection