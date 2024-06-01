@extends('template')

@section('title', 'Categoria')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables-classic@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush

@section('content')
    @if (session('success'))
    <script>
        const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
        icon: "success",
        title: "Operacion exitosa"
        });
    </script>
    @endif
    @if (session('error'))
    <script>
        const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
        });
        Toast.fire({
        icon: "error",
        title: "Operacion fallida"
        });
    </script>
    @endif
    <div class="container-fluid px-4">
        <h1 class="mt-4 text-center">Categoria</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('panel')}}">Inicio</a></li>
            <li class="breadcrumb-item active">Categorias</li>
        </ol>
        <div class="mb-4">
        <a href="{{route('categorias.create')}}">
            <button type="button" class="btn btn-primary"> Añadir un nuevo Registro</button>
        </a>
        </div>       
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Tabla Categoria
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Acciones</th>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach($categorias as $categoria)
                            <tr>
                                <td>
                                    {{$categoria->caracteristica->nombre}}
                                </td>
                                <td>
                                    {{$categoria->caracteristica->descripcion}}
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic mixed styles example">

                                        <form action="{{ route('categorias.edit',['categoria'=>$categoria])}}" method="GET">
                                            @csrf
                                            <button type="submit" class="btn btn-warning">Editar</button>
                                        </form>
                                            <button type="button" class="btn btn-danger">Eliminar</button>
                                      </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables-classic@latest" type="text/javascript"></script>
    <script src="{{asset('js/datatables-simple-demo.js')}}"></script>
@endpush