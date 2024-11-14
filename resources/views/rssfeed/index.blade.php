<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Adicionar imagens nas telas de login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <section class="container mt-3">
        <div class="row">
            <h1>Adicionar novas imagem nas telas de login</h1>
        </div>
        <div class="row">
            <form action="{{ route('create-feed') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <label for="image_priority" class="form-label">Ordem de exibição</label>
                        <input id="image_priority" name="image_priority" class="form-control" type="number">
                    </div>

                    <div class="col-md-3">
                        <label for="message_channel" class="form-label">Canal de comunicação (Por idioma)</label>
                        <select id="message_channel" name="message_channel" class="form-select form-select-md" required>
                            @foreach ($channels as $channel)
                                <option value="{{ $channel }}">{{ $channel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-7">
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

                <div class="row float-end">
                    <div class="col col-md-12 mt-3 mb-3">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <a class="btn btn-secondary" href="{{ route('feed') }}" target="_blank"
                            rel="noopener noreferrer">Visualizar feed</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <section class="container">
        @session('status')
            <div class="alert alert-{{ session('status')['type'] }} alert-dismissible fade show" role="alert">
                {{ session('status')['message'] }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endsession

        <h1>Canais de comunicação:</h1>

        @foreach ($channels as $channel)
            <h2>{{ $channel }}</h2>
            <table class="table table-striped table-bordered text-center">
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
                        $channelValues = \App\Services\XmlFeedService::getByMessageChannel($channel)
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
                            <td><a href="{{ $item->button_link }}" target="_blank" rel="noopener noreferrer">{{ $item->button_link }}</a></td>
                            <td><a href="{{ $item->img_link }}" target="_blank" rel="noopener noreferrer">{{ $item->img_link }}</a></td>
                            <td>
                                <form action="{{ route('delete-feed') }}" method="post">
                                    @csrf
                                    <input type="text" name="id" value="{{ $item->id }}" hidden>
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
