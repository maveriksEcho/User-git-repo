@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

                @isset ($repos[0]['owner']['avatar_url'])
                        <img src="{{$repos[0]['owner']['avatar_url']}}" alt="avatar" style="width: 200px; height: 200px; margin-bottom: 20px">
                @endisset
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Url</th>
                                <th scope="col">Watch</th>
                                <th scope="col">Star</th>
                                <th scope="col">Likes</th>
                                <th scope="col">Dislikes</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($repo)
                            <tr>
                                <th scope="row">{{ $repo['id']}}</th>
                                <td>{{ $repo['name']}}</td>
                                <td><a href="{{ $repo['owner']['html_url']}}" >{{ $repo['owner']['html_url'] }}</a></td>
                                <td>{{ $repo['watchers_count']}}</td>
                                <td>{{ $repo['stargazers_count']}}</td>
                                <td>{{ $repo['like']}}</td>
                                <td>{{ $repo['dislike']}}</td>
                            </tr>
                             @endif
                            </tbody>
                        </table>
                </div>
</div>
@endsection
