@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                @isset ($repos[0]['owner']['avatar_url'])
                        <img src="{{$repos[0]['owner']['avatar_url']}}" alt="avatar" style="width: 200px; height: 200px; margin-bottom: 20px">
                @endisset
                        <form class="form-inline" action="{{route('search')}}" method="get">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="search" class="sr-only" >Search repository</label>
                            <input type="text" name="search" class="form-control" id="search" placeholder="Enter repository name">
                            @csrf
                        </div>
                            <button type="submit" class="btn btn-primary mb-2">Search</button>
                            <a href="{{route('home')}}" style="margin-left: 20px">Reset</a>
                        </form>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Url</th>
                                <th scope="col">Score</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($repos)
                                @foreach($repos as $repo)
                            <tr>
                                <th scope="row">{{ $repo['id'] ?? 0}}</th>
                                <td><a href="{{url('/details/' . $repo['id'] ?? '')}}" target="_blank">{{ $repo['name'] ?? ''}}</a></td>
                                <td><a href="{{ $repo['owner']['html_url'] ?? ''}}"  target="_blank" >{{ $repo['owner']['html_url'] ?? '' }} </a></td>
                           {{--     <td>{{ $repo['watchers_count']}}</td>
                                <td>{{ $repo['stargazers_count']}}</td>--}}

                                <td><score :repo_id = {{ $repo['id'] ?? 0 }}  :user_score = {{$repo['score'] ?? -1}} ></score></td>
                            </tr>
                                @endforeach
                             @endif
                            </tbody>
                        </table>
                </div>
</div>
@endsection
