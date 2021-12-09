@extends('layouts.app')

@section('content')
    @include('admin.partial.top-nav')
    <section class="d-flex">
        @include('admin.partial.left-nav')

        <div class="page-block">
            <div class="block-head">
                <h3>Редактирования документа</h3>
            </div>
            <hr>
            <div class="block-body">
                <form action="/admin/documents/{{ $document['id'] }}/update" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-4 d-flex flex-column">
                            <label for="title">Навание</label>
                            <input type="text" id="title" name="title" value="{{ $document->title }}">
                        </div>
                        <div class="col-4 d-flex flex-column">
                            <label for="status">Статус</label>
                            <input type="text" id="status" name="status" value="{{ $document->status }}">
                        </div>
                        <div class="col-4 d-flex flex-column">
                            <label for="cadastral_number">Кадастровый номер</label>
                            <input type="text" id="cadastral_number" name="cadastral_number" value="{{ $document->cadastral_number }}">
                        </div>
                    </div>
                    <div class="mt-5 d-flex">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                        <a href="/admin/documents/{{ $document['id'] }}/delete" class="btn btn-danger ml-4">Удалить</a>
                    </div>
                </form>
            </div>

            @if(!empty($document->cadastral_number_data))
                <div class="block-head">
                    <h3>Данные по объекту</h3>
                </div>
                <hr>
                <div class="block-body">
                    @dump(json_decode($document->cadastral_number_data))
                </div>
            @endif

            <div class="block-head">
                <h3>Список пользователей в документе</h3>
            </div>
            <hr>
            <div class="block-body">
                <table class="w-100 mt-4">
                    <tr>
                        <th style="width: 45%">Пользователь</th>
                        <th style="width: 35%">Роль</th>
                        <th style="width: 15%">Действия</th>
                    </tr>
                    @foreach($document->users as $user)
                        <tr>
                            <td class="py-2">{{ $user->surname }} {{ $user->name }}</td>
                            <td class="py-2">{{$user->pivot->user_role}}</td>
                            <td class="d-flex py-2">
                                <a href="/" class="mr-4 btn btn-info" type="button" data-toggle="modal" data-target="#modal-{{ $user->id }}">Редактировать</a>
                                <a href="/admin/documents/{{ $document['id'] }}/user/{{ $user->id }}/delete" class="btn btn-danger">Удалить</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="mt-2">
                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#addModal">Добавить пользователя</button>
                    <!-- Добавление нового пользователя -->
                    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Добавить пользователя</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="/admin/documents/{{ $document['id'] }}/user/create" method="POST">
                                        @csrf
                                        <div class="form-group d-flex flex-column">
                                            <label for="users">Пользователь:</label>
                                            <select name="user_id" id="users" class="custom-select" required>
                                                @foreach($users as $user)
                                                    <option value="{{ $user['id'] }}"
                                                            @if($loop->first) selected @endif>{{ $user['surname'] }} {{ $user['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group d-flex flex-column">
                                            <label for="user_role">Роль:</label>
                                            <select name="user_role" id="user_role" class="custom-select" required>
                                                <option value="1" selected>1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                                            <button type="submit" class="btn btn-success">Сохранить</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Редактирование документа -->
            <div class="block-head">
                <h3>Редактирования текста документа</h3>
            </div>
            <hr>
            <div class="block-body">
                <div class="row">
                    <div class="col-4 d-flex align-items-center mb-4">
                        <p class="mb-0"><a href="#modal-history-1" data-toggle="modal" data-target="#modal-history-1" class="font-weight-bold">Блок 1</a></p>
                    </div>
                    <div class="col-8 mb-4">
                        @if(!empty($document->inputs()->latest()->where('position', 1)->first()))
                            <p class="mb-0"><a href="#modal-document-content" data-toggle="modal" data-target="#modal-document-content">{{ $document->inputs()->latest()->where('position', 1)->first()->content }}</a></p>
                        @else
                            <p class="mb-0"><a href="#modal-document-content" data-toggle="modal" data-target="#modal-document-content">Пока информации нет.</a></p>
                        @endif
                    </div>
                    <div class="col-4 mb-4 d-flex align-items-center">
                        <p class="mb-0"><a href="#modal-history-2" data-toggle="modal" data-target="#modal-history-2" class="font-weight-bold">Блок 2</a></p>
                    </div>
                    <div class="col-8 mb-4">
                        @if(!empty($document->inputs()->latest()->where('position', 2)->first()))
                            <p class="mb-0"><a href="#modal-document-content" data-toggle="modal" data-target="#modal-document-content">{{ $document->inputs()->latest()->where('position', 2)->first()->content }}</a></p>
                        @else
                            <p class="mb-0"><a href="#modal-document-content" data-toggle="modal" data-target="#modal-document-content">Пока информации нет.</a></p>
                        @endif
                    </div>
                    <div class="col-12">
                        <a href="/admin/documents/{{ $document->id }}/generate" class="btn btn-info">Выгрузить PDF</a>
                    </div>
                </div>
            </div>
            <!-- История редактирования документа -->
            <div class="block-head">
                <h3>Информация по редактированию текста документа</h3>
            </div>
            <hr>
            <div class="block-body">
                <table class="w-100">
                    <tr>
                        <th style="width: 20%">Пользователь</th>
                        <th style="width: 10%">Блок информации</th>
                        <th style="width: 5%">Статус</th>
                        <th style="width: 50%">Текст</th>
                        <th style="width: 25%">Дата</th>
                    </tr>
                    @foreach($document->inputs()->latest()->get() as $input)
                    <tr>
                        <td style="width: 20%" class="py-2">{{ $input->user()->first()->surname }} {{ $input->user()->first()->name }}</td>
                        <td style="width: 10%" class="py-2">{{ $input->position }}</td>
                        <td style="width: 5%" class="py-2">{{ $input->status }}</td>
                        <td style="width: 50%" class="py-2">
                            @if(strlen(strip_tags($input->content)) > 250)
                            {!! substr(rtrim(substr(strip_tags($input->content), 0, 250), "!,.-"), 0, strrpos(rtrim(substr(strip_tags($input->content), 0, 250), "!,.-"), ' '))  !!} ...
                            @else
                                {!! $input->content !!}
                            @endif
                        </td>
                        <td style="width: 25%" class="py-2">
                            {{ date_format($input->updated_at, 'Y-m-d H:i:s') }}
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </section>
    <!-- Редактирование пользователей -->
    @foreach($document->users as $user)
        <div class="modal fade" id="modal-{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Редактировать пользователя</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="/admin/documents/{{ $document['id'] }}/user/update" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->pivot->user_id }}">
                            <div class="form-group d-flex flex-column">
                                <label for="user_role">Роль:</label>
                                <select name="user_role" id="user_role" class="custom-select" required>
                                    <option value="1" @if($user->pivot->user_role == 1) selected @endif>1</option>
                                    <option value="2" @if($user->pivot->user_role == 2) selected @endif>2</option>
                                    <option value="3" @if($user->pivot->user_role == 3) selected @endif>3</option>
                                </select>
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                                <button type="submit" class="btn btn-success">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- Добавления блока документа -->
    <div class="modal fade" id="modal-document-content" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавить блок информации</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/admin/documents/{{ $document['id'] }}/input/create" method="POST">
                        @csrf
                        <input type="hidden" name="status" value="1">
                        <input type="hidden" name="document_id" value="{{ $document['id'] }}">
                        <div class="form-group d-flex flex-column">
                            <label for="position-modal">Блок:</label>
                            <select name="position" id="position-modal" class="custom-select" required>
                                <option value="">Не выбрано</option>
                                <option value="1">Блок 1</option>
                                <option value="2">Блок 2</option>
                            </select>
                        </div>
                        <div class="form-group d-flex flex-column">
                            <label for="user_id">Пользователь:</label>
                            <select name="user_id" id="user_id" class="custom-select" required>
                                <option value="">Не выбрано</option>
                                @foreach($document->users as $user)
                                    <option value="{{ $user->id }}">{{ $user->surname }} {{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-flex flex-column">
                            <label for="content-modal">Текст:</label>
                            <textarea class="form-control" name="content" id="content-modal"></textarea>
                        </div>
                        <div>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Закрыть</button>
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @for($number = 1; $number <= 2; $number++)
        <div class="modal fade modal-history" id="modal-history-{{ $number }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">История по блоку {{ $number }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="w-100">
                            <tr>
                                <th style="width: 20%">Пользователь</th>
                                <th style="width: 10%">Статус</th>
                                <th style="width: 45%">Текст</th>
                                <th style="width: 25%">Дата</th>
                            </tr>
                            @foreach($document->inputs()->latest()->where('position', $number)->get() as $input)
                                <tr>
                                    <td style="width: 20%" class="py-2">{{ $input->user()->first()->surname }} {{ $input->user()->first()->name }}</td>
                                    <td style="width: 10%" class="py-2">{{ $input->status }}</td>
                                    <td style="width: 45%" class="py-2">
                                        @if(strlen(strip_tags($input->content)) > 250)
                                            {!! substr(rtrim(substr(strip_tags($input->content), 0, 250), "!,.-"), 0, strrpos(rtrim(substr(strip_tags($input->content), 0, 250), "!,.-"), ' '))  !!} ...
                                        @else
                                            {!! $input->content !!}
                                        @endif
                                    </td>
                                    <td style="width: 25% class="py-2">
                                        {{ date_format($input->updated_at, 'Y-m-d H:i:s') }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endfor
@endsection
