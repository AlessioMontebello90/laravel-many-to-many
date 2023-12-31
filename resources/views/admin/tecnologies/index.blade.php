@extends('layouts.app')

@section('import-cdn')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="container mt-5">
        <a class="my-3" href="{{ route('admin.tecnologies.create') }}">
            <div class="btn btn-success">
                create new tecnologies
            </div>
        </a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">label</th>
                    <th scope="col">color</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>

            @foreach ($tecnologies as $tecnology)
                <tbody>
                    <tr>
                        <th scope="row">{{ $tecnology->id }}</th>
                        <td>{{ $tecnology->label }}</td>
                        <td>
                            <span class="badge"
                                style="background-color: {{ $tecnology->color }}">{{ $tecnology->color }}</span>
                        </td>


                        <td>
                            <div class="d-flex gap-2 my-1  justify-content-center align-items-center">
                                <a href="{{ route('admin.tecnologies.show', $tecnology) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.tecnologies.edit', $tecnology) }}">
                                    <i class="fa-solid fa-file-pen"></i>
                                </a>


                                <span class="delete-btn" data-bs-toggle="modal"
                                    data-bs-target="#modal-{{ $tecnology->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </span>


                            </div>

                        </td>
                    </tr>
                </tbody>
            @endforeach
        </table>
    </div>
@endsection

@section('modals')
    <section class="container my-5">



        <!-- Modal -->
        @foreach ($tecnologies as $tecnology)
            <div class="modal fade" id="modal-{{ $tecnology->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"> Delete
                                {{ $tecnology->label }}</h1>
                            <button tecnology="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            confirm the deletion of <span class="text-danger fw-bolder">{{ $tecnology->label }}</span>
                        </div>
                        <div class="modal-footer">
                            <button tecnology="button" class="btn btn-secondary" data-bs-dismiss="modal">Decline</button>
                            <form action="{{ route('admin.tecnologies.destroy', $tecnology) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Confirm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </section>
@endsection
