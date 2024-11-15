<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adicionar imagens nas telas de login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>

<body class="content-wrapper">
    <section class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Adicionar novas imagem nas telas de login</h1>
            </div>

            <div class="card-body">
                <form action="{{ route('create-feed') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-2">
                            <label for="image_priority" class="form-label">Ordem de exibição</label>
                            <input id="image_priority" name="image_priority" class="form-control" type="number">
                        </div>

                        <div class="col-md-4">
                            <label for="message_channel" class="form-label">Canal de comunicação (Por idioma)</label>
                            <select id="message_channel" name="message_channel" class="form-control form-control-md"
                                required>
                                @foreach ($channels as $channel)
                                    <option value="{{ $channel }}">{{ $channel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="title" class="form-label">Título</label>
                            <input id="title" name="title" class="form-control" type="text">
                        </div>
                    </div>


                    <label for="subtitle" class="form-label">Subtitulo</label>
                    <input id="subtitle" name="subtitle" class="form-control" type="text">

                    <label for="button_link" class="form-label">Link do botão "Saiba mais"</label>
                    <input id="button_link" name="button_link" class="form-control" type="text">

                    <label for="img_link" class="form-label">Link da imagem</label>
                    <input id="img_link" name="img_link" class="form-control" type="text" required>

                    <div class="row float-right">
                        <div class="col col-md-12 mt-3 mb-3">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a class="btn btn-secondary" href="{{ route('feed') }}" target="_blank"
                                rel="noopener noreferrer">Visualizar feed</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section class="container">
        @session('status')
            <div class="alert alert-{{ session('status')['type'] }} alert-dismissible fade show" role="alert">
                {{ session('status')['message'] }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endsession

        <h2>Canais de comunicação</h2>

        @foreach ($channels as $channel)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $channel }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered table-sm table-valign-middle text-center">
                        <thead>
                            <tr>
                                <th scope="col">Ordem de exibição</th>
                                <th scope="col">Título</th>
                                <th scope="col">Subtitulo</th>
                                <th scope="col">Link do botão "Saiba mais"</th>
                                <th scope="col">Link da imagem</th>
                                <th scope="col">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $channelValues = \App\Services\XmlFeedService::getByMessageChannel($channel);
                            @endphp
                            @if ($channelValues->count() == 0)
                                <tr class="text-center">
                                    <td colspan="6" class="text-bold">Nenhuma imagem a ser exibida!</td>
                                </tr>
                            @endif
                            @foreach ($channelValues as $item)
                                <tr>
                                    <td>{{ $item->image_priority }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->subtitle }}</td>
                                    <td><a href="{{ $item->button_link }}" target="_blank"
                                            rel="noopener noreferrer">{{ $item->button_link }}</a></td>
                                    <td><a href="{{ $item->img_link }}" target="_blank"
                                            rel="noopener noreferrer">{{ $item->img_link }}</a></td>
                                    <td>
                                        <form action="{{ route('delete-feed') }}" method="post">
                                            @csrf
                                            <input type="text" name="id" value="{{ $item->id }}" hidden>
                                            <button class="btn btn-sm btn-danger" type="submit">Apagar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </section>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>

</html>
